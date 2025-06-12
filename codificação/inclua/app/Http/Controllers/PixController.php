<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PixController extends Controller
{

    private function getMercadoPagoHeaders($idempotencyKey)
    {
        return [
            'Authorization' => 'Bearer ' . env('MERCADOPAGO_ACCESS_TOKEN'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-Idempotency-Key' => $idempotencyKey
        ];
    }


    public function generatePix(Request $request)
    {


        // Validação dos dados de entrada
        /*$validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
            'payer_email' => 'required|email',
            'payer_name' => 'required|string|max:255',
            'payer_cpf' => 'required|string|size:11'
        ]);*/
        $amout = 6.0;
        $description = "PAGAMENTO REFERENTE AO ESPECILISTA XXX REFERENTE A CLINICA YYYY";
        $mail= "mateus.vieira@ifce.edu.br";
        $first_name = "Mateus";
        $last_name = "Vieira";
        $cpf="66664195372";

        // Dados para a requisição
        $payload = [
            'transaction_amount' => (float) $amout,
            'description' => $description,
            'payment_method_id' => 'pix',
            'payer' => [
                'email' => $mail,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'identification' => [
                    'type' => 'CPF',
                    'number' => $cpf
                ]
            ]
        ];
        $idempotencyKey = 'pix_' . now()->format('YmdHis') . '_' . Str::random(8);

        try {

            // Chamada à API do Mercado Pago
            $response = Http::withHeaders($this->getMercadoPagoHeaders($idempotencyKey))
                ->timeout(30)
                ->post(env('MERCADOPAGO_API_URL').'/v1/payments', $payload);

            // Tratamento de erros
            if ($response->failed()) {

                $error = $response->json();
                dd($error);
                Log::error('Erro ao gerar PIX', ['error' => $error]);
                return back()->withErrors(['message' => $error['message'] ?? 'Erro ao gerar PIX']);
            }

            $payment = $response->json();

            // Verifica se tem os dados do PIX
            if (!isset($payment['point_of_interaction']['transaction_data'])) {
                Log::error('Dados do PIX ausentes', ['response' => $payment]);
                return back()->withErrors(['message' => 'Dados do PIX não recebidos']);
            }

            // Retorna a view com os dados
            return view('pix.show', [
                'qr_code_base64' => $payment['point_of_interaction']['transaction_data']['qr_code_base64'],
                'qr_code' => $payment['point_of_interaction']['transaction_data']['qr_code'],
                'payment_id' => $payment['id'],
                'amount' => $payment['transaction_amount'],
                'status' => $payment['status'],
                'created_at' => $payment['date_created']
            ]);

        } catch (\Exception $e) {

            Log::error('Exceção ao gerar PIX', ['error' => $e->getMessage()]);
            return back()->withErrors(['message' => 'Erro interno ao processar PIX']);
        }
    }
    public function checkPaymentStatus($paymentId)
    {
        try {
            $response = Http::withHeaders($this->getMercadoPagoHeaders(""))
                ->get(env('MERCADOPAGO_API_URL').'/v1/payments/'.$paymentId);

            if ($response->failed()) {
                return response()->json(['error' => true], 400);
            }

            $payment = $response->json();
            return response()->json([
                'status' => $payment['status'],
                'approved' => $payment['status'] === 'approved'
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => true], 500);
        }
    }

    public function handleWebhook(Request $request)
    {
       // $data = $request->all();
        //Log::info('Webhook recebido', ['data' => $data]);

        // Aqui você pode processar a notificação
        // Verificar o payment_id e atualizar seu banco de dados

        return response()->json(['success' => true]);
    }


    //
}
