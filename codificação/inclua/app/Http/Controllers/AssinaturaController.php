<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Assinatura;
use App\Models\Cartao;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\MercadoPagoConfig;

class AssinaturaController extends Controller
{
    public function lancarAssinatura(Request $request)
    {
        $rules = [
            "numero_cartao" => "required|min:19",
            "validade" => "required",
            "codigo_seguranca" => "required|min:3",
            "nome_titular" => "required|min:5"
        ];
        $feedbacks = [
            "numero_cartao.required" => "O campo Número do cartão é obrigatório.",
            "numero_cartao.min" => "O campo Número do cartão deve ter no mínimo 16 dígitos.",
            "validade.required" => "O campo Validade é obrigatório.",
            "codigo_seguranca.required" => "O campo Código de segurança é obrigatório.",
            "codigo_seguranca.min" => "O campo codigo_seguranca deve ter 3 dígitos.",
            "nome_titular.required" => "O campo Nome do titular é obrigatório.",
            "nome_titular.min" => "O campo Nome do titular deve ter no mínimo 5 caracteres.",
        ];
        $request->validate($rules, $feedbacks);

        $cartaoController = new CartaoController();
        $cartao = $cartaoController->store($request);

        //CRIAR O CHECKOUT
        $checkout = Helper::createCheckoutSumup();
        //CRIAR O PAGAMENTO
        $pagamento = Helper::createPagamento($cartao, $checkout);



        if (isset($pagamento->param) && $pagamento->param == "$.card.cvv") {
            session()->flash('msg', ['valor' => trans("O Código de segurança informado é inválido Verifique o código e tente novamente."), 'tipo' => 'danger']);
            $cartao->delete();

            return back()->withInput(request()->all());
        } elseif (isset($pagamento->param) && $pagamento->param == "$.card.number") {
            session()->flash('msg', ['valor' => trans("O Número do cartão informado é inválido! Verifique o número do cartão e tente novamente."), 'tipo' => 'danger']);
            $cartao->delete();

            return back()->withInput(request()->all());
        }

        $pagamentoController = new PagamentoController();

        if (isset($pagamento->status) && $pagamento->status == "FAILED") {
            $assinatura = $this->store($cartao, $pagamento->transactions[0]->transaction_code, $request->nome_titular, "Negada", "Cartão negado realizar a assinatura.");
            $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'Negado', 'Assinatura');

            return redirect()->route('callback.payment.assinatura', ['checkout_id' => $pagamento->id]);
        } elseif (isset($pagamento->status) && $pagamento->status == "PAID") {
            $assinatura = $this->store($cartao, $pagamento->transactions[0]->transaction_code, $request->nome_titular, "Aprovada");
            $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'Aprovado', 'Assinatura');

