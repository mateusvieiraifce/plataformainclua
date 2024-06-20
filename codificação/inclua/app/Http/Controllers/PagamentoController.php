<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Pagamento;
use Illuminate\Http\Request;

class PagamentoController extends Controller
{
    public function store($user_id, $cartao_id, $assinatura_id, $valor)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataLocal = date('Y-m-d', time());
        $pagamento = new Pagamento();
        $pagamento->user_id = $user_id;
        $pagamento->cartao_id = $cartao_id;
        $pagamento->assinatura_id = $assinatura_id;
        $pagamento->data_pagamento = $dataLocal;
        $pagamento->valor = Helper::converterMonetario($valor);
        $pagamento->save();
    }
}
