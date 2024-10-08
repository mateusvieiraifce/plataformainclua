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
use Illuminate\Support\Facades\DB;

class AvaliacaoController extends Controller
{
    public function store(Request $request)
    {
        $consulta = Consulta::find($request->consulta_id);

        try {
            //cadastro avaliacao especialista
            if ($request->comentario_especialista == null) {
                $request->comentario_especialista = 'SEM COMENTÁRIO';
            }
            $comentarioEspecialista = new AvaliacaoComentario();
            $comentarioEspecialista->avaliador_id = Auth::user()->id;
            $comentarioEspecialista->comentario = $request->comentario_especialista;
            $comentarioEspecialista->tipo_avaliado = "E";
            $comentarioEspecialista->status = "Liberado";
            $comentarioEspecialista->save();   

            $avaliacaoEspecialista = new Avaliacao();
            $avaliacaoEspecialista->comentario_id = $comentarioEspecialista->id;
            $avaliacaoEspecialista->categoria = "Atendimento";
            $avaliacaoEspecialista->nota = $request->especialista_atendimento;
            $avaliacaoEspecialista->consulta_id = $consulta->id;
            $avaliacaoEspecialista->save();

            $avaliacaoEspecialista = new Avaliacao();
            $avaliacaoEspecialista->comentario_id = $comentarioEspecialista->id;
            $avaliacaoEspecialista->categoria = "Tempo de espera";
            $avaliacaoEspecialista->nota = $request->especialista_espera;
            $avaliacaoEspecialista->consulta_id = $consulta->id;
            $avaliacaoEspecialista->save();

           
           //cadastro avaliacao clinica
           if ($request->comentario_clinica == null) {
               $request->comentario_clinica = 'SEM COMENTÁRIO';
            }
            $comentarioClinica = new AvaliacaoComentario();
            $comentarioClinica->avaliador_id = Auth::user()->id;
            $comentarioClinica->comentario = $request->comentario_clinica;
            $comentarioClinica->tipo_avaliado = "C";
            $comentarioClinica->status = "Liberado";
            $comentarioClinica->save();
       
           
            $avaliacaoClinica = new Avaliacao();
            $avaliacaoClinica->categoria = "Localização";
            $avaliacaoClinica->nota = $request->clinica_localizacao;
            $avaliacaoClinica->consulta_id = $consulta->id;
            $avaliacaoClinica->comentario_id = $comentarioClinica->id;
            $avaliacaoClinica->save();

            $avaliacaoClinica = new Avaliacao();
            $avaliacaoClinica->categoria = "Limpeza";
            $avaliacaoClinica->nota = $request->clinica_limpeza;
            $avaliacaoClinica->consulta_id = $consulta->id;
            $avaliacaoClinica->comentario_id = $comentarioClinica->id;
            $avaliacaoClinica->save();

            $avaliacaoClinica = new Avaliacao();
            $avaliacaoClinica->categoria = "Organização";
            $avaliacaoClinica->nota = $request->clinica_organizacao;
            $avaliacaoClinica->consulta_id = $consulta->id;
            $avaliacaoClinica->comentario_id = $comentarioClinica->id;
            $avaliacaoClinica->save();

            $avaliacaoClinica = new Avaliacao();
            $avaliacaoClinica->categoria = "Tempo de espera";
            $avaliacaoClinica->nota = $request->clinica_espera;
            $avaliacaoClinica->consulta_id = $consulta->id;
            $avaliacaoClinica->comentario_id = $comentarioClinica->id;
            $avaliacaoClinica->save();

           
            $response = true;
        } catch (QueryException $e) {
            $response = false;
        }

        return response()->json($response);
    }

    public function reputacaoPaciente()
    {
        $user = Auth::user();
        $avaliacoes = Avaliacao::leftJoin('avaliacoes_comentarios', 'avaliacoes_comentarios.avaliacao_id', 'avaliacoes.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
            ->where('pacientes.usuario_id', $user->id)
            ->where('avaliacoes.tipo_avaliado', 'P')
            ->select(
                'avaliacoes.categoria',
                'avaliacoes.nota',
                'avaliacoes_comentarios.comentario',
            )
            ->paginate(8);

        $mediaNotas = Avaliacao::leftJoin('avaliacoes_comentarios', 'avaliacoes_comentarios.avaliacao_id', 'avaliacoes.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
            ->where('pacientes.usuario_id', $user->id)
            ->where('avaliacoes.tipo_avaliado', 'P')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;
        
        return view('userPaciente.reputacao.lista', ['avaliacoes' => $avaliacoes, 'mediaNotas' => $mediaNotas]);
    }

    public function reputacaoClinica()
    {
        $user = Auth::user();
        $avaliacoes = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('clinicas', 'clinicas.id', 'consultas.clinica_id')
            ->where('clinicas.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'C')
            ->where('avaliacoes_comentarios.status', 'Liberado')      
            ->select(
                'avaliacoes.categoria',
                'avaliacoes.nota',
                'avaliacoes_comentarios.comentario',
                 'avaliacoes_comentarios.status',
            )
            ->orderBy('avaliacoes_comentarios.id','desc')
            ->paginate(32);

           // dd($avaliacoes);
           

        $mediaNotas = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('clinicas', 'clinicas.id', 'consultas.clinica_id')
            ->where('clinicas.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'C')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;

        $mediaNotasCategoriaLocalizacao = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('clinicas', 'clinicas.id', 'consultas.clinica_id')
            ->where('clinicas.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'C')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->where('avaliacoes.categoria', 'Localização')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;

        $mediaNotasCategoriaLimpeza =AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('clinicas', 'clinicas.id', 'consultas.clinica_id')
            ->where('clinicas.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'C')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->where('avaliacoes.categoria', 'Limpeza')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;
        $mediaNotasCategoriaOrganizacao =AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('clinicas', 'clinicas.id', 'consultas.clinica_id')
            ->where('clinicas.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'C')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->where('avaliacoes.categoria', 'Organização')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;

        $mediaNotasCategoriaTempo = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('clinicas', 'clinicas.id', 'consultas.clinica_id')
            ->where('clinicas.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'C')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->where('avaliacoes.categoria', 'Tempo de espera')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;
        
        return view('userClinica.reputacao.lista', ['avaliacoes' => $avaliacoes, 
        'mediaNotas' => $mediaNotas, 
        'mediaNotasCategoriaLocalizacao' => $mediaNotasCategoriaLocalizacao,
        'mediaNotasCategoriaLimpeza' => $mediaNotasCategoriaLimpeza,
        'mediaNotasCategoriaOrganizacao' => $mediaNotasCategoriaOrganizacao,
        'mediaNotasCategoriaTempo' => $mediaNotasCategoriaTempo]);
    }
     
}
