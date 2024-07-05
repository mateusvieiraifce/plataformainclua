<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Especialidadeclinica;
use App\Models\Especialistaclinica;
use App\Models\Consulta;
use App\Models\Especialista;
use App\Models\Especialidade;
use App\Models\Paciente;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
   public function create(Request $request)
   {
   }

   public function store(Request $request)
   {
      try {
         $paciente = Paciente::find($request->id_usuario);
         if (empty($paciente)) {
            $paciente = new Paciente();
         }
         $paciente = new Paciente();
         $paciente->nome = $request->nome;
         $paciente->usuario_id = $request->id_usuario;
         $paciente->data_nascimento = $request->data_nascimento;
         $paciente->sexo = $request->sexo;
         $paciente->save();
      } catch (QueryException $e) {
         session()->flash('msg', ['valor' => trans("Erro ao realizar o cadastro do paciente!"), 'tipo' => 'danger']);
      }
   }

   function historicoconsultas($msg = null)
   {
      $filtro = "";
      if (isset($_GET['filtro'])) {
         $filtro = $_GET['filtro'];
      }
      $paciente =  Paciente::where('usuario_id', '=', Auth::user()->id)->first();
      $statusConsulta = "Finalizada";
      $lista = Consulta::join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')->join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->join('especialidades', 'especialidades.id', '=', 'especialistas.especialidade_id')->where('paciente_id', '=', $paciente->id)->where('status', '=', $statusConsulta)->select(
            'consultas.id',
            'horario_agendado',
            'especialistas.nome as nome_especialista',
            'clinicas.nome as nome_clinica',
            'especialidades.descricao as descricao_especialidade'
         )->orderBy('horario_agendado', 'asc')->paginate(8);
      return view('userPaciente/historicoconsultas', ['lista' => $lista,  'msg' => $msg,'filtro' => $filtro]);
   }

   function minhasconsultas($msg = null)
   {
      $filtro = "";
      if (isset($_GET['filtro'])) {
         $filtro = $_GET['filtro'];
      }
      $paciente =  Paciente::where('usuario_id', '=', Auth::user()->id)->first();
      $statusConsulta = "Aguardando atendimento";
      $lista = Consulta::join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')->join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->join('especialidades', 'especialidades.id', '=', 'especialistas.especialidade_id')->where('paciente_id', '=', $paciente->id)->where('status', '=', $statusConsulta)->select(
            'consultas.id',
            'horario_agendado',
            'especialistas.nome as nome_especialista',
            'clinicas.nome as nome_clinica',
            'especialidades.descricao as descricao_especialidade'
         )->orderBy('horario_agendado', 'asc')->paginate(8);
      return view('userPaciente/minhasconsultas', ['lista' => $lista,  'msg' => $msg,'filtro' => $filtro]);
   }

   function marcarconsulta()
   {
      return view('userPaciente/marcarconsulta');
   }


   

   function marcarConsultaViaEspecialidadePasso1()
   {
      //retonando a lista de especialidades
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Especialidade::where('descricao', 'like', "%" . "%")->orderBy('descricao', 'asc')->paginate(8);
      return view('userPaciente/marcarConsultaViaEspecialidadePasso1', ['lista' => $lista, 'filtro' => $filter]);
   }

   function marcarConsultaViaEspecialidadePasso2($especialidade_id)
   {
      //retonando a lista de clinicas que possui a especialidade selecionada na opcao anterior
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Clinica::join('especialidadeclinicas', 'especialidadeclinicas.id', '=', 'clinica_id')      
      ->where('especialidade_id', $especialidade_id)->orderBy('nome', 'asc')->select('clinicas.id', 'nome')->paginate(8);
      return view('userPaciente/marcarConsultaViaEspecialidadePasso2', ['lista' => $lista, 'filtro' => $filter, 'especialidade_id'=>$especialidade_id]);
   }

   function marcarConsultaViaEspecialidadePasso3($especialidade_id,$clinica_id)
   {
      //retonando a lista de especialista que esta vinculado a clinica selecionada na opcao anterior
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }     
      $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialistaclinicas.especialista_id')->
      where('clinica_id', $clinica_id)->where('especialidade_id', $especialidade_id)->
      orderBy('especialistas.nome', 'asc')->select('especialistas.id', 'especialistas.nome')->paginate(8);
      return view('userPaciente/marcarConsultaViaEspecialidadePasso3', ['lista' => $lista, 'clinica_id' => $clinica_id,'especialidade_id'=>$especialidade_id]);
   }

   function marcarConsultaViaEspecialidadePasso4($clinica_id, $especialista_id)
   {
      $especialista = Especialista::find($especialista_id);
      $clinica = Clinica::find($clinica_id);
      $especialidade = Especialidade::find($especialista->especialidade_id);
      $paciente =  Paciente::where('usuario_id', '=', Auth::user()->id)->first();

      //retornar todos a agenda(consutlas) do especialista vinculados a clinica 
      $statusConsulta = "Disponível";
      $lista = Consulta::where('especialista_id', '=', $especialista_id)
      ->where('clinica_id', '=', $clinica_id)->
      where('status', '=', $statusConsulta)->
      select('consultas.id', 'horario_agendado','status')->orderBy('horario_agendado', 'asc')->paginate(8);
      //dd($lista);
      return view('userPaciente/marcarConsultaViaEspecialidadePasso4', ['lista' => $lista, 'especialista' => $especialista, 'clinica' => $clinica, 'especialidade' => $especialidade, 'paciente' => $paciente]);
   }

   

   function marcarConsultaViaClinicaPasso1()
   {
      //retonando a lista de clinicas
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Clinica::where('ativo', '1')->
      orderBy('nome', 'asc')
      ->select('clinicas.id', 'nome', 'clinicas.telefone')->paginate(8);
      return view('userPaciente/marcarConsultaViaClinicaPasso1', ['lista' => $lista, 'filtro' => $filter]);
   }

   function pesquisarclinicamarcarconsulta()
   {
      //retonando a lista de clincias
      $filtro = "";
      if (isset($_GET['filtro'])) {
         $filtro = $_GET['filtro'];
      }
      $lista = Clinica::where('nome', 'like', "%" . $filtro . "%")
      ->orderBy('nome', 'asc')
      ->select('clinicas.id', 'nome', 'clinicas.telefone')->paginate(8);
      $msg = null;      
      if ($lista->isEmpty()) {
         $msg = ['valor' => trans("Não foi encontrado nenhuma clínica com o nome digitado!"), 'tipo' => 'primary'];
      }
      return view('userPaciente/marcarConsultaViaClinicaPasso1', ['lista' => $lista, 'filtro' => $filtro, 'msg' => $msg]);
   }

   function marcarConsultaViaClinicaPasso2($clinica_id)
   {     
      //todas as especialidades que eh vinculado a clinica
      $lista = Especialidadeclinica::join('especialidades', 'especialidades.id', '=', 'especialidadeclinicas.especialidade_id')->where('clinica_id', $clinica_id)->orderBy('especialidades.descricao', 'asc')->select('especialidades.id', 'especialidades.descricao')->paginate(8);
      return view('userPaciente/marcarConsultaViaClinicaPasso2', ['lista' => $lista, 'clinica_id' => $clinica_id]);
   }

   function marcarConsultaViaClinicaPasso3($clinica_id, $especialidade_id)
   {
      //retornar todos os especialista vinculados a clinica e com a especiladade selecionada     
      $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialistaclinicas.especialista_id')->where('clinica_id', $clinica_id)->where('especialidade_id', $especialidade_id)->orderBy('especialistas.nome', 'asc')->select('especialistas.id', 'especialistas.nome')->paginate(8);
      return view('userPaciente/marcarConsultaViaClinicaPasso3', ['lista' => $lista, 'clinica_id' => $clinica_id]);
   }

   function marcarConsultaViaClinicaPasso4($clinica_id, $especialista_id)
   {
      $especialista = Especialista::find($especialista_id);
      $clinica = Clinica::find($clinica_id);
      $especialidade = Especialidade::find($especialista->especialidade_id);
      $paciente =  Paciente::where('usuario_id', '=', Auth::user()->id)->first();

      //retornar todos a agenda(consutlas) do especialista vinculados a clinica 
      $statusConsulta = "Disponível";

      $lista = Consulta::where('especialista_id', '=', $especialista_id)->where('clinica_id', '=', $clinica_id)->where('status', '=', $statusConsulta)->select('consultas.id', 'horario_agendado')->orderBy('horario_agendado', 'asc')->paginate(8);
      return view('userPaciente/marcarConsultaViaClinicaPasso4', ['lista' => $lista, 'especialista' => $especialista, 'clinica' => $clinica, 'especialidade' => $especialidade, 'paciente' => $paciente]);
   }

   function marcarConsultaViaClinicaFinalizar(Request $request)
   {
      $paciente =  Paciente::where('usuario_id', '=', Auth::user()->id)->first();

      $ent = Consulta::find($request->consulta_id);
      $ent->status = "Aguardando atendimento";
      $ent->paciente_id = $paciente->id;
      $ent->save();
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return  $this->minhasconsultas($msg);
   }
}
