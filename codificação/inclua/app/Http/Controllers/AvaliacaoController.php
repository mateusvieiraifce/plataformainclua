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

    public function storeAvaliacaoEspecialista(Request $request)
    {
        try {
            $consulta = Consulta::find($request->consulta_id);
            if ($request->comentario_especialista == null) {
                $request->comentario_especialista = 'SEM COMENTÁRIO';
            }
            $comentarioEspecialista = new AvaliacaoComentario();
            $comentarioEspecialista->avaliador_id = Auth::user()->id;
            $comentarioEspecialista->comentario = $request->comentario_especialista;
            $comentarioEspecialista->tipo_avaliado = "P";
            $comentarioEspecialista->status = "Liberado";
            $comentarioEspecialista->save();

            $avaliacaoEspecialista = new Avaliacao();
            $avaliacaoEspecialista->comentario_id = $comentarioEspecialista->id;
            $avaliacaoEspecialista->categoria = "Pontualidade";
            $avaliacaoEspecialista->nota = $request->especialista_atendimento;
            $avaliacaoEspecialista->consulta_id = $consulta->id;
            $avaliacaoEspecialista->save();

            $avaliacaoEspecialista = new Avaliacao();
            $avaliacaoEspecialista->comentario_id = $comentarioEspecialista->id;
            $avaliacaoEspecialista->categoria = "Assiduidade";
            $avaliacaoEspecialista->nota = $request->especialista_espera;
            $avaliacaoEspecialista->consulta_id = $consulta->id;
            $avaliacaoEspecialista->save();
            $msg = ['valor' => trans("Avaliação realizada com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        }catch (\Exception $e){
            $msg = ['valor' => trans("Houve algum problema na sua avaliação, tente novamente!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
        return redirect()->route('consulta.listConsultaPorEspecialistaPesquisar');


    }
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
            $msg = ['valor' => trans("Avaliação realizada com sucesso!"), 'tipo' => 'success'];
            $response = true;

        } catch (QueryException $e) {
            $msg = ['valor' => trans("Houveram problemas na sua avaliação, tente novamente!"), 'tipo' => 'danger'];
        }


        session()->flash('msg', $msg);
        return redirect()->route('paciente.historicoconsultas');
      //  return response()->json($response);
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
            ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
            ->where('pacientes.usuario_id', $user->id)
            ->where('avaliacoes_comentarios.tipo_avaliado', 'P')
            ->where('avaliacoes_comentarios.status', 'Liberado')
            ->where('avaliacoes.categoria', 'Pontualidade')
            ->select(DB::raw('(AVG(avaliacoes.nota)) as total'))
            ->first()->total;


        $mediaNotasCategoriaAssiduidade = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
            ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
            ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
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



        $pacientes = User::join('pacientes', 'pacientes.usuario_id', 'users.id')
            ->join('consultas', 'consultas.paciente_id', 'pacientes.id')
            ->join('avaliacoes', 'avaliacoes.consulta_id', 'consultas.id')
            ->join('avaliacoes_comentarios', 'avaliacoes_comentarios.id', 'avaliacoes.comentario_id')
            ->where('avaliacoes_comentarios.tipo_avaliado', 'P')
            ->where('users.tipo_user', 'P')
            ->where('consultas.status', 'Finalizada')
            ->select(
                'pacientes.cpf', 'pacientes.id', 'pacientes.nome', 'pacientes.usuario_id'
            )
            ->groupBy('pacientes.cpf', 'pacientes.id', 'pacientes.nome',"pacientes.usuario_id")
            ->paginate(8);
        //dd("a primeira consulta ok");

        foreach ($pacientes as $paciente) {
            $resp = Paciente::where('usuario_id', $paciente->usuario_id)->where('responsavel', 1)->first();
            if ($resp) {
                $paciente->responsavel = $resp->nome;
            }else{
                $paciente->responsavel = $paciente->nome;
            }

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
        }

        return view('user_root.pacientes.reputacao', ['pacientes' => $pacientes]);
    }

    public function reputacaoEspecialistas()
    {
        $especialistas = User::join('especialistas', 'especialistas.usuario_id', 'users.id')
            ->join('consultas', 'consultas.especialista_id', 'especialistas.id')
            ->join('avaliacoes', 'avaliacoes.consulta_id', 'consultas.id')
            ->join('avaliacoes_comentarios', 'avaliacoes_comentarios.id', 'avaliacoes.comentario_id')
            ->where('avaliacoes_comentarios.tipo_avaliado', 'E')
            ->where('users.tipo_user', "E")
            ->where('consultas.status', 'Finalizada')
            ->select(
                'users.documento as documento', 'especialistas.id', 'especialistas.nome'
            )
            ->groupBy('documento', 'especialistas.id', 'especialistas.nome')
            ->paginate(8);

        foreach ($especialistas as $especialista) {
            $especialista->avaliacoes = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
                ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
                ->join('especialistas', 'especialistas.id', 'consultas.especialista_id')
                ->where('avaliacoes_comentarios.tipo_avaliado', 'E')
                ->whereNotNull('avaliacoes.nota')
                ->select(
                    'avaliacoes.categoria',
                    DB::raw('(AVG(avaliacoes.nota)) as media')
                )
                ->groupBy('avaliacoes.categoria')
                ->get();
        }

        return view('user_root.especialistas.reputacao', ['especialistas' => $especialistas]);
    }

    public function reputacaoClinicas()
    {
        $clinicas = User::join('clinicas', 'clinicas.usuario_id', 'users.id')
            ->join('consultas', 'consultas.especialista_id', 'clinicas.id')
            ->join('avaliacoes', 'avaliacoes.consulta_id', 'consultas.id')
            ->join('avaliacoes_comentarios', 'avaliacoes_comentarios.id', 'avaliacoes.comentario_id')
            ->where('avaliacoes_comentarios.tipo_avaliado', 'C')
            ->where('users.tipo_user', "C")
            ->where('consultas.status', 'Finalizada')
            ->select(
                'users.documento as documento', 'clinicas.id', 'clinicas.nome'
            )
            ->groupBy('documento', 'clinicas.id', 'clinicas.nome')
            ->paginate(8);

        foreach ($clinicas as $clinica) {
            $clinica->avaliacoes = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
                ->join('consultas', 'consultas.id', 'avaliacoes.consulta_id')
                ->join('clinicas', 'clinicas.id', 'consultas.clinica_id')
                ->where('avaliacoes_comentarios.tipo_avaliado', 'C')
                ->whereNotNull('avaliacoes.nota')
                ->select(
                    'avaliacoes.categoria',
                    DB::raw('(AVG(avaliacoes.nota)) as media')
                )
                ->groupBy('avaliacoes.categoria')
                ->get();
        }

        return view('user_root.clinicas.reputacao', ['clinicas' => $clinicas]);
    }
}
