<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\AvaliacaoComentario;
use App\Models\Clinica;
use App\Models\Consulta;
use App\Models\Especialista;
use App\Models\Paciente;
use App\Models\User;
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
        $avaliacoes = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
            ->where('pacientes.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'P')
            ->select(
                'avaliacoes.categoria',
                'avaliacoes.nota',
                'avaliacoes_comentarios.comentario',
                'avaliacoes_comentarios.id',
                'avaliacoes_comentarios.status',
            )
            ->orderBy('avaliacoes_comentarios.id','desc')
            ->orderBy('avaliacoes.categoria','asc')
            ->paginate(16);

        $mediaNotas = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
            ->where('pacientes.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'P')
            ->where('avaliacoes_comentarios.status', 'Liberado')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;

        $mediaNotasCategoriaPontualidade = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('pacientes', 'pacientes.id', 'consultas.clinica_id')
            ->where('pacientes.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'P')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->where('avaliacoes.categoria', 'Pontualidade')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;

        $mediaNotasCategoriaAssiduidade = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('pacientes', 'pacientes.id', 'consultas.clinica_id')
            ->where('pacientes.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'P')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->where('avaliacoes.categoria', 'Assiduidade')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;


        return view('userPaciente.reputacao.lista', [
            'avaliacoes' => $avaliacoes,
            'mediaNotasCategoriaPontualidade' => $mediaNotasCategoriaPontualidade,
            'mediaNotasCategoriaAssiduidade' => $mediaNotasCategoriaAssiduidade,
            'mediaNotas' => $mediaNotas
        ]);
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
                'avaliacoes_comentarios.id',
                'avaliacoes_comentarios.status',
            )
            ->orderBy('avaliacoes_comentarios.id','desc')
            ->orderBy('avaliacoes.categoria','asc')
            ->paginate(32);//32 pois estou agrupando em 4 em 4
            
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
        
        return view('userClinica.reputacao.lista', [
            'avaliacoes' => $avaliacoes, 
            'mediaNotas' => $mediaNotas, 
            'mediaNotasCategoriaLocalizacao' => $mediaNotasCategoriaLocalizacao,
            'mediaNotasCategoriaLimpeza' => $mediaNotasCategoriaLimpeza,
            'mediaNotasCategoriaOrganizacao' => $mediaNotasCategoriaOrganizacao,
            'mediaNotasCategoriaTempo' => $mediaNotasCategoriaTempo
        ]);
    }

    public function reputacaoEspecialista()
    {       
        $user = Auth::user();
        $avaliacoes = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('especialistas', 'especialistas.id', 'consultas.especialista_id')
            ->where('especialistas.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'E')
            ->where('avaliacoes_comentarios.status', 'Liberado')      
            ->select(
                'avaliacoes.categoria',
                'avaliacoes.nota',
                'avaliacoes_comentarios.comentario',
                'avaliacoes_comentarios.id',
                'avaliacoes_comentarios.status',
            )
            ->orderBy('avaliacoes_comentarios.id','desc')
            ->orderBy('avaliacoes.categoria','asc')
            ->paginate(16);//16 pois estou agrupando em 2 em 2

        $mediaNotas = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('especialistas', 'especialistas.id', 'consultas.especialista_id')
            ->where('especialistas.usuario_id', $user->id)
           ->where('avaliacoes_comentarios.tipo_avaliado', 'E')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;

        $mediaNotasCategoriaAtendimento = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('especialistas', 'especialistas.id', 'consultas.especialista_id')
            ->where('especialistas.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'E')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->where('avaliacoes.categoria', 'Atendimento')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;
           
        $mediaNotasCategoriaTempo = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('especialistas', 'especialistas.id', 'consultas.especialista_id')
            ->where('especialistas.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'E')
            ->where('avaliacoes_comentarios.status', 'Liberado') 
            ->where('avaliacoes.categoria', 'Tempo de espera')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()
            ->total;
        
        return view('userEspecialista.reputacao.lista', [
            'avaliacoes' => $avaliacoes, 
            'mediaNotas' => $mediaNotas, 
            'mediaNotasCategoriaAtendimento' => $mediaNotasCategoriaAtendimento,
            'mediaNotasCategoriaTempo' => $mediaNotasCategoriaTempo
        ]);
    }

    public function denuciarUserClinica(Request $request){
       // dd($request);
        $comentarioClinica = AvaliacaoComentario::find($request->avaliacoes_comentarios_id);
        if ($comentarioClinica) {
            $comentarioClinica->status = "Em análise";
            $comentarioClinica->motivo_denuncia = $request->motivo_denuncia;
            $comentarioClinica->save();
            session()->flash('msg', ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success']);
        } 
        return redirect()->route('avaliacao.reputacaoClinica');
    }

    public function denuciarUserEspecialista(Request $request){
        // dd($request);
         $comentarioClinica = AvaliacaoComentario::find($request->avaliacoes_comentarios_id);
         if ($comentarioClinica) {
             $comentarioClinica->status = "Em análise";
             $comentarioClinica->motivo_denuncia = $request->motivo_denuncia;
             $comentarioClinica->save();
             session()->flash('msg', ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success']);
         } 
         return redirect()->route('avaliacao.reputacaoEspecialista');
    }

    public function reputacaoPacientes()
    {
        $users = User::where('tipo_user', "P")->get();
        $pacientes = [];
        foreach ($users as $key => $user) {
            $pacienteResponsavel = Paciente::where('usuario_id', $user->id)->where('responsavel', 1)->first();
            
            $pacientesUser = Paciente::join('consultas', 'consultas.paciente_id', 'pacientes.id')
                ->where('consultas.status', 'Finalizada')
                ->where('usuario_id', $user->id)
                ->select('pacientes.id', 'nome', 'cpf')
                ->groupBy('pacientes.id')
                ->get();

            foreach ($pacientesUser as $paciente) {
                $paciente->avaliacoes = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
                    ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
                    ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
                    ->where('consultas.paciente_id', $paciente->id)
                    ->where('avaliacoes_comentarios.tipo_avaliado', 'P')
                    ->whereNotNull('avaliacoes.nota')
                    ->select(
                        'avaliacoes.categoria',
                        DB::raw('(AVG(avaliacoes.nota)) as media')
                    )
                    ->groupBy('avaliacoes.categoria')
                    ->get();
                $paciente->responsavel = $pacienteResponsavel->nome;
            }
            $pacientes[$key] = $pacientesUser;
        }

        return view('user_root.pacientes.reputacao', ['pacientes' => $pacientes]);
    }
}
