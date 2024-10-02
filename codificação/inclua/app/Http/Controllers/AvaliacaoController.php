<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\AvaliacaoComentario;
use App\Models\Clinica;
use App\Models\Consulta;
use App\Models\Especialista;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    public function store(Request $request)
    {
        $consulta = Consulta::find($request->consulta_id);

        try {
            $avaliacaoEspecialista = new Avaliacao();
            $avaliacaoEspecialista->categoria = "Atendimento";
            $avaliacaoEspecialista->nota = $request->especialista_atendimento;
            $avaliacaoEspecialista->avaliador_id = Auth::user()->id;
            $avaliacaoEspecialista->consulta_id = $consulta->id;
            $avaliacaoEspecialista->tipo_avaliado = "E";
            $avaliacaoEspecialista->save();

            $avaliacaoEspecialista = new Avaliacao();
            $avaliacaoEspecialista->categoria = "Tempo de espera";
            $avaliacaoEspecialista->nota = $request->especialista_espera;
            $avaliacaoEspecialista->avaliador_id = Auth::user()->id;
            $avaliacaoEspecialista->consulta_id = $consulta->id;
            $avaliacaoEspecialista->tipo_avaliado = "E";
            $avaliacaoEspecialista->save();

            if ($request->comentario_especialista != null) {
                $comentarioEspecialista = new AvaliacaoComentario();
                $comentarioEspecialista->avaliacao_id = $avaliacaoEspecialista->id;
                $comentarioEspecialista->comentario = $request->comentario_especialista;
                $comentarioEspecialista->save();
            }

            $avaliacaoClinica = new Avaliacao();
            $avaliacaoClinica->categoria = "Localização";
            $avaliacaoClinica->nota = $request->clinica_localizacao;
            $avaliacaoClinica->avaliador_id = Auth::user()->id;
            $avaliacaoClinica->consulta_id = $consulta->id;
            $avaliacaoClinica->tipo_avaliado = "C";
            $avaliacaoClinica->save();

            $avaliacaoClinica = new Avaliacao();
            $avaliacaoClinica->categoria = "Limpeza";
            $avaliacaoClinica->nota = $request->clinica_limpeza;
            $avaliacaoClinica->avaliador_id = Auth::user()->id;
            $avaliacaoClinica->consulta_id = $consulta->id;
            $avaliacaoClinica->tipo_avaliado = "C";
            $avaliacaoClinica->save();

            $avaliacaoClinica = new Avaliacao();
            $avaliacaoClinica->categoria = "Organização";
            $avaliacaoClinica->nota = $request->clinica_organizacao;
            $avaliacaoClinica->avaliador_id = Auth::user()->id;
            $avaliacaoClinica->consulta_id = $consulta->id;
            $avaliacaoClinica->tipo_avaliado = "C";
            $avaliacaoClinica->save();

            $avaliacaoClinica = new Avaliacao();
            $avaliacaoClinica->categoria = "Tempo de espera";
            $avaliacaoClinica->nota = $request->clinica_espera;
            $avaliacaoClinica->avaliador_id = Auth::user()->id;
            $avaliacaoClinica->consulta_id = $consulta->id;
            $avaliacaoClinica->tipo_avaliado = "E";
            $avaliacaoClinica->save();

            if ($request->comentario_clinica != null) {
                $comentarioClinica = new AvaliacaoComentario();
                $comentarioClinica->avaliacao_id = $avaliacaoClinica->id;
                $comentarioClinica->comentario = $request->comentario_clinica;
                $comentarioClinica->save();
            }
            $response = true;
        } catch (QueryException $e) {
            $response = false;
        }

        return response()->json($response);
    }
}
