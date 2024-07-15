<?php

namespace App\Http\Middleware;

use App\Http\Controllers\AssinaturaController;
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
        $assinatura = Assinatura::where('user_id', $user->id)->first();
        if ($assinatura->status == "RENOVAÇÂO PENDENTE" && $assinatura->situacao == "CANCELADA") {
            $assinaturaController = new AssinaturaController();
            $response = $assinaturaController->renovacaoManual($assinatura->id);
            
            return $response;
        } elseif ($assinatura->status == "NEGADA" && $assinatura->situcao == "CANCELADA") {
            dd('direcionar para o formulario');
        } elseif ($assinatura->status == "APROVADA" && $assinatura->situcao == "ATIVA") {
            return $next($request);
        }
    
        session()->flash('msg', ['valor' => trans("Não foi possível renovar sua assinatura."), 'tipo' => 'danger']);
        return back();
    }
}
