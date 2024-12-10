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
        $atestado = Atestado::where('consulta_id', $id)->get();
        if($atestado->count() == 0) {
            $msg = ['valor' => trans("Nenhum atestado encontrado!"), 'tipo' => 'danger'];
            return Redirect()->back()->with('msg', $msg);
        }
        
        $imagePath = public_path('images/logo-01.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $src = 'data:image/png;base64,'.$imageData;

        $dados = [
            'atestado' => $atestado, 
            'logo' => $src,
        ];

        $pdf = Pdf::setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'disable_font_subsetting' => true,
            'image_dpi' => 96,
            'debug' => true,
            'isRemoteEnabled' => true
        ])
        ->loadView('userEspecialista.atestado', $dados)
        ->setPaper('a4');
        return $pdf->download('Atestado.pdf');  
    }
}
