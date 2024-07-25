<?php
namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Clinica;
use App\Models\Especialistaclinica;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Especialista;
use Carbon\Carbon;

class ConsultaController extends Controller
{
   //list de consultas disponiveis
   function list($msg = null)
   {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      $especialista_id = $especialista->id;
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Consulta::
      join('clinicas', 'clinicas.id','=','consultas.clinica_id')->
      where('especialista_id', '=', $especialista_id)->
      select('consultas.id','status','horario_agendado','clinicas.nome as nome_clinica')->
      orderBy('horario_agendado', 'asc')->paginate(8);
      return view('userEspecialista/listTodasConsultas', ['lista' => $lista, 'filtro' => $filter, 'especialista' => $especialista, 'msg' => $msg]);
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
      $especialista_id = 0;
      try {
         $entidade = Consulta::find($id);
         if ($entidade) {
            $especialista_id = $entidade->especialista_id;
            $entidade->delete();
            $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
         } else {
            $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
         }
      } catch (QueryException $exp) {
         $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
      }
      return $this->listconsultaporespecialista($msg);
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
      $clinicas =  Especialistaclinica::
      join('clinicas', 'clinicas.id','=','especialistaclinicas.clinica_id')->
      where('especialista_id',$especialista->id)->
      orderBy('clinicas.nome', 'asc')->
      select('clinicas.id','clinicas.nome')->
      get();
      return view('userEspecialista/agenda', ['entidade' => new Consulta(), 'especialista' => $especialista, 'clinicas' => $clinicas]);
   }

   function saveVariasConsultas(Request $request)
   {
      $especialista_id = $request->especialista_id;


      $startDate = Carbon::parse($request->data_inicio);
      $endDate = Carbon::parse($request->data_fim);
      
    //  dd($request);
      // Loop através do intervalo de datas
      $qtdConsutasCriadas = 1; 
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
            $dataInic = $date->format('Y-m-d').' '.$hora_inicio;
            $inicio = Carbon::createFromTimeString($date->format('Y-m-d').' '.$hora_inicio);
            $termino =  Carbon::createFromTimeString($date->format('Y-m-d').' '.$hora_fim);
          //  $inicio->modify("+$request->duracao_media minutes");
             //add tempo de intervalo entre consulta
             $request->duracao_media = $request->duracao_media +  $request->intervalo_consulta;
           //  dd( $request->duracao_media);
              $termino->modify("-$request->duracao_media minutes");
            while($termino>= $inicio){
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
       
     
      $msg = ['valor' => trans("Operação realizada com sucesso! Foram criadas ". $qtdConsutasCriadas." consultas."), 'tipo' => 'success'];
      return $this->list($msg);
   }

   function listconsultaporespecialista($msg = null)
   {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      
      //todoas as clinicas que o especialista eh vinculado
      $clinicas =  Especialistaclinica::
      join('clinicas', 'clinicas.id','=','especialistaclinicas.clinica_id')->
      where('especialista_id',$especialista->id)->
      orderBy('clinicas.nome', 'asc')->
      select('clinicas.id','clinicas.nome')->
      get();

      //caso o especialista esteja vinculado a apenas uma clinicar, ja estou deixando o select selecionando a clinica
      if(sizeof($clinicas)==1){
         $clinicaselecionada_id = $clinicas[0]->id;
      }
      $statusConsulta = "Aguardando atendimento";

      $lista = Consulta::
      join('clinicas', 'clinicas.id','=','consultas.clinica_id')->
      join('pacientes', 'pacientes.id','=','consultas.paciente_id')->
      where('especialista_id', '=', $especialista->id)->
      where('status', '=', 'Aguardando atendimento')->
      select('consultas.id','status','horario_agendado','clinicas.nome as nome_clinica','pacientes.nome as nome_paciente')->
      orderBy('horario_agendado', 'asc')->paginate(8);
     
      return view('userEspecialista/listconsultaporespecialista', ['lista' => $lista, 
      'clinicas' =>$clinicas, 'clinicaselecionada_id' => $clinicaselecionada_id,  'status'=> $statusConsulta ,'filtro' => $filter,
       'especialista' => $especialista, 'msg' => $msg]);
   }


} ?>