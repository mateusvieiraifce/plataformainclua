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
        $usuario = Auth::user();
        session()->flash('msg', ['valor' => trans("Bem vindo a Plataforma Inclua!"), 'tipo' => 'success']);
        if ($usuario->tipo_user == 'P') {
            //home usuario Paciente
            return redirect()->route('paciente.home');
        }
        return view('dashboard');
    }
}
