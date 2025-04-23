<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEspecialistaActive
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
        $user = Auth::user();
        
        /* ======= SERÁ REALIZADO O BLOQUEIO DA ROTA QUANDO O USUARIO FOR DO TIPO ESPECIALISTA E NÃO ESTIVER COM SEU CADASTRO APROVADO */
        if ($user->tipo_user == "E" && !($user->ativo != false)) {
            $msg = ['valor' => trans("O seu cadastro ainda não foi aprovado, aguarde até que seja realizada pela administração."), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return $next($request);
    }
}
