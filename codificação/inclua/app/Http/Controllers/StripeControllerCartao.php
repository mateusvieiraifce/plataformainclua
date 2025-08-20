<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Pagamento;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeControllerCartao extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    // Página de checkout
    public function checkout($id=null, $retorno)
    {
        $consulta = Consulta::find($id);
        return view('payments/checkout',['order'=>$consulta,'retorno'=>$retorno]);
    }

    public function createPaymentIntent(Request $request)
    {
        try {
            $amount = $request->amount * 100; // Converter para centavos

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'brl',
                'metadata' => [
                    'order_id' => $request->order_id,
                    'user_id' => auth()->id()
                ],
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id
            ]);

        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Confirmar pagamento
    public function confirmPayment(Request $request)
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);


            if ($paymentIntent->status === 'succeeded') {

                // Salvar pagamento no banco
                $this->savePayment($paymentIntent);

                return response()->json([
                    'success' => true,
                    'message' => 'Pagamento realizado com sucesso!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Pagamento não foi bem sucedido'
            ]);

        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        catch (\Throwable $e2) {
            return response()->json(['error' => $e2->getMessage()], 400);
        }

    }


    // Webhook para eventos do Stripe
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentSucceeded($paymentIntent);
                break;
            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handlePaymentFailed($paymentIntent);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    private function savePayment($paymentIntent)
    {
        $consulta = Consulta::find($paymentIntent->metadata->order_id);

        $pagamento = new Pagamento();
        $pagamento->transaction_code = $paymentIntent->id;
        $pagamento->valor = $paymentIntent->amount/100;
        $pagamento->status =$paymentIntent->status;
        $pagamento->user_id = $paymentIntent->metadata->user_id;
        $pagamento->data_pagamento = Carbon::now();
        $pagamento->servico= " REFERENTE A CONSULTA " .$consulta->id;
        $consulta->forma_pagamento="Cartão";
        $pagamento->save();
        $consulta->pagamento_id = $pagamento->id;
        $consulta->isPago = true;
        $consulta->save();
    }

    private function handlePaymentSucceeded($paymentIntent)
    {
        // Atualizar pedido como pago
        $order = Consulta::find($paymentIntent->metadata->order_id);
        if ($order) {
            $order->update(['isPago' => true]);
        }
        $this->savePayment($paymentIntent);
    }

    private function handlePaymentFailed($paymentIntent)
    {
        // Atualizar pedido como falha no pagamento
        $order = Consulta::find($paymentIntent->metadata->order_id);
        if ($order) {
            $order->update(['status' => 'payment_failed']);
        }
    }



}
