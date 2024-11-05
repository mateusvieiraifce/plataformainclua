<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Consulta;
use App\Models\Clinica;
use App\Models\Fila;
use App\Models\Especialidadeclinica;
use App\Models\Especialistaclinica;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Especialista;
use Carbon\Carbon;

class ConsultaController extends Controller
{
   //list de consultas disponiveis - User Especialista 
   function list($msg = null)
   {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      $especialista_id = $especialista->id;
      $filter = "";     
      
      $hoje = Carbon::today()->startOfDay();
      $dataAtual = Carbon::now();
      $dataUmMesFrente = $dataAtual->addMonth()->startOfDay();      

      //todoas as clinicas que o especialista eh vinculado
      $clinicas = Especialistaclinica::join('clinicas', 'clinicas.id', '=', 'especialistaclinicas.clinica_id')->
      where('especialista_id', $especialista->id)->
      orderBy('clinicas.nome', 'asc')->select('clinicas.id', 'clinicas.nome')->get();
      //caso o especialista esteja vinculado a apenas uma clinicar, ja estou deixando o select selecionando a clinica
      $clinicaselecionada_id = 0;
      if (sizeof($clinicas) == 1) {
         $clinicaselecionada_id = $clinicas[0]->id;
      }
      $statusConsulta = "Disponível";
      $lista = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->
      where('especialista_id', '=', $especialista_id)->
      where('status', '=', $statusConsulta)->
      whereBetween('horario_agendado', [$hoje, $dataUmMesFrente])->
      select('consultas.id', 'status', 'horario_agendado', 'clinicas.nome as nome_clinica')->
      orderBy('horario_agendado', 'asc')->paginate(8);
    
      return view('userEspecialista.listtodasconsultas', 
      ['lista' => $lista, 'clinicas' => $clinicas, 'clinicaselecionada_id' =>
       $clinicaselecionada_id, 'status' => $statusConsulta, 'filtro' => $filter, 
       'inicio_data' => $hoje->format('Y-m-d'),
       'final_data' => $dataUmMesFrente->format('Y-m-d'),
       'especialista' => $especialista, 'msg' => $msg]);
   }

   function search(Request $request)
   {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      $especialista_id = $especialista->id;
      $filter = "";
     
      //todoas as clinicas que o especialista eh vinculado
      $clinicas = Especialistaclinica::join('clinicas', 'clinicas.id', '=', 'especialistaclinicas.clinica_id')->
      where('especialista_id', $especialista->id)->
      orderBy('clinicas.nome', 'asc')->select('clinicas.id', 'clinicas.nome')->get();
      //caso o especialista esteja vinculado a apenas uma clinicar, ja estou deixando o select selecionando a clinica
      $clinicaselecionada_id = 0;
      if (sizeof($clinicas) == 1) {
         $clinicaselecionada_id = $clinicas[0]->id;
      }

      $statusConsulta = "Disponível";
      $inicioDoDiaFiltro = Carbon::parse($request->inicio_data)->startOfDay();
      $fimDoDiaFiltro = Carbon::parse($request->final_data)->endOfDay();
    

      $lista = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->
      where('especialista_id', '=', $especialista_id)->
      where('status', '=', $statusConsulta)->
      where('clinicas.id', $request->clinica_id)->
      whereBetween('horario_agendado', [$inicioDoDiaFiltro, $fimDoDiaFiltro])->
      select('consultas.id', 'status', 'horario_agendado', 'clinicas.nome as nome_clinica')->
      orderBy('horario_agendado', 'asc')->paginate(8);
      return view('userEspecialista.listtodasconsultas', ['lista' => $lista, 'clinicas' => $clinicas,
       'clinicaselecionada_id' => $clinicaselecionada_id, 'status' => $statusConsulta, 
       'inicio_data' => $request->inicio_data,
       'final_data' => $request->final_data,
      'filtro' => $filter, 'especialista' => $especialista]);

   }


