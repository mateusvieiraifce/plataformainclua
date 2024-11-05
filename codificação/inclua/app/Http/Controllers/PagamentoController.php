<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Assinatura;
use App\Models\Pagamento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    public function store($user_id, /* $cartao_id, $assinatura_id,  */$valor, $transaction_code, $status, $servico)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataLocal = Carbon::now();
        try {
            $assinaturaController = new AssinaturaController();
            $assinatura = $assinaturaController->getAssinatura($user_id);

            $pagamento = new Pagamento();
            $pagamento->user_id = $user_id;
            $pagamento->cartao_id = $assinatura->cartao_id;
            $pagamento->assinatura_id = $assinatura->id;
            $pagamento->valor = Helper::converterMonetario($valor);
            $pagamento->transaction_code = $transaction_code;
            $pagamento->data_pagamento = $dataLocal;
            $pagamento->status = $status;
            $pagamento->servico = $servico;
            $pagamento->save();
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }

    public function update($transaction_code, $status)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataLocal = Carbon::now();

        try {
            $pagamento = Pagamento::where('transaction_code', $transaction_code)->first();
            $pagamento->data_pagamento = $dataLocal;
            $pagamento->status = $status;
            $pagamento->save();
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }

    public function historicoPagamentosPaciente()
    {
        $user = Auth::user();
        $pagamentos = Pagamento::where('user_id', $user->id)->orderBy('data_pagamento', 'desc')->paginate(2, ['*'], 'page_payments');

        $assinaturaController = new AssinaturaController();
        $assinatura = $assinaturaController->getAssinatura($user->id);

        $cartaoController = new CartaoController();
        $cartoes = $cartaoController->getCartoes($user->id, 2);
        
        return view('userPaciente.financeiro.lista', ['user' => $user, 'pagamentos' => $pagamentos, 'assinatura' => $assinatura, 'cartoes' => $cartoes]);
    }
    
    public function historicoPagamentosPacientes()
    {
        $pagamentos = Pagamento::orderBy('data_pagamento', 'desc')->paginate(4, ['*'], 'page_payments');
/* 
        foreach ($pagamentos as $pagamento) {
            $assinaturaController = new AssinaturaController();
            $assinatura = $assinaturaController->getAssinatura($pagamento->user_id);
            dd($assinatura);
        } */
       
        $assinaturas = Assinatura::paginate(4, ['*'], 'page_signature');

        return view('user_root.pacientes.financeiro', ['pagamentos' => $pagamentos, 'assinaturas' => $assinaturas]);
    }
}
