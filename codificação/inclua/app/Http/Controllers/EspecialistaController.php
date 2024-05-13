<?php
namespace App\Http\Controllers;

use App\Models\Especialista;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EspecialistaController extends Controller
{
   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Especialista::where('nome', 'like', "%" . "%")->orderBy('id', 'desc')->paginate(10);
      return view('especialista/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function new()
   {
      return view('especialista/form', ['entidade' => new Especialista()]);
   }
   function search(Request $request)
   {
      $filter = $request->query('filtro');
      $lista = Especialista::where('nome', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(10);
      return view('especialista/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filter', $filter);
   }
   function save(Request $request)
   {
      if ($request->id) {
         $ent = Especialista::find($request->id);
         $ent->nome = $request->nome;
         $ent->telefone = $request->telefone;
         $ent->clinica_id = $request->clinica_id;
         $ent->usuario_id = $request->usuario_id;
         $ent->save();
      } else {
         $entidade = Especialista::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'clinica_id' => $request->clinica_id,
            'usuario_id' => $request->usuario_id
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }
   function delete($id)
   {
      try {
         $entidade = Especialista::find($id);
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
      $entidade = Especialista::find($id);
      return view('especialista/form', ['entidade' => $entidade]);
   }
} ?>