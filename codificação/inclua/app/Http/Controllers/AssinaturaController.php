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
        $client = new PaymentClient();
        MercadoPagoConfig::setAccessToken(env("MERCADOPAGO_ACCESS_TOKEN"));

        $request = [
            'transaction_amount' => $request['cardFormData']['transaction_amount'],
            "issuer_id" => $request['cardFormData']['issuer_id'],
            "token" => $request['cardFormData']['token'],
            "installments" => $request['cardFormData']['installments'],
            "payment_method_id" => $request['cardFormData']['payment_method_id'],
            "email" => $request['cardFormData']['payer']['email'],
            "type" => $request['cardFormData']['payer']['identification']['type'],
            "number" => $request['cardFormData']['payer']['identification']['number'],
            "id_usuario" => $request['id_usuario']
        ];
        
        if ($request['transaction_amount'] == env('PRECO_ASSINATURA')) {
            $createRequest = [
                "transaction_amount" => intval(env('PRECO_ASSINATURA')),
                "description" => "Plataforma Inclua - Assinatura",
                "issuer_id" => $request['issuer_id'],
                "token" => $request['token'],
                "installments" => $request['installments'],
                "payment_method_id" => $request['payment_method_id'],
                "payer" => [
                    "email" => $request['email'],
                    "identification" => [
                        "type" =>  $request['type'],
                        "number" =>  $request['number']
                    ]
                ],
            ];

            $payment = $client->create($createRequest);
        
            if ($payment->status == "approved" || $payment->status == "in_process") {
                $controllerCartao = new CartaoController();
                $cartao_id = $controllerCartao->store($request, $payment);

                $this->store($cartao_id, $payment->status);

                Auth::loginUsingId($request['id_usuario']);
                session()->flash('msg', ['valor' => trans("Seu cadastro foi finalizado com sucesso. Bem vindo a plataforma Inclua!"), 'tipo' => 'success']);
            }

            return response()->json(['message' => $payment], 200);
        } else {
            $response = [
                "status" => "amountAlter"
            ];

            return response()->json(['message' => $response], 200);
        }
    }

    public function store($cartao_id, $status)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataLocal = date('Y-m-d', time());
        $assinatura = new Assinatura();
        $assinatura->cartao_id = $cartao_id;
        $assinatura->data_pagamento = $dataLocal;
        $assinatura->data_renovacao = Helper::addMonthsToDate($dataLocal, 1);
        $assinatura->status = $status;
        $assinatura->save();
    }

    public function renovarAssinatura($id_usuario)
    {
        $cartao = Cartao::where('user_id', $id_usuario)->where('principal', 'S')->first();
        $cartao->token = Crypt::decrypt($cartao->token);
        $cartao->installments = Crypt::decrypt($cartao->installments);

        try {
            $client = new PaymentClient();
            MercadoPagoConfig::setAccessToken(env("MERCADOPAGO_ACCESS_TOKEN"));
            $createRequest = [
                "transaction_amount" => intval(env('PRECO_ASSINATURA')),
                "description" => "Plataforma Inclua - Assinatura",
                "issuer_id" => $cartao->issuer_id,
                "token" => $cartao->token,
                "installments" => $cartao->installments,
                "payment_method_id" => $cartao->payment_method_id,
                "payer" => [
                    "email" => $cartao->email
                ],
            ];

            $payment = $client->create($createRequest);
            print_r($payment);
        } catch (MPApiException $e) {
            dd($e);
        }
        
    }
}
