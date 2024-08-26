<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\UsuarioController;
use App\Models\Assinatura;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class VerifyPaymentSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('email', $request->email)->first();

        if (isset($user) && $user->tipo_user == "P" && $user->etapa_cadastro == "F") {   
            $assinatura = Assinatura::where('user_id', $user->id)->first();
            //TODO para obrigar assinatura.
            if (!$assinatura) {
                return $next($request);
            }

            //PARA O CASO DO CARTÃO NECESSITAR DE TELA INTERMEDIÁRIA DE CONFIRMAÇÃO DE COMPRA
            if ($assinatura->status == "RENOVAÇÂO PENDENTE" && $assinatura->situacao == "CANCELADA") {
                $assinaturaController = new AssinaturaController();
                $response = $assinaturaController->renovacaoManual($assinatura->id);

                return $response;
            } elseif ($assinatura->status == "NEGADA" && $assinatura->situacao == "CANCELADA") {
                //PARA O CASO DO CARTÃO NÃO TER SIDO APROVADO PARA RENOVAR A ASSINATURA
                session()->flash('msg', ['valor' => trans("Não foi possível renovar a assinatura com o cartão cadastrado. Informe um novo cartão para continuar a utilizar os serviços da plataforma."), 'tipo' => 'danger']);

                return redirect()->route('cartao.create', ['usuario_id' => $user->id]);
            } elseif ($assinatura->status == "APROVADA" && $assinatura->situacao == "ATIVA") {
                //PARA O CASO DA ASSINATURA ESTAR ATIVA
                return $next($request);
            }

            //PARA O CASO DE O CADASTRO INCOMPLETO
            $usuarioController = new UsuarioController();
            return $usuarioController->verifyCadastro($user->id);
        }

        return $next($request);
    }
}
