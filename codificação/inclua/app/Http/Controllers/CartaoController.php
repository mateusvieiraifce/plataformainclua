<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Cartao;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CartaoController extends Controller
{
    public function create($id_usuario)
    {
        return view('cadastro.form_cartao', ['id_usuario' => $id_usuario]);
    }
    
    public function store($request)
    {
        try {
            $cartao = new Cartao();
            $cartao->user_id = $request->id_usuario;
            $cartao->numero_cartao = Crypt::encrypt(Helper::removeMascaraDocumento($request->numero_cartao));
            $cartao->instituicao = $request->instituicao;
            $cartao->mes_validade = date("m",strtotime($request->validade));
            $cartao->ano_validade = date("Y",strtotime($request->validade));
            $cartao->codigo_seguranca = Crypt::encrypt($request->codigo_seguranca);
            $cartao->nome_titular = $request->nome_titular;
            $cartao->status = "PENDENTE";
            $cartao->save();
            
            return $cartao;
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }
}
