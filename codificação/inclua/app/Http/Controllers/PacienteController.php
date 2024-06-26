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

   function marcarConsultaViaClinicaPasso1()
   {
      //retonando a lista de clincias
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Clinica::join('users', 'users.id', '=', 'usuario_id')->where('nome', 'like', "%" . "%")->orderBy('nome', 'asc')->select('clinicas.id', 'users.nome_completo as nome_responsavel', 'nome', 'cnpj', 'clinicas.telefone', 'clinicas.ativo')->paginate(8);
      return view('userPaciente/marcarConsultaViaClinicaPasso1', ['lista' => $lista, 'filtro' => $filter]);
   }

   function pesquisarclinicamarcarconsulta()
   {
      //retonando a lista de clincias
      $filtro = "";
      if (isset($_GET['filtro'])) {
         $filtro = $_GET['filtro'];
      }
      $lista = Clinica::join('users', 'users.id', '=', 'usuario_id')->where('nome', 'like', "%" . $filtro . "%")->orderBy('nome', 'asc')->select('clinicas.id', 'users.nome_completo as nome_responsavel', 'nome', 'cnpj', 'clinicas.telefone', 'clinicas.ativo')->paginate(8);
      $msg = null;      
      if ($lista->isEmpty()) {
         $msg = ['valor' => trans("Não foi encontrado nenhuma clínica com o nome digitado!"), 'tipo' => 'primary'];
      }
      return view('userPaciente/marcarConsultaViaClinicaPasso1', ['lista' => $lista, 'filtro' => $filtro, 'msg' => $msg]);
   }

   function marcarConsultaViaClinicaPasso2($clinica_id)
   {
      /*
      //todoas os especialista que eh vinculado a clinica
      $lista =  Especialistaclinica::
      join('especialistas', 'especialistas.id','=','especialistaclinicas.especialista_id')->
      where('clinica_id',$clinica_id)->
      orderBy('especialistas.nome', 'asc')->
      select('especialistas.id','especialistas.nome')->
      paginate(8);
      return view('userPaciente/marcarconsultapasso3', ['lista' => $lista]);
      */

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
