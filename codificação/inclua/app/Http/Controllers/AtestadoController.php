<?php

namespace App\Http\Controllers;

use App\Models\Atestado;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AtestadoController extends Controller
{
    public function store(Request $request) {
        $input = $request->validate(
            [
                'texto' => 'required|string',
                'user_id' => 'required',
                'consulta_id' => 'required',
            ]
        );   
        $input['data'] = Carbon::now('America/Sao_Paulo');
        $atestado = Atestado::create($input);
        
        $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
        return Redirect()->back()->with('msg', $msg);
    }

    public function downloadAtestado($id) {
        $atestado = Atestado::find($id);
        $pdf = Pdf::loadView('userEspecialista.atestado', ['atestado' => $atestado]);
        return $pdf->download('atestado.pdf');  
    }
}
