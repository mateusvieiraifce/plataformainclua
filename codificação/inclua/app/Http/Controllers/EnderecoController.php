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
    public function createEndereco($usuario_id)
    {
        return view('cadastro.paciente.form_endereco', ['usuario_id' => $usuario_id]);
    }

    public function storeEndereco(Request $request)
    {
        $rules = [
            "cep" => "required",
            "cidade" => "required",
            "estado" => "required",
            "endereco" => "required",
            "numero" => "required",
            "bairro" => "required",
        ];
        $feedbacks = [
            "cep.required" => "O campo CEP é obrigatório.",
            "cidade.required" => "O campo Cidade é obrigatório.",
            "estado.required" => "O campo Estado é obrigatório.",
            "endereco.required" => "O campo Endereço é obrigatório.",
            "numero.required" => "O campo Número é obrigatório.",
            "bairro.required" => "O campo Bairro é obrigatório."
        ];
        $request->validate($rules, $feedbacks);

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

            $user = User::find($request->usuario_id);
            $user->etapa_cadastro = '4';
            $user->save();

            $msg = ['valor' => trans("Cadastro de endereço realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return redirect()->route('cartao.create', ['usuario_id' => $request->usuario_id]);
    }
}
