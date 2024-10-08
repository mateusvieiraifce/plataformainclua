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
    public function create($usuario_id)
    {
        return view('cadastro.paciente.form_cartao', ['usuario_id' => $usuario_id]);
    }
    
    public function store($request)
    {
        try {
            $cartao = new Cartao();
            $cartao->user_id = $request->usuario_id;
            $cartao->numero_cartao = Crypt::encrypt(Helper::removerCaractereEspecial($request->numero_cartao));
            $cartao->instituicao = $request->instituicao;
            $cartao->mes_validade = date("m",strtotime($request->validade));
            $cartao->ano_validade = date("Y",strtotime($request->validade));
            $cartao->codigo_seguranca = Crypt::encrypt($request->codigo_seguranca);
            $cartao->nome_titular = $request->nome_titular;
            $cartao->status = "Pendente";
            $cartao->save();
            
            return $cartao;
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }
    
    public function update($cartao_id, $status, $principal = null)
    {
        try {
            $cartao = Cartao::find($cartao_id);
            $cartao->status = $status;
            $cartao->principal = $principal;
            $cartao->save();
            
            return $cartao;
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }

    public function getCartoes($user_id, $paginas = 0)
    {
        $cartoes = Cartao::where('user_id', $user_id)->orderBy('updated_at', 'desc');

        if ($paginas != 0) {
            $cartoes = $cartoes->paginate($paginas, ['*'], 'page_card');
        } else {
            $cartoes = $cartoes->get();
        }

        return $cartoes;
    }
}
