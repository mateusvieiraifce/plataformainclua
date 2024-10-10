<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ValidacoesController extends Controller
{
    public function verificarEmail($usuario_id)
    {
        $user = User::find($usuario_id);
        return view('cadastro.verificar_email', ['usuario_id' => $usuario_id, 'email' => $user->email]);
    }

    public function reenviarEmail(Request $request)
    {
        $user = User::find($request->usuario);
        $user->codigo_validacao = Helper::generateRandomNumberString(5);
        $user->save();
        //ENVIAR O EMAIL COM CÓDIGO DE CONFIRMAÇÃO
        //Mail::to($user->email)->send(new verificarEmail($user->codigo_validacao));
        Helper::sendEmail("Re-Envio de Código de validação","O seu codigo de validação é: ".$user->codigo_validacao,$user->email);
        $response = true;

        return response()->json($response);
    }

    public function validarEmail(Request $request)
    {
        $rules = [
            "codigo" => "required",
        ];
        $feedbacks = [
            "codigo.required" => "O campo Código é obrigatório.",
        ];
        $request->validate($rules, $feedbacks);

        try {
            $user = User::find($request->usuario_id);
            if ($request->codigo == $user->codigo_validacao) {
                // CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
                date_default_timezone_set('America/Sao_Paulo');
                $dataLocal = date('Y-m-d H:i:s', time());

                $user->email_verified_at = $dataLocal;
                $user->etapa_cadastro = '2';
                $user->save();

                $msg = ['valor' => trans("Seu email foi verificado com sucesso!"), 'tipo' => 'success'];
                session()->flash('msg', $msg);
            } else {
                $msg = ['valor' => trans("O código informado esta incorreto!"), 'tipo' => 'danger'];
                session()->flash('msg', $msg);

                return back();
            }
        } catch(QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        if ($user->tipo_user == "P") {
            return redirect()->route('usuario.paciente.dados.create', ['usuario_id' => $user->id]);
        } elseif ($user->tipo_user == "E") {
            return redirect()->route('usuario.especialista.dados.create', ['usuario_id' => $user->id]);
        } elseif ($user->tipo_user == "C") {
            return redirect()->route('usuario.clinica.dados.create', ['usuario_id' => $user->id]);
        } 
    }

    public function verificarCelular($usuario_id)
    {
        $user = User::find($usuario_id);

        return view('cadastro.verificar_celular', ['user' => $user, 'celular' => Helper::mascaraCelular($user->celular)]);
    }

    public function reenviarSMS(Request $request)
    {
        $user = User::find($request->usuario);
        $user->codigo_validacao = Helper::generateRandomNumberString(5);
        $user->save();

        Helper::sendSms($user->celular, "Bem vindo a plataforma Inclua, o seu código de verificação é: $user->codigo_validacao");
        $response = true;

        return response()->json($response);
    }

    public function validarCelular(Request $request)
    {
        $rules = [
            "codigo" => "required",
        ];
        $feedbacks = [
            "codigo.required" => "O campo Código é obrigatório.",
        ];
        $request->validate($rules, $feedbacks);

        try {
            $user = User::find($request->usuario_id);
            if ($request->codigo == $user->codigo_validacao) {
                $user->celular_validado = "S";
                $user->etapa_cadastro = '3';
                $user->save();

                $msg = ['valor' => trans("Seu celular foi verificado com sucesso!"), 'tipo' => 'success'];
                session()->flash('msg', $msg);
            } else {
                $msg = ['valor' => trans("O código informado esta incorreto!"), 'tipo' => 'danger'];
                session()->flash('msg', $msg);

                return back();
            }
        } catch(QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        if ($user->tipo_user == 'P') {
            return redirect()->route('paciente.endereco.create', ['usuario_id' => $user->id]);
        } elseif ($user->tipo_user == 'E') {
            return redirect()->route('dados-bancarios.create', ['usuario_id' => $user->id]); 
        } elseif ($user->tipo_user == 'C') {
            return redirect()->route('clinica.endereco.create', ['usuario_id' => $user->id]);
        }
    }
}
