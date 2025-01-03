<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\UsuarioController;
use App\Models\Assinatura;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
        if (!isset($user)) {
            $user = Auth::user();
        }
        
        if (isset($user) && $user->tipo_user == "P" && $user->etapa_cadastro == "F" && env('ASSINATURA_OBRIGATORIA')) {   
            $assinatura = Assinatura::where('user_id', $user->id)->first();

            /* ============== VERIFICA A EXISTENCIA DE UMA ASSINATRUA PARA ACESSAR OS SERVIÇOS, CASO SEJA OBRIGATÓRIA. ============== */
            if (!$assinatura && env('ASSINATURA_OBRIGATORIA')) {
                session()->flash('msg', ['valor' => trans("Você não possui uma assinatura. Para ter acesso aos serviços da platarforma cadastre seu cartão de crédito para realizar a assinatura."), 'tipo' => 'danger']);

                return redirect()->route('paciente.financeiro');
            } else if ($assinatura->situacao == "Cancelada" && env('ASSINATURA_OBRIGATORIA') && Route::current()->uri != "dashboard") {
                session()->flash('msg', ['valor' => trans("A sua assinatura esta cancelada, para ter acesso a todos os serviços realize a renovação agora mesmo."), 'tipo' => 'danger']);

                return redirect()->route('paciente.financeiro');
            }
            
            /* ============== UTILIZADO PARA A RENOVAÇÃO REALIZADA NO ATO DO LOGIN ============== */

            //PARA O CASO DO CARTÃO NECESSITAR DE TELA INTERMEDIÁRIA DE CONFIRMAÇÃO DE COMPRA
            if ($assinatura->status == "Renovação pendente" && $assinatura->situacao == "Cancelada") {
                $assinaturaController = new AssinaturaController();
                $response = $assinaturaController->renovacaoManual($assinatura->cartao_id);

                return $response;
            } elseif ($assinatura->status == "Negada" && $assinatura->situacao == "Cancelada") {
                //PARA O CASO DO CARTÃO NÃO TER SIDO APROVADO PARA RENOVAR A ASSINATURA
                session()->flash('msg', ['valor' => trans("Não foi possível renovar a assinatura com o cartão cadastrado. Informe um novo cartão para continuar a utilizar os serviços da plataforma."), 'tipo' => 'danger']);

                return redirect()->route('cartao.create', ['usuario_id' => $user->id]);
            }           
            
            //PARA O CASO DA ASSINATURA ESTAR ATIVA
            if ($assinatura->status == "Aprovada" && $assinatura->situacao == "Ativa") {
                return $next($request);
            }
        }

        return $next($request);
    }
}
