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
       dd($request->especialista_id);

       //parei aqui
       //fazer a insercao no hora que é definido o local da consulta
      $listaTipoNormal = Fila::where('tipo','normal')->
      orderBy('id', 'desc')->get();

      $listaTipoPrioritario = Fila::where('tipo','prioritario')->
      orderBy('id', 'desc')->get();

      return view('userClinica/fila/listaFila', ['listaTipoNormal' => $listaTipoNormal,'listaTipoPrioritario' => $listaTipoPrioritario]);
   }

   function listEspecialistaDaClinica($msg = null)
   {     
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      
      //retornar todos os especialistas vinculados a clinica
      $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=',
       'especialistaclinicas.especialista_id')->
      where('clinica_id', $clinica->id)->
      orderBy('especialistas.nome', 'asc')->
      select('especialistas.id', 'especialistas.nome')->get();
      return view('userClinica/fila/listaEspecialista', ['lista' => $lista, 'msg' => $msg]);
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
   {      $entidade = Fila::find($id);
      return view('fila/form', ['entidade' => $entidade]);
   }

} ?>