<?php
namespace App\Http\Controllers;
use App\Models\Fila;
use App\Models\Especialistaclinica;
use App\Models\Consulta;
use App\Models\Clinica;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilaController extends Controller
{
   function list(Request $request)
   {

      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();

      $listaTipoNormal = Fila::
         join('pacientes', 'pacientes.id', '=', 'filas.paciente_id')->
         where('especialista_id', $request->especialista_id)->
         where('clinica_id', $clinica->id)->
         where('tipo', 'Normal')->
         select('filas.id', 'hora_entrou', 'ordem', 'nome')->
         orderBy('ordem', 'asc')->get();

      $listaTipoPrioritario = Fila::
         join('pacientes', 'pacientes.id', '=', 'filas.paciente_id')->
         where('especialista_id', $request->especialista_id)->
         where('clinica_id', $clinica->id)->
         where('tipo', 'Prioritario')->
         select('filas.id', 'hora_entrou', 'ordem', 'nome')->
         orderBy('ordem', 'asc')->get();

      return view('userClinica/fila/listaFila', ['listaTipoNormal' => $listaTipoNormal, 'listaTipoPrioritario' => $listaTipoPrioritario]);
   }

   function listEspecialistaDaClinica($msg = null)
   {
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();

      //retornar todos os especialistas vinculados a clinica
      $lista = Especialistaclinica::join(
         'especialistas',
         'especialistas.id',
         '=',
         'especialistaclinicas.especialista_id'
      )->
         where('clinica_id', $clinica->id)->
         orderBy('especialistas.nome', 'asc')->
         select('especialistas.id', 'especialistas.nome')->get();
      return view('userClinica/fila/listaEspecialista', ['lista' => $lista, 'msg' => $msg]);
   }

   function salvarOrdemFilas(Request $request)
   {

      // dd($request);
      $cont = 1;
      if (isset($request->listaNormal)) {
         foreach ($request->listaNormal as $id) {
            $ent = Fila::find($id);
            $ent->ordem = $cont;
            $ent->tipo = 'Normal';
            $cont++;
            $ent->save();
         }
      }

      $cont = 1;
      if (isset($request->listaPrioritario)) {
         foreach ($request->listaPrioritario as $id) {
            $ent = Fila::find($id);
            $ent->ordem = $cont;
            $ent->tipo = 'Prioritário';
            $cont++;
            $ent->save();
         }
      }
      $msg = ['valor' => trans(key: "Filas ordenadas com sucesso!"), 'tipo' => 'success'];
      return $this->listEspecialistaDaClinica($msg);

   }

   function create()
   {
      return view('fila/form', ['entidade' => new Fila(), 'consultas' => Consulta::all()]);
   }

   function store(Request $request)
   {
      if ($request->id) {
         $ent = Fila::find($request->id);
         $ent->tipo = $request->tipo;
         $ent->ordem = $request->ordem;
         $ent->hora_entrou = $request->hora_entrou;
         $ent->consulta_id = $request->consulta_id;
         $ent->save();
      } else {
         $entidade = Fila::create([
            'tipo' => $request->tipo,
            'ordem' => $request->ordem,
            'hora_entrou' => $request->hora_entrou,
            'consulta_id' => $request->consulta_id
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }

   function edit($id)
   {
      $entidade = Fila::find($id);
      return view('fila/form', ['entidade' => $entidade]);
   }

} ?>