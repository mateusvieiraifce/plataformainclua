<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Cartao;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

use function PHPSTORM_META\map;

class CartaoController extends Controller
{
    public function create($id_usuario)
    {
        return view('cadastro.form_cartao', ['id_usuario' => $id_usuario]);
    }

    public function store($request, $retorno_api)
    {
        try {
            $cartao = new Cartao();
            $cartao->user_id = $request['id_usuario'];
            $cartao->token = Crypt::encrypt($request['token']);
            $cartao->issuer_id = $request['issuer_id'];
            $cartao->installments = Crypt::encrypt($request['installments']);
            $cartao->payment_method_id = $request['payment_method_id'];
            $cartao->email = $request['email'];
            $cartao->status = $retorno_api->status;
            $cartao->ultimo_digitos = $retorno_api->card->last_four_digits;
            $cartao->principal = $retorno_api->status == "approved" ? "S" : '';
            $cartao->save();

            //ATUALIZAR ETAPA DE CADASTRO FINALIZADO
            $user = User::find($request['id_usuario']);
            $user->etapa_cadastro = 'F';
            $user->save();

            return $cartao->id;
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }        
    }

    public function qqstore(Request $request)
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

            $user = User::find($request->id_usuario);
            $user->etapa_cadastro = 'F';
            $user->save();

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
