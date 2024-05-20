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
   function list($especialista_id, $msg = null)
   {

      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Consulta::where('especialista_id', '=', $especialista_id)->orderBy('id', 'desc')->paginate(10);
      $especialista = especialista::find($especialista_id);
      return view('consulta/list', ['lista' => $lista, 'filtro' => $filter, 'especialista' => $especialista, 'msg' => $msg]);
   }
   function new($especialista_id)
   {
      $especialista = Especialista::find($especialista_id);
      return view('consulta/form', ['entidade' => new Consulta(), 'especialista' => $especialista]);
   }


   function search(Request $request, $especialista_id)
   {
      $especialista = Especialista::find($especialista_id);
      $filter = $request->query('filtro');
      $lista = Consulta::where('nome', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(10);
      return view('consulta/list', ['lista' => $lista, 'filtro' => $request->filtro, 'especialista' => $especialista])->with('filter', $filter);
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
      return $this->list($especialista_id, $msg);
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
      return view('consulta/agenda', ['entidade' => new Consulta(), 'especialista' => $especialista, 'clinicas' => $clinicas]);
   }

   function saveVariasConsultas(Request $request)
   {
      $especialista_id = $request->especialista_id;


      $startDate = Carbon::parse($request->data_inicio);
      $endDate = Carbon::parse($request->data_fim);
      $tercas = [];
      
    //  dd($request);
      // Loop através do intervalo de datas
      for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
          // Verifique se o dia é uma terça-feira (dayOfWeek retorna 0 a 6 para para o dia da semana)
         if (in_array($date->dayOfWeek, $request->dia)) {
            //criando as consulta de acordo com o dia
            
              $tercas[] = $date->toDateString(); // Adicione a terça-feira ao array
          }
      }

    
      dd($tercas);
     //for para criar varias consultas

      $entidade = Consulta::create([
         'status' => "Disponível",
         'horario_agendado' => $request->horario_agendado,
         'preco' => $request->preco,
         'porcetagem_repasse_clinica' => $request->porcetagem_repasse_clinica,
         'porcetagem_repasse_plataforma' => $request->porcetagem_repasse_plataforma,
         'clinica_id' => $request->clinica_id,
         'especialista_id' => $especialista_id
      ]);
     
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($especialista_id, $msg);
   }

} ?>