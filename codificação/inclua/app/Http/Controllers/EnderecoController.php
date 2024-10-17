<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Endereco;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function create()
    {
        return view("profile.form_endereco");
    }

    public function store(Request $request)
    {
        $user = User::find($request->usuario_id);
        if ($user->tipo_user == "C") {
            $rules = [
                "cep" => "required",
                "cidade" => "required",
                "estado" => "required",
                "endereco" => "required",
                "numero" => "required",
                "bairro" => "required",
                "longitude" => "required",
                "latitude" => "required"
            ];
        } else {
            $rules = [
                "cep" => "required",
                "cidade" => "required",
                "estado" => "required",
                "endereco" => "required",
                "numero" => "required",
                "bairro" => "required"
            ];
        }
        $feedbacks = [
           "cep.required" => "O campo CEP é obrigatório.",
           "cidade.required" => "O campo Cidade é obrigatório.",
           "estado.required" => "O campo Estado é obrigatório.",
           "endereco.required" => "O campo Endereço é obrigatório.",
           "numero.required" => "O campo Número é obrigatório.",
           "bairro.required" => "O campo Bairro é obrigatório.",
           "longitude.required" => "O campo Longitude é obrigatório.",
           "latitude.required" => "O campo Latitude é obrigatório."
        ];
        $request->validate($rules, $feedbacks);
        
        try {
            if ($request->endereco_id) {
                $endereco = Endereco::find($request->endereco_id);

                $msg = ['valor' => trans("Endereço atualizado com sucesso!"), 'tipo' => 'success'];
            } else {
                $endereco = new Endereco();

                $msg = ['valor' => trans("Cadastro de endereço realizado com sucesso!"), 'tipo' => 'success'];
            }

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
            $endereco->principal = $endereco->principal ?? false;
            $endereco->save();
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao cadastrar de endereço, tente novamente."), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
            
            return back();
        }
        
        return redirect()->route('user.perfil');
    }

    public function delete($id)
    {
        try {
            $endereco = Endereco::find($id);
            $endereco->delete();

            $msg = ['valor' => "Endereço apagado com sucesso!", 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $exp ){
            $msg = ['valor' => "Erro ao apagar endereço, tente novamente.", 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
        
        return redirect()->route('user.perfil');
    }
    
    public function edit($id)
    {
        $endereco = Endereco::find($id);

        return view("profile.form_endereco", ['endereco' => $endereco]);
    }
    

    public function setEnderecoPrincipal($id)
    {
        try{
            $endereco = Endereco::find($id);
            //REMOVER O PRINCIPAL DOS OUTROS ENDEREÇOS PARA DEFINIR UM NOVO
            $enderecos = Endereco::where('user_id', $endereco->user_id)->update(['principal' => false]);

            $endereco = Endereco::find($id);
            $endereco->principal = true;
            $endereco->save();
            
            $msg = ['valor' => "O endereço foi definido como principal com sucesso!", 'tipo' => 'success'];
            session()->flash('msg', $msg);
        }
        catch (QueryException $exp ){
            $msg = ['valor' => "Erro ao definir o endereço como principal, tente novamente.", 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }

        return back();
    }
}
