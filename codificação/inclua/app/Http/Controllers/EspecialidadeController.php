<?php
namespace App\Http\Controllers;

use App\Models\Especialidade;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EspecialidadeController extends Controller
{
   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Especialidade::where('descricao', 'like', "%" . "%")->orderBy('id', 'desc')->paginate(8);
      return view('especialidade/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function new()
   {
      return view('especialidade/form', ['entidade' => new Especialidade()]);
   }
   function search(Request $request)
   {
      $filter = $request->query('filtro');
      $lista = Especialidade::where('descricao', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(8);
      return view('especialidade/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filter', $filter);
   }
   function save(Request $request)
   {
      if ($request->id) {
         $ent = Especialidade::find($request->id);
         $ent->descricao = $request->descricao;
         $ent->valorpadrao = $request->valorpadrao;
         $ent->save();
      } else {
         $entidade = Especialidade::create([
            'descricao' => $request->descricao,
            'valorpadrao' => $request->valorpadrao
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }
   function delete($id)
   {
      try {
         $entidade = Especialidade::find($id);
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
      $entidade = Especialidade::find($id);
      return view('especialidade/form', ['entidade' => $entidade]);
   }
} ?>