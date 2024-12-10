<?php

namespace App\Http\Controllers;

use App\Models\Atestado;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AtestadoController extends Controller
{
    public function store(Request $request) {
        $input = $request->validate(
            [
                'texto' => 'required|string',
                'data' => 'required', 
                'user_id' => 'required',
                'consulta_id' => 'required',
            ]
        );   

        $atestado = Atestado::create($input);

        return Redirect()->back();
    }

    public function downloadAtestado() {
        
    }
}