            return redirect()->route('callback.payment.assinatura', ['checkout_id' => $pagamento->id]);
        } elseif (isset($pagamento->next_step)) {
            $assinatura = $this->store($cartao, $pagamento->next_step->current_transaction->transaction_code, $request->nome_titular);
            $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->next_step->current_transaction->transaction_code, 'Pendente', 'Assinatura');

            return redirect($pagamento->next_step->url);
        }
    }

    public function callbackPaymentAssinatura(Request $request)
    {


        //RECUPERAR CHECKOUT E PAGAMENTO
        $response = Helper::getCheckout($request->checkout_id);
        $assinatura = Assinatura::where('transaction_code', $response->transactions[0]->transaction_code)->first();
        $cartao = Cartao::find($assinatura->cartao_id);
        $pagamentoController = new PagamentoController();
       // dd($response);
        if ($response->status == 'FAILED') {
            $cartaoController = new CartaoController();
            $cartaoController->update($assinatura->cartao_id, "Negado", null);
            $this->update($assinatura->id, $response->transactions[0]->transaction_code, "Negada", "Cartão negado.");

            $pagamentoController->update($response->transactions[0]->transaction_code, 'Negado');

            session()->flash('msg', ['valor' => trans("Não foi possível realizar a  assinatura da plataforma com o cartão informado! Informe um novo cartão e tente novamente."), 'tipo' => 'danger']);

            return redirect()->route('cartao.create', ['usuario_id' => $cartao->user_id]);
        } else if ($response->status == 'PAID') {
            $cartaoController = new CartaoController();
            $cartaoController->update($assinatura->cartao_id, "Aprovado", "S");
            $this->update($assinatura->id, $response->transactions[0]->transaction_code, "Aprovada");

            $pagamentoController->update($response->transactions[0]->transaction_code, 'Aprovado');

            $user = User::find($cartao->user_id);
            $user->etapa_cadastro = 'F';
            $user->save();

            if (Auth::user()) {
                session()->flash('msg', ['valor' => trans("Sua assinatura foi realizada com sucesso! Agora todos os serviços da plaforma Inclua estão disponíveis."), 'tipo' => 'success']);

                return redirect()->route('paciente.financeiro');
            } else {
                session()->flash('msg', ['valor' => trans("Seu cadastro e assinatura da plataforma foram realizados com sucesso! Bem vindo a plataforma Inclua"), 'tipo' => 'success']);
                Auth::loginUsingId($user->id);
                session()->flash('wellcome', true);

                return redirect()->route('home');
            }
        }
        session()->flash('msg', ['valor' => trans("Não foi possível realizar a assinatura da plataforma com o cartão informado! Informe um novo cartão e tente novamente."), 'tipo' => 'danger']);

        return redirect()->route('cartao.create', ['usuario_id' => $cartao->user_id]);
    }

    public function store($cartao, $transaction_code, $assinante, $status = "Pendente", $motivo = null)
    {
        try {
            date_default_timezone_set('America/Sao_Paulo');
            $dataLocal = date('Y-m-d', time());
            //CASO FOR NECESSÁRIO CADASTRAR UM NOVO CARTÃO PARA RENOVAR A ASSINATURA
            $assinatura = Assinatura::where('user_id', $cartao->user_id)->first();
            if(!empty($assinatura)) {
                $cartaoController = new CartaoController();
                $cartaoController->update($assinatura->cartao_id, "Negado", null);
            } else {
                $assinatura = new Assinatura();
            }
            $assinatura->user_id = $cartao->user_id;
            $assinatura->cartao_id = $cartao->id;
            $assinatura->data_renovacao = Helper::addMonthsToDate($dataLocal, 1);
            $assinatura->status = $status;
            $assinatura->assinante = $assinante;
            $assinatura->mes_referencia = date("m", strtotime(Helper::addMonthsToDate($dataLocal, 1)));
            $assinatura->transaction_code = $transaction_code;
            $assinatura->motivo = $motivo;
            $assinatura->situacao = $status == "Aprovada" ? "Ativa" : ($status == "Negada" ? "Cancelada" : null);
            $assinatura->save();

            return $assinatura;
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }

    public function update($id_assinatura, $transaction_code, $status, $motivo = null) {
        try {
            date_default_timezone_set('America/Sao_Paulo');
            $dataLocal = date('Y-m-d', time());

            $assinatura = Assinatura::find($id_assinatura);
            $assinatura->data_renovacao = ($status == "Aprovada" ? Helper::addMonthsToDate($dataLocal, 1) : $assinatura->data_renovacao);
            $assinatura->status = $status;
            $assinatura->mes_referencia = ($status == "Aprovada" ? date("m", strtotime(Helper::addMonthsToDate($dataLocal, 1))) : $assinatura->mes_referencia);
            $assinatura->transaction_code = $transaction_code;
            $assinatura->motivo = $motivo;
            $assinatura->situacao = ($status == "Aprovada" ? "Ativa" : "Cancelada");
            $assinatura->save();
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }

    public function renovacaoAutomatica()
    {
        $usuarios = User::where('tipo_user', 'P')->get();
        //PERCORRER TODOS PACIENTES CADASTRADOS PARA RENOVAR ASSINATURA
        foreach ($usuarios as $usuario) {
            $assinatura = Assinatura::where('user_id', $usuario->id)->where('status', 'Aprovada')->where('situacao', 'Ativa')->first();
            if ($assinatura) {
                $cartao = Cartao::where('id', $assinatura->cartao_id)->where('principal', 'S')->where('status', 'Aprovado')->first();

                date_default_timezone_set('America/Sao_Paulo');
                $dataLocal = date('Y-m-d', time());

                if ($dataLocal >= $assinatura->data_renovacao && isset($cartao)) {
                    //CANCELAR ASSINATURA
                    $assinatura->situacao = "Cancelada";
                    $assinatura->save();

                    //CRIAR O CHECKOUT
                    $checkout = Helper::createCheckoutSumup(true);
                    //CRIAR A RENOVAÇÂO DE PAGAMENTO
                    $pagamento = Helper::createPagamento($cartao, $checkout);

                    $pagamentoController = new PagamentoController();

                    if (isset($pagamento->status) && $pagamento->status == "FAILED") {
                        $this->update($assinatura->id, $pagamento->transactions[0]->transaction_code, "Renovação pendente", "Cartão negado para renovar a assinatura.");
                        $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'Negado', 'Renovação da assinatura');
                    } elseif (isset($pagamento->status) && $pagamento->status == "PAID") {
                        $this->update($assinatura->id, $pagamento->transactions[0]->transaction_code, "Aprovada");
                        $pagamentoController->store($cartao->user_id,  floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'Aprovado', 'Renovação da assinatura');
                    } elseif (isset($pagamento->next_step)) {
                        $this->update($assinatura->id, $pagamento->next_step->current_transaction->transaction_code, "Renovação pendente");
                    }
                }
            }
        }
    }

    public function renovacaoManual($cartao_id)
    {
        $user = Auth::user();
        $assinatura = Assinatura::where('user_id', $user->id)->first();
        if ($assinatura) {
            $cartao = Cartao::where('id', $cartao_id)->first();

            date_default_timezone_set('America/Sao_Paulo');
            $dataLocal = date('Y-m-d', time());

            if ($dataLocal >= $assinatura->data_renovacao && $cartao) {
                //CANCELAR ASSINATURA
                $assinatura->situacao = "Cancelada";
                $assinatura->save();

                //CRIAR O CHECKOUT
                $checkout = Helper::createCheckoutSumup(true);
                //CRIAR A RENOVAÇÂO DE PAGAMENTO
                $pagamento = Helper::createPagamento($cartao, $checkout);

                $pagamentoController = new PagamentoController();

                if (isset($pagamento->status) && $pagamento->status == "FAILED") {
                    $this->update($assinatura->id, $pagamento->transactions[0]->transaction_code, "Renovação pendente", "Cartão negado para renovar a assinatura.");
                    $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'Negado', 'Renovação da assinatura');

                    return false;
                } elseif (isset($pagamento->status) && $pagamento->status == "PAID") {
                    $this->update($assinatura->id, $pagamento->transactions[0]->transaction_code, "Aprovado");
                    $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'Aprovado', 'Renovação da assinatura');

                    return true;
                } elseif (isset($pagamento->next_step)) {
                    $this->update($assinatura->id, $pagamento->next_step->current_transaction->transaction_code, "Renovação pendente");
                    $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->next_step->current_transaction->transaction_code, 'Pendente', 'Renovação da assinatura');

                    return redirect($pagamento->next_step->url);
                }
            }
        }
    }

    public function callbackPaymentRenovarAssinatura(Request $request)
    {
        //RECUPERAR CHECKOUT E PAGAMENTO
        $response = Helper::getCheckout($request->checkout_id);
        $assinatura = Assinatura::where('transaction_code', $response->transactions[0]->transaction_code)->first();
        $cartao = Cartao::find($assinatura->cartao_id);

        $pagamentoController = new PagamentoController();

        if ($response->status == 'FAILED') {
            $cartaoController = new CartaoController();
            $cartaoController->update($assinatura->cartao_id, "Negado", null);
            $this->update($assinatura->id, $response->transactions[0]->transaction_code, "Negada", "Cartão negado para renovar a assinatura.");

            $pagamentoController->update($response->transactions[0]->transaction_code, 'Negado');


            if (Auth::user()) {
                session()->flash('msg', ['valor' => trans("Não foi possível renovar a assinatura com o cartão."), 'tipo' => 'danger']);

                return redirect()->route('paciente.financeiro');
            } else {
                session()->flash('msg', ['valor' => trans("Não foi possível renovar a assinatura com o cartão cadastrado. Informe um novo cartão para continuar a utilizar os serviços da plataforma."), 'tipo' => 'danger']);

                return redirect()->route('cartao.create', ['usuario_id' => $cartao->user_id]);
            }
        } else if ($response->status == 'PAID') {
            $cartaoController = new CartaoController();
            $cartaoController->update($assinatura->cartao_id, "Aprovado", "S");
            $this->update($assinatura->id, $response->transactions[0]->transaction_code, "Aprovada");

            $pagamentoController->update($response->transactions[0]->transaction_code, 'Aprovado');

            $user = User::find($cartao->user_id);
            $user->etapa_cadastro = 'F';
            $user->save();

            session()->flash('msg', ['valor' => trans("Sua assinatura foi renovada com sucesso!"), 'tipo' => 'success']);

            if (Auth::user()) {
                return redirect()->route('paciente.financeiro');
            } else {
                Auth::loginUsingId($user->id);
                session()->flash('wellcome', true);

                return redirect()->route('home');
            }
        }
        session()->flash('msg', ['valor' => trans("Não foi possível renovar a assinatura com o cartão cadastrado. Informe um novo cartão para continuar a utilizar os serviços da plataforma."), 'tipo' => 'danger']);

        return redirect()->route('cartao.create', ['usuario_id' => $cartao->user_id]);
    }

    public function getAssinatura($user_id)
    {
        $assinatura = Assinatura::where('user_id', $user_id)->first();

        return $assinatura;
    }

    public function selecionarCartao()
    {
        $user = Auth::user();

        $cartaoController = new CartaoController();
        $cartoes = $cartaoController->getCartoes($user->id, 8);

        return view('userPaciente.financeiro.selecionar_cartao', ['user' => $user, 'cartoes' => $cartoes]);
    }

    public function renovarAssinaturaCartao(Cartao $cartao)
    {
        $response = $this->renovacaoManual($cartao->id);
        return $response;
    }
}