   function save(Request $request)
   {
      $especialista_id = $request->especialista_id;
      if ($request->id) {
         $ent = Consulta::find($request->id);
         $ent->status = $request->status;
         $ent->horario_agendado = $request->horario_agendado;
         $ent->horario_iniciado = $request->horario_iniciado;
         $ent->horario_finalizado = $request->horario_finalizado;
         $ent->preco = $request->preco;
         $ent->porcetagem_repasse_clinica = $request->porcetagem_repasse_clinica;
         $ent->porcetagem_repasse_plataforma = $request->porcetagem_repasse_plataforma;
         $ent->paciente_id = $request->paciente_id;
         $ent->clinica_id = $request->clinica_id;
         $ent->especialista_id = $especialista_id;
         $ent->save();
      } else {
         $entidade = Consulta::create([
            'status' => $request->status,
            'horario_agendado' => $request->horario_agendado,
            'horario_iniciado' => $request->horario_iniciado,
            'horario_finalizado' => $request->horario_finalizado,
            'preco' => $request->preco,
            'porcetagem_repasse_clinica' => $request->porcetagem_repasse_clinica,
            'porcetagem_repasse_plataforma' => $request->porcetagem_repasse_plataforma,
            'paciente_id' => $request->paciente_id,
            'clinica_id' => $request->clinica_id,
            'especialista_id' => $especialista_id
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($especialista_id, $msg);
   }
   function delete($id)
   {
      try {
         $entidade = Consulta::find($id);
         if ($entidade) {
            $entidade->delete();
            $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
         } else {
            $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
         }
      } catch (QueryException $exp) {
         $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
      }
      return $this->list($msg);
   }
   function edit($id)
   {
      $entidade = Consulta::find($id);
      $especialista_id = $entidade->especialista_id;
      $especialista = Especialista::find($especialista_id);
      return view('consulta/form', ['entidade' => $entidade, 'especialista' => $especialista]);
   }

   function agenda()
   {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      //todoas as clinicas que o especialista eh vinculado
      $clinicas = Especialistaclinica::join('clinicas', 'clinicas.id', '=', 'especialistaclinicas.clinica_id')->
      where('especialista_id', $especialista->id)->
      where('is_vinculado', true)->
      orderBy('clinicas.nome', 'asc')->
      select('clinicas.id', 'clinicas.nome')->get();

      //retorna todas as relacoes que o especialista possui com a clinica
      //( está sendo feito para poder pegar o valor padrao por ESPECIALIDADE)
      $relacaoEspecialidadeClinica = Especialidadeclinica::     
      where('especialidade_id', $especialista->especialidade_id)->get();  

      return view('userEspecialista/agenda', ['entidade' => new Consulta(), 'especialista' => $especialista, 
      'clinicas' => $clinicas,
      'relacaoEspecialidadeClinica' =>  $relacaoEspecialidadeClinica]);
   }

   function novaConsultasUserClinica($especialista_id)
   {  
      $especialista = Especialista::find($especialista_id); 
     
      //esse treco de codigo serve apenas para verificar se nao foi alterado a url
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();      
      $relacaoEspecialistaClinica = Especialistaclinica::
      where('clinica_id', $clinica->id)->
      where('especialista_id', $especialista->id)->
      where('is_vinculado', true)->
      first();
      if(!isset($relacaoEspecialistaClinica)){
         return redirect()->route('especialistaclinica.list');
      }     
      
      // pegando o preco da consulta que esta associado a clinica
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();      
      $relacaoEspecialidadeClinica = Especialidadeclinica::
      where('clinica_id', $clinica->id)->
      where('especialidade_id', $especialista->especialidade_id)->
      first();
    
      $precoConsulta = $relacaoEspecialidadeClinica->valor;
      return view('userClinica/cadVinculoEspecialista/cadAgenda', [
         'entidade' => new Consulta(), 
      'especialista' => $especialista, 'precoConsulta'=>$precoConsulta]); 
   }

   function saveVariasConsultasUserClinica(Request $request)
   {
      $especialista_id = $request->especialista_id;
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();

      $startDate = Carbon::parse($request->data_inicio);
      $endDate = Carbon::parse($request->data_fim);

      //  dd($request);
      // Loop através do intervalo de datas
      $qtdConsutasCriadas = 1;
      $tempoDuracaoConsulta = $request->duracao_media;
      for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
         // dayOfWeek retorna 0 a 6 para para o dia da semana            
         if (in_array($date->dayOfWeek, $request->dia)) {
            //criando as consulta de acordo com o dia
            $hora_inicio = $request->hora_inicio;
            $hora_fim = $request->hora_fim;
            // Convertendo para objetos DateTime          
            $dataInic = $date->format('Y-m-d') . ' ' . $hora_inicio;
            $inicio = Carbon::createFromTimeString($date->format('Y-m-d') . ' ' . $hora_inicio);
            $termino = Carbon::createFromTimeString($date->format('Y-m-d') . ' ' . $hora_fim);
            //  $inicio->modify("+$request->duracao_media minutes");
            //add tempo de intervalo entre consulta
            $request->duracao_media = $tempoDuracaoConsulta + $request->intervalo_consulta;
            //  dd( $request->duracao_media);
            $termino->modify("-$request->duracao_media minutes");
            while ($termino >= $inicio) {
               $entidade = Consulta::create([
                  'status' => "Disponível",
                  'horario_agendado' => $inicio,
                  'preco' => $request->preco,
                  'porcetagem_repasse_clinica' => $request->porcetagem_repasse_clinica,
                  'porcetagem_repasse_plataforma' => $request->porcetagem_repasse_plataforma,
                  'clinica_id' => $clinica->id,
                  'especialista_id' => $especialista_id
               ]);

               $inicio->modify("+$request->duracao_media minutes");
               $qtdConsutasCriadas++;
            }
         }
      }

      $qtdConsutasCriadas--;
      $msg = ['valor' => trans("Operação realizada com sucesso! Foram criadas " . $qtdConsutasCriadas . " consultas."), 'tipo' => 'success'];
      $especialistaclinicaController = new EspecialistaclinicaController();
      return $especialistaclinicaController->list($msg);
   }

   function saveVariasConsultas(Request $request)
   {
      date_default_timezone_set('America/Sao_Paulo');
      $especialista_id = $request->especialista_id;

      $startDate = Carbon::parse($request->data_inicio);
      $endDate = Carbon::parse($request->data_fim);

      //  dd($request);
      // Loop através do intervalo de datas
      $qtdConsutasCriadas = 1;
      $tempoDuracaoConsulta = $request->duracao_media;
      for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
         // dayOfWeek retorna 0 a 6 para para o dia da semana            
         if (in_array($date->dayOfWeek, $request->dia)) {
            //criando as consulta de acordo com o dia
            $hora_inicio = $request->hora_inicio;
            $hora_fim = $request->hora_fim;
            // Convertendo para objetos DateTime
            // dd($date->format('Y-m-d'));
            // $dataCons = Carbon::createFromFormat('Y-m-d', $data);
            //  $inicio =  new \DateTime($date->format('Y-m-d')+"T$hora_inicio");
            $dataInic = $date->format('Y-m-d') . ' ' . $hora_inicio;
            $inicio = Carbon::createFromTimeString($date->format('Y-m-d') . ' ' . $hora_inicio);
            $termino = Carbon::createFromTimeString($date->format('Y-m-d') . ' ' . $hora_fim);
            //  $inicio->modify("+$request->duracao_media minutes");
            //add tempo de intervalo entre consulta
            $request->duracao_media = $tempoDuracaoConsulta + $request->intervalo_consulta;
            //  dd( $request->duracao_media);
            $termino->modify("-$request->duracao_media minutes");
            while ($termino >= $inicio) {
               $entidade = Consulta::create([
                  'status' => "Disponível",
                  'horario_agendado' => $inicio,
                  'preco' => $request->preco,
                  'porcetagem_repasse_clinica' => $request->porcetagem_repasse_clinica,
                  'porcetagem_repasse_plataforma' => $request->porcetagem_repasse_plataforma,
                  'clinica_id' => $request->clinica_id,
                  'especialista_id' => $especialista_id
               ]);

               $inicio->modify("+$request->duracao_media minutes");
               $qtdConsutasCriadas++;
            }
         }
      }

      $qtdConsutasCriadas--;
    //  $msg = ['valor' => trans("Operação realizada com sucesso! Foram criadas " . $qtdConsutasCriadas . " consultas."), 'tipo' => 'success'];
      session()->flash('msg', ['valor' => trans("Operação realizada com sucesso! Foram criadas " . $qtdConsutasCriadas . " consultas."), 'tipo' => 'success']);
      return  redirect()->route('consulta.list'); 
   }

   function listconsultaporespecialista($msg = null)
   {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }

      //todoas as clinicas que o especialista eh vinculado
      $clinicas = Especialistaclinica::join('clinicas', 'clinicas.id', '=', 'especialistaclinicas.clinica_id');

      if (auth()->user()->tipo_user == "P") {
         $clinicas = $clinicas->where('especialista_id', $especialista->id);
      }

      $clinicas = $clinicas->orderBy('clinicas.nome', 'asc')
         ->select('clinicas.id', 'clinicas.nome')
         ->get();

      //caso o especialista esteja vinculado a apenas uma clinicar, ja estou deixando o select selecionando a clinica
      $clinicaselecionada_id = 0;
      if (sizeof($clinicas) == 1) {
         $clinicaselecionada_id = $clinicas[0]->id;
      }

      //retornar na pagina de consulta do especialista as consultas do dia e que estao 'Sala de espera'
      $inicioDoDia = Carbon::today()->startOfDay();
      $fimDoDia = Carbon::today()->endOfDay();

      $statusConsulta = "Sala de espera";
      $lista = Consulta::join('clinicas', 'clinicas.id', 'consultas.clinica_id')
         ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
         ->join('especialistas', 'especialistas.id', 'consultas.especialista_id');
         
      if (auth()->user()->tipo_user == "P") {
         $lista = $lista->where('especialista_id', $especialista->id);
      }
         
      $lista = $lista->where('status', $statusConsulta)
         ->whereBetween('horario_agendado', [$inicioDoDia, $fimDoDia])
         ->select(
            'consultas.id', 'status', 'horario_agendado', 'clinicas.nome as nome_clinica',
            'pacientes.nome as nome_paciente', 'especialistas.nome as nome_especialista'
         )
         ->orderBy('horario_agendado', 'asc')
         ->get();

      return view('userEspecialista/listConsultaMarcadas', [
         'lista' => $lista,
         'clinicas' => $clinicas,
         'clinicaselecionada_id' => $clinicaselecionada_id,
         'status' => $statusConsulta,
         'filtro' => $filter,
         'especialista' => $especialista,        
         'msg' => $msg
      ]);
   }

