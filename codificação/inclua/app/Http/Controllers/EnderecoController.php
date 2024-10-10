<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Endereco;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnderecoController extends Controller
{
    public function storeEndereco(Request $request)
    {
        try {
            $endereco = new Endereco();
            $endereco->user_id = $request->usuario_id;
            $endereco->cep = Helper::removeMascaraCep($request->cep);
            $endereco->cidade = $request->cidade;
            $endereco->estado = $request->estado;
            $endereco->rua = $request->endereco;
            $endereco->numero = $request->numero;
            $endereco->complemento = $request->complemento;
            $endereco->longitude = $request->longitude ?? null;
            $endereco->latitude = $request->latitude ?? null;
            $endereco->bairro = $request->bairro;
            $endereco->principal = true;
            $endereco->save();

            $msg = ['valor' => trans("Cadastro de endereço realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }
    }
}
