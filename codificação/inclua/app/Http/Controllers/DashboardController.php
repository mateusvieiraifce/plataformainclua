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
      //  $compras = Vendas::where('comprador_id', $usuario->id)->orderBy('created_at', 'desc')->get();

        return view('dashboard');
    }
}