   function listConsultaPorEspecialistaPesquisar(Request $request, $msg = null)
   {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }

      //todoas as clinicas que o especialista eh vinculado
      $clinicas = Especialistaclinica::join('clinicas', 'clinicas.id', '=', 'especialistaclinicas.clinica_id');
      
      if (auth()->user()->tipo_user == "P") {
         $clinicas = $clinicas->where('especialista_id', $especialista->id);
      }

      $clinicas = $clinicas->orderBy('clinicas.nome', 'asc')
         ->select('clinicas.id', 'clinicas.nome')
         ->get();

      $inicioDoDiaFiltro = Carbon::parse($request->inicio_data)->startOfDay();
      $fimDoDiaFiltro = Carbon::parse($request->final_data)->endOfDay();

      // dd($inicioDoDiaFiltro,$fimDoDiaFiltro);
      if ($request->status == "todos") {
         $statusConsulta = "%%";
      } else {
         $statusConsulta = $request->status;
      }

      $lista = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')
         ->join('pacientes', 'pacientes.id', '=', 'consultas.paciente_id')
         ->join('especialistas', 'especialistas.id', 'consultas.especialista_id');

      if (auth()->user()->tipo_user == "P") {
         $lista = $lista->where('especialista_id', '=', $especialista->id);
      }
      
