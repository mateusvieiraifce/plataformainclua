<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Pagamento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PixSripeController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    // Mostrar página de checkout
    public function showCheckout($id=null)
    {
        return view('payments.pix_checkout',["order"=>Consulta::find($id)]);
    }

    // Criar Payment Intent com PIX
    public function createPaymentIntent(Request $request)
    {
        try {
            $amount = $request->amount * 100; // Converter para centavos

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'brl',
                'payment_method_types' => ['pix'],
                'metadata' => [
                    'order_id' => $request->order_id,
                    'user_id' => auth()->id(),
                    'type' => 'pix'
                ],
            ]);

            $consulta = Consulta::find($paymentIntent->metadata->order_id);

            $pagamento = new Pagamento();
            $pagamento->transaction_code = $paymentIntent->id;
            $pagamento->valor = $paymentIntent->amount/100;
            $pagamento->status =$paymentIntent->status;
            $pagamento->user_id = $paymentIntent->metadata->user_id;
            $pagamento->data_pagamento = Carbon::now();
            $pagamento->servico= " REFERENTE A CONSULTA " .$consulta->id;

            $pagamento->save();
            $consulta->pagamento_id = $pagamento->id;
            $consulta->isPago = true;
            $consulta->save();

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntent' => $paymentIntent->id,
                'pixCode' => $paymentIntent->next_action->pix_display_qr_code->data,
                'expiresAt' => $paymentIntent->next_action->pix_display_qr_code->expires_at
            ]);

        } catch (ApiErrorException $e) {
            Log::error('Stripe PIX Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Erro ao criar pagamento PIX',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Verificar status do pagamento
    public function checkPaymentStatus($paymentIntentId)
    {
        try {
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);

            $payment = Pagamento::where('transaction_code', $paymentIntentId)->first();
            if ($payment) {
                $payment->update(['status' => $paymentIntent->status]);
            }

            return response()->json([
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount / 100,
                'pixCode' => $paymentIntent->status === 'requires_payment_method' ?
                    $paymentIntent->next_action->pix_display_qr_code:""
            ]);

        } catch (ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // Página de sucesso
    public function success($paymentIntentId)
    {
        $payment = Pagamento::where('transaction_code', $paymentIntentId)->firstOrFail();
        return view('pix.success', compact('payment'));
    }

    // Página de aguardando pagamento
    public function pending($paymentIntentId)
    {
        $payment = Pagamento::where('transaction_code', $paymentIntentId)->firstOrFail();
        return view('pix.pending', compact('payment'));
    }

    // Webhook para PIX
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\Exception $e) {
            return response()->json(['error' => 'Webhook error'], 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                $this->handlePaymentSucceeded($paymentIntent);
                break;

            case 'payment_intent.payment_failed':
                $paymentIntent = $event->data->object;
                $this->handlePaymentFailed($paymentIntent);
                break;

            case 'payment_intent.created':
                $paymentIntent = $event->data->object;
                $this->handlePaymentCreated($paymentIntent);
                break;
        }

        return response()->json(['status' => 'success']);
    }

    private function handlePaymentSucceeded($paymentIntent)
    {
        $payment = Pagamento::where('transaction_code', $paymentIntent->id)->first();

        if ($payment) {
            $payment->update([
                'status' => 'succeeded',
                'data_pagamento' => Carbon::now()
            ]);

            // Atualizar pedido
            if ($payment->order_id) {
                Consulta::where('id', $payment->order_id)->update(['isPago' => true]);
            }

            // Enviar email de confirmação
            // $this->sendPaymentConfirmation($payment);
        }
    }

    private function handlePaymentFailed($paymentIntent)
    {
        $payment = Pagamento::where('transaction_code', $paymentIntent->id)->first();

        if ($payment) {
            $payment->update(['status' => 'failed']);

            if ($payment->order_id) {
                Consulta::where('id', $payment->order_id)->update(['isPago' => false]);
            }
        }
    }

    private function handlePaymentCreated($paymentIntent)
    {
        // Log para debugging
        Log::info('PaymentIntent created: ' . $paymentIntent->id);
    }

    //
}
