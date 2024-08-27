<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Pagamento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    public function store($user_id, $cartao_id, $assinatura_id, $valor, $transaction_code, $status)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataLocal = date('Y-m-d', time());
        try {
            $pagamento = new Pagamento();
            $pagamento->user_id = $user_id;
            $pagamento->cartao_id = $cartao_id;
            $pagamento->assinatura_id = $assinatura_id;
            $pagamento->data_pagamento = $dataLocal;
            $pagamento->valor = Helper::converterMonetario($valor);
            $pagamento->transaction_code = $transaction_code;
            $pagamento->status = $status;
            $pagamento->save();
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }

    public function update($transaction_code, $status)
    {
        try {
            $pagamento = Pagamento::where('transaction_code', $transaction_code)->first();
            $pagamento->status = $status;
            $pagamento->save();
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }

    public function historicoPagamentoPaciente()
    {
        $user = Auth::user();
        $pagamentos = Pagamento::where('user_id', $user->id)->orderBy('data_pagamento', 'desc')->paginate(2);

        $assinaturaController = new AssinaturaController();
        $assinatura = $assinaturaController->getAssinatura($user->id);

        $cartaoController = new CartaoController();
        $cartoes = $cartaoController->getCartoes($user->id);
        
        return view('userPaciente.financeiro.lista', ['pagamentos' => $pagamentos, 'assinatura' => $assinatura, 'cartoes' => $cartoes]);
    }
}
