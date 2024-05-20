<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Cartao;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CartaoController extends Controller
{
    public function create($id_usuario)
    {
        return view('cadastro.cartao', ['id_usuario' => $id_usuario]);
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