      $lista = $lista->where('status', 'like', $statusConsulta)
         ->where('pacientes.nome', 'like', '%' . $request->nomepaciente . "%")
         ->where('clinicas.id', $request->clinica_id)
         ->whereBetween('horario_agendado', [$inicioDoDiaFiltro, $fimDoDiaFiltro])
         ->select(
            'consultas.id', 'status', 'horario_agendado', 'clinicas.nome as nome_clinica',
            'pacientes.nome as nome_paciente', 'especialistas.nome as nome_especialista'
         )
         ->orderBy('horario_agendado', 'asc')
         ->get();

      return view('userEspecialista/listConsultaMarcadas', [
         'lista' => $lista,
         'clinicas' => $clinicas,
         'clinicaselecionada_id' => $request->clinica_id,
         'status' => $request->status,
         'filtro' => $filter,
         'especialista' => $especialista,
         'inicio_data' => $request->inicio_data,
         'final_data' => $request->final_data,
         'nomepaciente' => $request->nomepaciente,
         'msg' => $msg
      ]);
   }

   
   function listConsultaAgendadaUserClinica($msg = null)
   {
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }

      //todoas os especialistas que a clinica eh vinculado
      $especialistas = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialistaclinicas.especialista_id')->where('clinica_id', $clinica->id)->orderBy('especialistas.nome', 'asc')->select('especialistas.id', 'especialistas.nome')->get();

      // Obtém a data atual
      $dataAtual = Carbon::now();
      $inicioDoDia = $dataAtual->startOfDay();
      $fimDoDia = Carbon::today()->endOfDay();

      // selecionar as consultas na qual o status diferente de 
      // FINALIZADA, CANCELADA
      $lista = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->
      join('pacientes', 'pacientes.id', '=', 'consultas.paciente_id')->
      join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')->
      join('especialistaclinicas', 'especialistaclinicas.especialista_id', '=', 'consultas.especialista_id')->
      where('consultas.clinica_id', '=', $clinica->id)->
      where('status', '!=', 'Finalizada')->
      where('status', '!=', 'Cancelada')->
      whereBetween('horario_agendado', [$inicioDoDia, $fimDoDia])->
      select('consultas.id', 'status', 'horario_agendado', 'especialistas.nome as nome_especialista', 
       'pacientes.cpf as cpf','local_consulta','preco','isPago',
      'pacientes.nome as nome_paciente')->orderBy('horario_agendado', 'asc')->get();

      return view('userClinica/listConsultaAgenda', [
         'lista' => $lista,
         'especialistas' => $especialistas,
         'filtro' => $filter,
         'clinica' => $clinica,
         'status' => "Todos",
         'especialistaSelecionado_id' => "Todos",
         'msg' => $msg,
         'inicio_data' => $inicioDoDia->format('Y-m-d'),
         'final_data' => $fimDoDia->format('Y-m-d')
      ]);
   }

   function listConsultaAgendadaUserClinicaPesquisar(Request $request, $msg = null)
   {    
      // dd($request);

      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      //todoas os especialistas que a clinica eh vinculado
      $especialistas = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialistaclinicas.especialista_id')->
      where('clinica_id', $clinica->id)->orderBy('especialistas.nome', 'asc')->
      select('especialistas.id', 'especialistas.nome')->get();


      $inicioDoDiaFiltro = Carbon::parse($request->inicio_data)->startOfDay();
      $fimDoDiaFiltro = Carbon::parse($request->final_data)->endOfDay();
    

      if ($request->especialista_id == "todos") {
         $lista = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->
         join('pacientes', 'pacientes.id', '=', 'consultas.paciente_id')->
         join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')->
         join('especialistaclinicas', 'especialistaclinicas.especialista_id', '=', 'consultas.especialista_id')->
         where('consultas.clinica_id', '=', $clinica->id)->
         where('status', '!=', 'Finalizada')->
         where('status', '!=', 'Cancelada')->
         where('pacientes.nome', 'like', '%' . $request->nomepaciente . "%")->
         where('pacientes.cpf', 'like', '%' . $request->cpf . "%")->
         whereBetween('horario_agendado', [$inicioDoDiaFiltro, $fimDoDiaFiltro])->
         select('consultas.id', 'status', 'horario_agendado', 'especialistas.nome as nome_especialista',
         'pacientes.cpf as cpf', 'local_consulta','preco','isPago',
         'pacientes.nome as nome_paciente')->orderBy('horario_agendado', 'asc')->get();
      } else {
         $lista = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->
         join('pacientes', 'pacientes.id', '=', 'consultas.paciente_id')->
         join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')->
         join('especialistaclinicas', 'especialistaclinicas.especialista_id', '=', 'consultas.especialista_id')->
         where('consultas.clinica_id', '=', $clinica->id)->
         where('status', '!=', 'Finalizada')->
         where('status', '!=', 'Cancelada')->
         where('pacientes.nome', 'like', '%' . $request->nomepaciente . "%")->
         where('pacientes.cpf', 'like', '%' . $request->cpf . "%")->
         where('consultas.especialista_id', $request->especialista_id)->
         whereBetween('horario_agendado', [$inicioDoDiaFiltro, $fimDoDiaFiltro])->
         select('consultas.id', 'status', 'horario_agendado', 'especialistas.nome as nome_especialista',
          'pacientes.cpf as cpf','local_consulta','preco','isPago',
         'pacientes.nome as nome_paciente')->orderBy('horario_agendado', 'asc')->get();
      }

    // dd($request, $lista);
      return view('userClinica/listConsultaAgenda', [
         'lista' => $lista,
         'especialistas' => $especialistas,
         'especialistaSelecionado_id' => $request->especialista_id,
         'filtro' => $filter,
         'inicio_data' => $request->inicio_data,
         'final_data' => $request->final_data,
         'nomepaciente' => $request->nomepaciente,
         'cpf' => $request->cpf,
         'msg' => $msg
      ]);
   }

   function listConsultaporClinica($msg = null)
   {
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      //todoas os especialistas que a clinica eh vinculado
      $especialistas = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialistaclinicas.especialista_id');
      
      if(auth()->user()->tipo_user == "C") {
         $especialistas = $especialistas->where('clinica_id', $clinica->id);
      }

      $especialistas = $especialistas->orderBy('especialistas.nome', 'asc')
         ->select('especialistas.id', 'especialistas.nome')
         ->get();

      // Obtém a data atual
      $dataAtual = Carbon::now();
      // Calcula a data de um mês atrás
      $dataUmMesAtras = $dataAtual->subMonth();
      $inicioDoDia = $dataUmMesAtras->startOfDay();
      $fimDoDia = Carbon::today()->endOfDay();

      $lista = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')
         ->join('pacientes', 'pacientes.id', '=', 'consultas.paciente_id')
         ->join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id');
         
      if(auth()->user()->tipo_user == "C") {
         $lista = $lista->where('clinica_id', '=', $clinica->id);
      }

      $lista = $lista->whereBetween('horario_agendado', [$inicioDoDia, $fimDoDia])
         ->select(
            'consultas.id', 'status', 'horario_agendado', 'especialistas.nome as nome_especialista',
            'pacientes.nome as nome_paciente', 'clinicas.nome as nome_clinica'
         )
         ->orderBy('horario_agendado', 'asc')
         ->paginate(10);

      return view('userClinica/listConsulta', [
         'lista' => $lista,
         'especialistas' => $especialistas,
         'nomepaciente' => $filter,
         'clinica' => $clinica,
         'status' => "todos",
         'especialistaSelecionado_id' => "todos",
         'msg' => $msg,
         'inicio_data' => $inicioDoDia->format('Y-m-d'),
         'final_data' => $fimDoDia->format('Y-m-d')
      ]);
   }

   function listConsultaporClinicaPesquisar(Request $request, $msg = null)
   {     
    //  dd($request);
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }

      //todoas os especialistas que a clinica eh vinculado
      $especialistas = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialistaclinicas.especialista_id');

      if (auth()->user()->tipo_user == "C") {
         $especialistas = $especialistas->where('clinica_id', $clinica->id);
      }

      $especialistas = $especialistas->orderBy('especialistas.nome', 'asc')
         ->select('especialistas.id', 'especialistas.nome')
         ->get();


      $inicioDoDiaFiltro = Carbon::parse($request->inicio_data)->startOfDay();
      $fimDoDiaFiltro = Carbon::parse($request->final_data)->endOfDay();

      // dd($inicioDoDiaFiltro,$fimDoDiaFiltro);
      if ($request->status == "todos") {
         $statusConsulta = "%%";
      } else {
         $statusConsulta = $request->status;
      }

      $lista = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')
         ->join('pacientes', 'pacientes.id', '=', 'consultas.paciente_id')
         ->join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')
         ->where('status', 'like', $statusConsulta)
         ->where('pacientes.nome', 'like', '%' . $request->nomepaciente . "%");

      if ($request->especialista_id != "todos") {
         $lista = $lista->where('especialista_id', $request->especialista_id);
      }

      if (auth()->user()->tipo_user == "C") {
         $lista = $lista->where('clinica_id', '=', $clinica->id);
      }
      
      $lista = $lista->whereBetween('horario_agendado', [$inicioDoDiaFiltro, $fimDoDiaFiltro])
         ->select(
            'consultas.id', 'status', 'horario_agendado', 'especialistas.nome as nome_especialista', 
            'pacientes.nome as nome_paciente', 'clinicas.nome as nome_clinica'
         )
         ->orderBy('horario_agendado', 'asc')
         ->paginate(10);

      return view('userClinica/listConsulta', [
         'lista' => $lista,
         'especialistas' => $especialistas,
         'especialistaSelecionado_id' => $request->especialista_id,
         'status' => $request->status,
         'filtro' => $filter,
         'inicio_data' => $request->inicio_data,
         'final_data' => $request->final_data,
         'nomepaciente' => $request->nomepaciente,
      ]);
   }

   //encaminhar paciente para sala do especialista
   function encaminharPaciente(Request $request)
    {  
      //salvo o local indicado
      $consulta = Consulta::find($request->consulta_id);
      $especialistaClinica =  Especialistaclinica::
      where('especialista_id',$consulta->especialista_id)->
      where('clinica_id',$consulta->clinica_id)->first();
      $especialistaClinica->local_consulta = $request->local_consulta;
      $especialistaClinica->save();

      //salvo o novo status da consulta
      $consulta->status = "Sala de espera";
      $consulta->save();
    
      $ordemFila = Fila::    
      where('especialista_id',$consulta->especialista_id)-> 
      where('clinica_id',$consulta->clinica_id)->
      where('tipo',$request->tipo_fila)->max('ordem');

      //pegando o ultimo na fila
      if(!isset($ordemFila)){
         $ordemFila = 1;
      }else{
         $ordemFila = $ordemFila+1;
      }

      $dataAtual = Carbon::now('America/Fortaleza');

      //aqui está salvando na Fila
      $entidade = Fila::create([
         'tipo' => $request->tipo_fila,
         'ordem' => $ordemFila,
         'hora_entrou' => $dataAtual->format('Y-m-d H:i:s'),
         'clinica_id' => $consulta->clinica_id,
         'especialista_id' => $consulta->especialista_id,
         'paciente_id' => $consulta->paciente_id,
         'consulta_id'=> $consulta->id
      ]);



      $msg = ['valor' => trans("Encaminhamento realizado com sucesso!"), 'tipo' => 'success'];
      $request->merge([
         'nomepaciente' => $request->nomepacienteM,
         'cpf' => $request->cpfM,
         'inicio_data' => $request->inicio_dataM,
         'final_data' => $request->final_dataM,
         'especialista_id' =>  $request->especialista_idM
       ]);   
        return $this->listConsultaAgendadaUserClinicaPesquisar($request,$msg);
    }

     //o usuario clinica efetua o pagamento da consulta
   function efetuarPagamentoUserClinica(Request $request)
   {  
     
     $consulta = Consulta::find($request->consulta_id);    
     //salva a forma de pagamento 
     $consulta->forma_pagamento = $request->forma_pagamento;
     $consulta->isPago = true;
     $consulta->save();
     $msg = ['valor' => trans("Pagamento realizado com sucesso!"), 'tipo' => 'success'];

     $request->merge([
      'nomepaciente' => $request->nomepacienteM,
      'cpf' => $request->cpfM,
      'inicio_data' => $request->inicio_dataM,
      'final_data' => $request->final_dataM,
      'especialista_id' =>  $request->especialista_idM
    ]);   

     
     return $this->listConsultaAgendadaUserClinicaPesquisar($request,$msg);
   }
   
   public function cancelarConsultaSemTaxa(Request $request)
   {
      //ver a questao financeira
      $consulta = Consulta::find($request->consulta_id);

      date_default_timezone_set('America/Sao_Paulo');
      $dataConsulta = Carbon::parse($consulta->horario_agendado);
      $dataAtual = Carbon::now();
      try {
         // Verifica se a data da consulta é maior que a data atual para poder duplicar
         if ($dataConsulta->gt($dataAtual)) {
            $consultaNova = $consulta->replicate();
            $consultaNova->status = "Disponível";
            $consultaNova->isPago = false;
            $consultaNova->forma_pagamento = null;
            $consultaNova->paciente_id = null;
            $consultaNova->save();
         }
         
         $consulta->status = "Cancelada";
         $consulta->motivocancelamento = $request->motivo_cancelamento;
         $consulta->id_usuario_cancelou = Auth::user()->id;
         $consulta->save();

         session()->flash('msg', ['valor' => trans("Consulta cancelada com sucesso!"), 'tipo' => 'success']);
      } catch (QueryException $e) {
         session()->flash('msg', ['valor' => trans("Houve um erro ao cancelar a consulta, tente novamente."), 'tipo' => 'danger']);

         return false;
      }

      return true;
   }

   public function callbackCancelarConsultaComTaxa(Request $request)
   {      
      $response = Helper::getCheckout($request->checkout_id);
      
      $consultaId = session()->get("consulta_id_$request->checkout_id");
      $motivo_cancelamento = session()->get("motivo_cancelamento_$request->checkout_id");
      
      session()->forget("consulta_id_$request->checkout_id");
      session()->forget("motivo_cancelamento_$request->checkout_id");
      //ver a questao financeira
      $consulta = Consulta::find($consultaId);      
      $pagamentoController = new PagamentoController();

      if ($response->status == 'FAILED') {
         $pagamentoController->update($response->transactions[0]->transaction_code, 'Negado');
         session()->flash('msg', ['valor' => trans("Não foi possível realizar a cobrança da taxa e cancelar a consulta, tente novamente."), 'tipo' => 'danger']);

         return redirect()->route('paciente.minhasconsultas');
      } elseif ($response->status == 'PAID') {
         date_default_timezone_set('America/Sao_Paulo');
         $dataConsulta = Carbon::parse($consulta->horario_agendado);
         $dataAtual = Carbon::now();
         try {
            // Verifica se a data da consulta é maior que a data atual para poder duplicar
            if ($dataConsulta->gt($dataAtual)) {
               $consultaNova = $consulta->replicate();
               $consultaNova->status = "Disponível";
               $consultaNova->isPago = false;
               $consultaNova->forma_pagamento = null;
               $consultaNova->paciente_id = null;
               $consultaNova->save();
            }
            
            $consulta->status = "Cancelada";
            $consulta->motivocancelamento = $motivo_cancelamento;
            $consulta->id_usuario_cancelou = Auth::user()->id;
            $consulta->save();
            
            $pagamentoController->update($response->transactions[0]->transaction_code, 'Aprovado');
            session()->flash('msg', ['valor' => trans("Consulta cancelada com sucesso!"), 'tipo' => 'success']);
         } catch (QueryException $e) {
            session()->flash('msg', ['valor' => trans("Houve um erro ao cancelar a consulta, tente novamente."), 'tipo' => 'danger']);
         }

         return redirect()->route('paciente.minhasconsultas');
      }
   }
}
