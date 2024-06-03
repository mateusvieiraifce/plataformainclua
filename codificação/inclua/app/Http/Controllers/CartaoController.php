<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Cartao;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\MercadoPagoConfig;

use function PHPSTORM_META\map;

class CartaoController extends Controller
{
    public function teste()
    {
        $preference_data = array (
            "items" => array (
                array (
                    "title" => "Test2",
                    "quantity" => 1,
                    "currency_id" => "BRL",
                    "unit_price" => 10.41
                )
            )
        );
        
        $preference_data = [
            'items' =>
                [[
                    'title' => 'Test2',
                    'description'=> 'teste',
                    'quantity' => 1,
                    'currency_id' => 'BRL',
                    'unit_price' => 10.41, // Preço do produto
                ]],
            'external_reference'=> '123123123',
        ];

        try {
            $preference = MP::create_preference($preference_data);
            return redirect()->to($preference['response']['init_point']);
        } catch (Exception $e){
            dd($e->getMessage());
        }
    }

    public function save()
    {
        $token = md5(date('Y-m-d', time()));
        MercadoPagoConfig::setAccessToken(env("MERCADOPAGO_ACCESS_TOKEN"));
      
        $client = new PaymentClient();
        $request_options = new RequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key: $token"]);
      
        $json = file_get_contents('php://input');
        $result_request = json_decode($json);
        $payment = $client->create([
          "transaction_amount" => $result_request->transaction_amount,
          "token" => $result_request->token,
          "description" => $result_request->description,
          "installments" => $result_request->installments,
          "payment_method_id" => $result_request->payment_method_id,
          "issuer_id" => $result_request->issuer_id,
          "payer" => [
            "email" => $result_request->payer->email,
            "identification" => [
                "type" =>  $result_request->payer->identification->number,
                "number" =>  $result_request->payer->identification->type
            ]
          ]
        ], $request_options);
        
        return response()->json(['message' => $payment]);
/* 
        if ($result_request->transaction_amount == env('PRECO_ASSINATURA')) {
            $json = file_get_contents('php://input');
            $result_request = json_decode($json);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.mercadopago.com/v1/payments',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                    "transaction_amount": "'.$result_request->transaction_amount.'",
                    "token": "'.$result_request->token.'",
                    "description": "'.$result_request->description.'",
                    "installments": "'.$result_request->installments.'",
                    "payment_method_id":  "'.$result_request->payment_method_id.'",
                    "issuer_id":  "'.$result_request->issuer_id.'",
                    "payer": {
                        "email": "'.$result_request->payer->email.'",
                        "identification" => [
                        "type" => "'.$result_request->payer->identification->number.'",
                        "number" => "'.$result_request->payer->identification->type.'"
                        ]
                    }
                }',
                CURLOPT_HTTPHEADER => array(
                    'accept: application/json',
                    'content-type: application/json',
                    'X-Idempotency-Key: '.md5(date('Y-m-d', time())),
                    'Authorization: Bearer '.env("MERCADOPAGO_ACCESS_TOKEN")
                ),
            ));
            $response = curl_exec($curl);
            $resultado = json_decode($response);
            echo md5(date('Y-m-d', time()));
            curl_close($curl);

            return response()->json(['message' => "Seu pagamanto foi realizado com sucesso."], 200);
        } else {
            return response()->json(['message' => "O valor do pagamento foi alterado."], 400);
        } */
    }

    public function create($id_usuario)
    {
        return view('cadastro.form_cartao', ['id_usuario' => $id_usuario]);
    }

    public function store(Request $request)
    {
        $rules = [
            "numero_cartao" => "required|min:19",
            "validade" => "required",
            "cvv" => "required|min:3",
            "nome_titular" => "required|min:5"
        ];
        $feedbacks = [
            "numero_cartao.required" => "O campo Número do cartão é obrigatório.",
            "numero_cartao.min" => "O campo Número do cartão deve ter no mínimo 16 dígitos.",
            "validade.required" => "O campo Validade é obrigatório.",
            "cvv.required" => "O campo CVV é obrigatório.",
            "cvv.min" => "O campo CVV deve ter 3 dígitos.",
            "nome_titular.required" => "O campo Nome do titular é obrigatório.",
            "nome_titular.min" => "O campo Nome do titular deve ter no mínimo 5 caracteres.",
        ];
        $request->validate($rules, $feedbacks);
        
        try {
            $cartao = new Cartao();
            $cartao->user_id = $request->id_usuario;
            $cartao->numero_cartao = Crypt::encrypt(Helper::removeMascaraDocumento($request->numero_cartao));
            $cartao->mes_validade = date("m",strtotime($request->validade));
            $cartao->ano_validade = date("Y",strtotime($request->validade));
            $cartao->cvv = Crypt::encrypt($request->cvv);
            $cartao->nome_titular = $request->nome_titular;
            $cartao->principal = "S";
            $cartao->save();

            Auth::loginUsingId($request->id_usuario);
            $msg = ['valor' => trans("Seu cadastro foi finalizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return redirect()->route('home');
    }
}
