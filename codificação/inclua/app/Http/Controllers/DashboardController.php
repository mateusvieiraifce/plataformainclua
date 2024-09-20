<?php

namespace App\Http\Controllers;

use App\Models\Cartao;
use App\Models\Vendas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        session()->flash('msg', ['valor' => trans("Bem vindo a Plataforma Inclua!"), 'tipo' => 'success']);
        if ($user->tipo_user == 'P') {
            //home user Paciente
            return redirect()->route('paciente.home');
        } elseif ($user->tipo_user ==='E') {
            //home user Especialista
            return redirect()->route('consulta.listconsultaporespecialista');
         }
         elseif ($user->tipo_user ==='C') {
            //home user Clinica
            return redirect()->route('consulta.agendaConsultas');
         }
        return view('dashboard');
    }
}
