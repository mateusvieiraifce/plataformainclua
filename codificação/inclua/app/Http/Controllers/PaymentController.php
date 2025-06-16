<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class PaymentController extends Controller
{
    private $mercadoLivreBaseUrl = 'https://api.mercadolibre.com';

    private $apiBaseUrl = 'https://api.mercadopago.com';

    /**
     * Mostra o formulário de checkout
     */
    public function showCheckout()
    {
        $idempotencyKey = 'card_' . now()->format('YmdHis') . '_' . Str::random(8);
        session()->put('idempotencyKey', $idempotencyKey);
        return view('checkout', [
            'publicKey' => env('MERCADOPAGO_PUBLIC_KEY'),
            'publicKeyIdem'=>$idempotencyKey
        ]);
    }

    private function getMercadoPagoHeaders($idempotencyKey)
    {
        return [
            'Authorization' => 'Bearer ' . env('MERCADOPAGO_ACCESS_TOKEN'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Idempotency-Key' => $idempotencyKey
        ];
    }

    /**
     * Processa o pagamento
     */
    public function processPayment(Request $request)
    {

        $validated = $request->validate([
            'token' => 'required|string',
            'payment_method_id' => 'required|string',
            'transaction_amount' => 'required|numeric|min:1',
            'installments' => 'required|integer|min:1',
            'description' => 'required|string|max:255',
            'payer.email' => 'required|email',
            'payer.identification.type' => 'required|string',
            'payer.identification.number' => 'required|string',
        ]);

        $paymentData = [
            'transaction_amount' => $validated['transaction_amount'],
            'token' => $validated['token'],
            'description' => $validated['description'],
            'installments' => $validated['installments'],
            'payment_method_id' => $validated['payment_method_id'],
            'payer' => [
                'email' => $validated['payer']['email'],
                'identification' => [
                    'type' => $validated['payer']['identification']['type'],
                    'number' => $validated['payer']['identification']['number']
                ]
            ],
            'external_reference' => 'ORDER_' . uniqid(),
            'notification_url' => route('payment.notification'),
            'metadata' => [
                'site_id' => 'MLB' // MLB = Mercado Livre Brasil
            ]

        ];

        try {
            $idempotencyKey = session()->get('idempotencyKey');

            $response = Http::withHeaders($this->getMercadoPagoHeaders($idempotencyKey))
                ->timeout(30)
                ->post(env('MERCADOPAGO_API_URL').'/v1/payments', $paymentData);

         /*   $response = Http::withToken(env('MERCADOPAGO_ACCESS_TOKEN'))
                ->post($this->apiBaseUrl.'/v1/payments?site_id=MLB', $paymentData);*/

            if ($response->failed()) {
                throw new \Exception($response->json()['message'] ?? 'Erro ao processar pagamento');
            }

            $payment = $response->json();

            return response()->json([
                'success' => true,
                'payment' => [
                    'id' => $payment['id'],
                    'status' => $payment['status'],
                    'status_detail' => $payment['status_detail'],
                    'date_approved' => $payment['date_approved'] ?? null
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Payment Error: '.$e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Recebe notificações do Mercado Pago
     */
    public function handleNotification(Request $request)
    {
        $paymentId = $request->input('data.id');

        try {
            $payment = $this->getPayment($paymentId);

            // Aqui você pode atualizar seu banco de dados
            Log::info("Payment {$paymentId} updated to status: {$payment['status']}");

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Notification Error: '.$e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    /**
     * Obtém detalhes de um pagamento
     */
    private function getPayment($paymentId)
    {
        $response = Http::withToken(env('MERCADOPAGO_ACCESS_TOKEN'))
            ->get($this->apiBaseUrl."/v1/payments/{$paymentId}");

        if ($response->failed()) {
            throw new \Exception($response->json()['message'] ?? 'Erro ao obter pagamento');
        }

        return $response->json();
    }
    //
}
