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
        //CRIAR O CHECKOUT
        $checkout = Helper::createCheckouSumup();
        //CRIAR O PAGAMENTO
        $pagamento = Helper::createPagamento($request, $checkout);

        if (isset($pagamento->param) && $pagamento->param == "$.card.cvv") {
            session()->flash('msg', ['valor' => trans("O Código de segurança informado é inválido! Verifique o código e tente novamente."), 'tipo' => 'danger']);
            
            return back()->withInput(request()->all());
        } elseif (isset($pagamento->param) && $pagamento->param == "$.card.number") {
            session()->flash('msg', ['valor' => trans("O Número do cartão informado é inválido! Verifique o número do cartão e tente novamente."), 'tipo' => 'danger']);
            
            return back()->withInput(request()->all());
        }
        
        $cartaoController = new CartaoController();
        $id_cartao = $cartaoController->store($request);

        if (isset($pagamento->status) && $pagamento->status == "FAILED") {
            $this->store($id_cartao, $pagamento->transactions[0]->transaction_code, User::find($request->id_usuario)->nome_completo);
            
            return redirect()->route('callback.payment', ['checkout_id' => $pagamento->id]);
        } elseif (isset($pagamento->status) && $pagamento->status == "PAID") {
            $this->store($id_cartao, $pagamento->transactions[0]->transaction_code, User::find($request->id_usuario)->nome_completo);

            return redirect()->route('callback.payment', ['checkout_id' => $pagamento->id]);
        } elseif (isset($pagamento->next_step)) {
            $this->store($id_cartao, $pagamento->next_step->current_transaction->transaction_code, User::find($request->id_usuario)->nome_completo);

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
            $cartao->status = 'NEGADO';
            $cartao->save();
            $assinatura->status = "NEGADA";
            $assinatura->motivo = "Cartão negado";
            $assinatura->save();

            session()->flash('msg', ['valor' => trans("Não foi possível realizar o cadastro e a assinatura da plataforma com o cartão informado! Informe um novo cartão e tente novamente."), 'tipo' => 'danger']);

            return redirect()->route('cartao.create', ['id_usuario' => $cartao->user_id]);
        } else if ($response->status == 'PAID') {
            $cartao->status = 'APROVADO';
            $cartao->principal = 'S';
            $cartao->save();
            $assinatura->status = "APROVADA";
            $assinatura->situacao = "ATIVA";
            $assinatura->save();

            $pagamentoController = new PagamentoController();
            $pagamentoController->store($cartao->user_id, $cartao->id, $assinatura->id, $response->amount);
            
            $user = User::find($cartao->user_id);
            $user->etapa_cadastro = 'F';
            $user->save();
            
            Auth::loginUsingId($user->id);
            session()->flash('msg', ['valor' => trans("Seu cadastro e assinatura da plataforma foram realizados com sucesso!"), 'tipo' => 'success']);
            return redirect()->route('home');
        }
    }

    public function store($cartao_id, $transaction_code, $assinante)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataLocal = date('Y-m-d', time());
        $assinatura = new Assinatura();
        $assinatura->cartao_id = $cartao_id;
        $assinatura->data_renovacao = Helper::addMonthsToDate($dataLocal, 1);
        $assinatura->status = "PENDENTE";
        $assinatura->assinante = $assinante;
        $assinatura->mes_referencia = date("m", strtotime(Helper::addMonthsToDate($dataLocal, 1)));
        $assinatura->transaction_code = $transaction_code;
        $assinatura->save();
    }
}
