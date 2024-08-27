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

        //CRIAR O CHECKOUT
        $checkout = Helper::createCheckouSumup();
        //CRIAR O PAGAMENTO
        $pagamento = Helper::createPagamento($request, $checkout);

        if (isset($pagamento->param) && $pagamento->param == "$.card.cvv") {
            session()->flash('msg', ['valor' => trans("O Código de segurança informado é inválido Verifique o código e tente novamente."), 'tipo' => 'danger']);
            
            return back()->withInput(request()->all());
        } elseif (isset($pagamento->param) && $pagamento->param == "$.card.number") {
            session()->flash('msg', ['valor' => trans("O Número do cartão informado é inválido! Verifique o número do cartão e tente novamente."), 'tipo' => 'danger']);
            
            return back()->withInput(request()->all());
        }
        
        $cartaoController = new CartaoController();
        $cartao = $cartaoController->store($request);
        
        $pagamentoController = new PagamentoController();

        if (isset($pagamento->status) && $pagamento->status == "FAILED") {
            $assinatura = $this->store($cartao, $pagamento->transactions[0]->transaction_code, $request->nome_titular, "NEGADA", "Cartão negado realizar a assinatura.");
            $pagamentoController->store($cartao->user_id, $cartao->id, $assinatura->id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'NEGADO');
            
            return redirect()->route('callback.payment.assinatura', ['checkout_id' => $pagamento->id]);
        } elseif (isset($pagamento->status) && $pagamento->status == "PAID") {
            $assinatura = $this->store($cartao, $pagamento->transactions[0]->transaction_code, $request->nome_titular, "APROVADA");
            $pagamentoController->store($cartao->user_id, $cartao->id, $assinatura->id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'APROVADO');

            return redirect()->route('callback.payment.assinatura', ['checkout_id' => $pagamento->id]);
        } elseif (isset($pagamento->next_step)) {
            $assinatura = $this->store($cartao, $pagamento->next_step->current_transaction->transaction_code, $request->nome_titular);
            $pagamentoController->store($cartao->user_id, $cartao->id, $assinatura->id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->next_step->current_transaction->transaction_code, 'PENDENTE');

            return redirect($pagamento->next_step->url);
        }        
    }

    public function callbackPaymentAssinatura(Request $request)
    {
        //RECUPERAR CHECKOUT E PAGAMENTO
        $response = Helper::getCheckout($request->checkout_id);
        $assinatura = Assinatura::where('transaction_code', $response->transactions[0]->transaction_code)->first();
        $cartao = Cartao::find($assinatura->cartao_id);

        if ($response->status == 'FAILED') {
            $cartaoController = new CartaoController();
            $cartaoController->update($assinatura->cartao_id, "NEGADO", null);
            $this->update($assinatura->id, $response->transactions[0]->transaction_code, "NEGADA", "Cartão negado.");
            
            $pagamentoController = new PagamentoController();
            $pagamentoController->update($response->transactions[0]->transaction_code, 'NEGADO');

            session()->flash('msg', ['valor' => trans("Não foi possível realizar a renovação da assinatura da plataforma com o cartão informado! Informe um novo cartão e tente novamente."), 'tipo' => 'danger']);

            return redirect()->route('cartao.create', ['usuario_id' => $cartao->user_id]);
        } else if ($response->status == 'PAID') {
            $cartaoController = new CartaoController();
            $cartaoController->update($assinatura->cartao_id, "APROVADO", "S");
            $this->update($assinatura->id, $response->transactions[0]->transaction_code, "APROVADA");

            $pagamentoController = new PagamentoController();
            $pagamentoController->update($response->transactions[0]->transaction_code, 'APROVADO');
            
            $user = User::find($cartao->user_id);
            $user->etapa_cadastro = 'F';
            $user->save();
            
            Auth::loginUsingId($user->id);
            session()->flash('msg', ['valor' => trans("Seu cadastro e assinatura da plataforma foram realizados com sucesso!"), 'tipo' => 'success']);
            return redirect()->route('home');
        }
        session()->flash('msg', ['valor' => trans("Não foi possível realizar a renovação da assinatura da plataforma com o cartão informado! Informe um novo cartão e tente novamente."), 'tipo' => 'danger']);

        return redirect()->route('cartao.create', ['usuario_id' => $cartao->user_id]);
    }

    public function store($cartao, $transaction_code, $assinante, $status = "PENDENTE", $motivo = null)
    {
        try {
            date_default_timezone_set('America/Sao_Paulo');
            $dataLocal = date('Y-m-d', time());
            //CASO FOR NECESSÁRIO CADASTRAR UM NOVO CARTÃO PARA RENOVAR A ASSINATURA
            $assinatura = Assinatura::where('user_id', $cartao->user_id)->first();
            if(!empty($assinatura)) {
                $cartaoController = new CartaoController();
                $cartaoController->update($assinatura->cartao_id, "NEGADO", null);
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
            $assinatura->situacao = $status == "APROVADA" ? "ATIVA" : ($status == "NEGADA" ? "CANCELADA" : null);
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
            $assinatura->data_renovacao = ($status == "APROVADA" ? Helper::addMonthsToDate($dataLocal, 1) : $assinatura->data_renovacao);
            $assinatura->status = $status;
            $assinatura->mes_referencia = ($status == "APROVADA" ? date("m", strtotime(Helper::addMonthsToDate($dataLocal, 1))) : $assinatura->mes_referencia);
            $assinatura->transaction_code = $transaction_code;
            $assinatura->motivo = $motivo;
            $assinatura->situacao = ($status == "APROVADA" ? "ATIVA" : "CANCELADA");
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
            $assinatura = Assinatura::where('user_id', $usuario->id)->where('status', 'APROVADA')->where('situacao', 'ATIVA')->first();
            if ($assinatura) {
                $cartao = Cartao::where('id', $assinatura->cartao_id)->where('principal', 'S')->where('status', 'APROVADO')->first();
                
                date_default_timezone_set('America/Sao_Paulo');
                $dataLocal = date('Y-m-d', time());
                
                if ($dataLocal >= $assinatura->data_renovacao && isset($cartao)) {
                    //CANCELAR ASSINATURA
                    $assinatura->situacao = "CANCELADA";
                    $assinatura->save();
                    
                    //CRIAR O CHECKOUT
                    $checkout = Helper::createCheckouSumup(true);
                    //CRIAR A RENOVAÇÂO DE PAGAMENTO
                    $pagamento = Helper::renovarPagamento($cartao, $checkout);

                    $pagamentoController = new PagamentoController();
                    
                    if (isset($pagamento->status) && $pagamento->status == "FAILED") {
                        $this->update($assinatura->id, $pagamento->transactions[0]->transaction_code, "RENOVAÇÂO PENDENTE", "Cartão negado para renovar a assinatura.");
                        $pagamentoController->store($cartao->user_id, $cartao->id, $assinatura->id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'NEGADO');
                    } elseif (isset($pagamento->status) && $pagamento->status == "PAID") {
                        $this->update($assinatura->id, $pagamento->transactions[0]->transaction_code, "APROVADA");
                        $pagamentoController->store($cartao->user_id, $cartao->id, $assinatura->id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'APROVADO');
                    } elseif (isset($pagamento->next_step)) {
                        $this->update($assinatura->id, $pagamento->next_step->current_transaction->transaction_code, "RENOVAÇÂO PENDENTE");
                    }
                }
            }
        }
    }

    public function renovacaoManual($assinatura_id)
    {
        $assinatura = Assinatura::find($assinatura_id);
        if ($assinatura) {
            $cartao = Cartao::where('id', $assinatura->cartao_id)->where('principal', 'S')->where('status', 'APROVADO')->first();
            
            date_default_timezone_set('America/Sao_Paulo');
            $dataLocal = date('Y-m-d', time());
            
            if ($dataLocal >= $assinatura->data_renovacao && $cartao) {
                //CANCELAR ASSINATURA
                $assinatura->situacao = "CANCELADA";
                $assinatura->save();

                //CRIAR O CHECKOUT
                $checkout = Helper::createCheckouSumup(true);
                //CRIAR A RENOVAÇÂO DE PAGAMENTO
                $pagamento = Helper::renovarPagamento($cartao, $checkout);
                
                $pagamentoController = new PagamentoController();

                if (isset($pagamento->status) && $pagamento->status == "FAILED") {
                    $this->update($assinatura->id, $pagamento->transactions[0]->transaction_code, "RENOVAÇÂO PENDENTE", "Cartão negado para renovar a assinatura.");
                    $pagamentoController->store($cartao->user_id, $cartao->id, $assinatura->id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'NEGADO');

                    return false;
                } elseif (isset($pagamento->status) && $pagamento->status == "PAID") {
                    $this->update($assinatura->id, $pagamento->transactions[0]->transaction_code, "APROVADO");
                    $pagamentoController->store($cartao->user_id, $cartao->id, $assinatura->id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->transactions[0]->transaction_code, 'APROVADO');
                    
                    return true;
                } elseif (isset($pagamento->next_step)) {
                    $this->update($assinatura->id, $pagamento->next_step->current_transaction->transaction_code, "RENOVAÇÂO PENDENTE");
                    $pagamentoController->store($cartao->user_id, $cartao->id, $assinatura->id, floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))), $pagamento->next_step->current_transaction->transaction_code, 'PENDENTE');

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
            $cartaoController->update($assinatura->cartao_id, "NEGADO", null);
            $this->update($assinatura->id, $response->transactions[0]->transaction_code, "NEGADA", "Cartão negado para renovar a assinatura.");

            $pagamentoController->update($response->transactions[0]->transaction_code, 'NEGADO');
            
            session()->flash('msg', ['valor' => trans("Não foi possível renovar a assinatura com o cartão cadastrado. Informe um novo cartão para continuar a utilizar os serviços da plataforma."), 'tipo' => 'danger']);
            
            return redirect()->route('cartao.create', ['usuario_id' => $cartao->user_id]);
        } else if ($response->status == 'PAID') {
            $cartaoController = new CartaoController();
            $cartaoController->update($assinatura->cartao_id, "APROVADO", "S");
            $this->update($assinatura->id, $response->transactions[0]->transaction_code, "APROVADA");
            
            $pagamentoController->update($response->transactions[0]->transaction_code, 'APROVADO');
            
            $user = User::find($cartao->user_id);
            $user->etapa_cadastro = 'F';
            $user->save();
            
            Auth::loginUsingId($user->id);
            session()->flash('msg', ['valor' => trans("Sua assinatura foi renovada com sucesso!"), 'tipo' => 'success']);
            return redirect()->route('home');
        }
        session()->flash('msg', ['valor' => trans("Não foi possível renovar a assinatura com o cartão cadastrado. Informe um novo cartão para continuar a utilizar os serviços da plataforma."), 'tipo' => 'danger']);

        return redirect()->route('cartao.create', ['usuario_id' => $cartao->user_id]);
    }

    public function getAssinatura($user_id)
    {
        $assinatura = Assinatura::where('user_id', $user_id)->first();

        return $assinatura;
    }
}
