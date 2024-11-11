<?php
namespace App\Http\Controllers;

use App\Models\Especialistaclinica;
use App\Models\Especialista;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clinica;
use App\Models\Consulta;
use Carbon\Carbon;     

class EspecialistaclinicaController extends Controller
{
   function list($clinica_id = null, $msg = null)
   {
      if (Auth::user()->tipo_user == "C") {
         $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      } else {
         $clinica = Clinica::find($clinica_id);
      }

      $clinica_id = $clinica->id;
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }

      $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialista_id')
         ->join('especialidades', 'especialidades.id', '=', 'especialistas.especialidade_id')
         ->where('clinica_id', '=', $clinica_id)
         ->orderBy('especialistas.nome', 'asc')
         ->select(
            'especialistaclinicas.especialista_id as id', 'especialistas.nome',
            'especialidades.descricao as especialidade','is_vinculado as isVinculado'
         )
         ->paginate(8);
      
      return view('userClinica/cadVinculoEspecialista/list', ['lista' => $lista, 'filtro' => $filter, 'clinica' => $clinica, 'msg' => $msg]);
   }
   function new()
   {
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      return view('userClinica/cadVinculoEspecialista/form', ['entidade' => new Especialistaclinica(), 'clinica' => $clinica, 'especialistas'=>Especialista::all()]);
   }
   function search(Request $request, $clinica_id)
   {
      $clinica = Clinica::find($clinica_id);
      $filter = $request->query('filtro');
      $lista = Especialistaclinica::where('nome', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(8);
      return view('userClinica/cadVinculoEspecialista/list', ['lista' => $lista, 'filtro' => $request->filtro, 'clinica' => $clinica])->with('filter', $filter);
   }
   function save(Request $request)
   {
      $clinica_id = $request->clinica_id;
      if ($request->id) {
         $ent = Especialistaclinica::find($request->id);
         $ent->especialista_id = $request->especialista_id;
         $ent->clinica_id = $clinica_id;
         $ent->save();
      } else {
         $entidade = Especialistaclinica::create([
            'especialista_id' => $request->especialista_id,
            'clinica_id' => $clinica_id,
            'is_vinculado' => true       

         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }

   //funcao para cancelar vículo - user Clinica
   function delete($id)
   {
      $especialista = Especialista::find($id);      
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();      
      $relacaoEspecialistaClinica = Especialistaclinica::
      where('clinica_id', $clinica->id)->
      where('especialista_id', $especialista->id)->first();
     
      try {
         if ($relacaoEspecialistaClinica) {
            $relacaoEspecialistaClinica->is_vinculado = !$relacaoEspecialistaClinica->is_vinculado; 
            $relacaoEspecialistaClinica->save();
            $msg = ['valor' => trans("Vínculo alterado com sucesso!"), 'tipo' => 'success'];
     }
      } catch (QueryException $exp) {
         $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
      }
      return $this->list($msg);
   }

 //funcao para cancelar vículo - user Especialista
 function cancelarVinculo($clinica_id, $especialista_id)
 {  
   $clinica = Clinica::find($clinica_id);
   if (Auth::user()->tipo_user == "E") {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
   } else {
      $especialista = Especialista::find($especialista_id);
   }

   $relacaoEspecialistaClinica = Especialistaclinica::
    where('clinica_id', $clinica->id)->
    where('especialista_id', $especialista->id)->first();
   
   
    try {
       if ($relacaoEspecialistaClinica) {
          $relacaoEspecialistaClinica->is_vinculado = !$relacaoEspecialistaClinica->is_vinculado; 
          $relacaoEspecialistaClinica->save();
          $msg = ['valor' => trans("Vínculo alterado com sucesso!"), 'tipo' => 'success'];
   }
    } catch (QueryException $exp) {
       $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
    }
    return $this->clinicasdoespecilista($especialista->id,$msg);
 }


   function edit($id)
   {
      $entidade = Especialistaclinica::find($id);
      $clinica_id = $entidade->clinica_id;
      $clinica = Clinica::find($clinica_id);
      return view('userClinica/cadVinculoEspecialista/form', ['entidade' => $entidade, 'clinica' => $clinica]);
   }

   function clinicasdoespecilista($especialista_id = null, $msg = null)
   {
      if (Auth::user()->tipo_user == "E") {
         $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      } else {
         $especialista = Especialista::find($especialista_id);
      }

      //todoas as clinicas que o especialista eh vinculado
      $lista =  Especialistaclinica:: join('clinicas', 'clinicas.id','=','especialistaclinicas.clinica_id')
         ->where('especialista_id',$especialista->id)
         ->orderBy('clinicas.nome', 'asc')
         ->select('clinicas.id','clinicas.nome','is_vinculado as isVinculado')
         ->paginate(8);

      return view('userEspecialista/listClinicasVinculadas', ['lista' => $lista,
        'especialista' => $especialista,
        'msg' => $msg]);
   }

   function agendaEspecialista($especialista_id, $clinica_id = null)
   {
      //retornar todos a agenda(consultas) do especialista vinculados a clinica a partir da data de hoje
      //retorna todas as consultas, exceto as finalizadas e canceladas
      $especialista = Especialista::find($especialista_id);
      if (Auth::user()->tipo_user == "C") {
         $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      } else {
         $clinica = Clinica::find($clinica_id);
      }
       
      $inicioDoDia = Carbon::today()->startOfDay();
      $statusConsulta = "Disponível";

      $lista = Consulta::where('especialista_id', '=', $especialista_id)
         ->where('clinica_id', '=', $clinica->id)
         ->where('status', '=', $statusConsulta)
         ->select('consultas.id', 'horario_agendado')
         ->orderBy('horario_agendado', 'asc')
         ->get();
      
      // dd($especialista,$lista);
      return view('userClinica/cadVinculoEspecialista/agendaEspecialista',['lista' => $lista, 'especialista' => $especialista, 'clinica' => $clinica]);
   }
} ?>