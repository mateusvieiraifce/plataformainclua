<?php
namespace App\Http\Controllers;

use App\Models\Exame;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tipoexame;

class ExameController extends Controller
{
   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Exame::where('nome', 'like', "%" . "%")->orderBy('nome', 'asc')->paginate(10);
      return view('exame/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function new()
   {
      $tipoexames = Tipoexame::all();
      return view('exame/form', ['entidade' => new Exame(), 'tipoexames' => $tipoexames]);
   }
   function search(Request $request)
   {
      $filter = $request->query('filtro');
      $lista = Exame::where('nome', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(10);
      return view('exame/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filter', $filter);
   }
   function save(Request $request)
   {
      if ($request->id) {
         $ent = Exame::find($request->id);
         $ent->nome = $request->nome;
         $ent->descricao = $request->descricao;
         $ent->tipoexame_id = $request->tipoexame_id;
         $ent->save();
      } else {
         $entidade = Exame::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'tipoexame_id' => $request->tipoexame_id
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }
   function delete($id)
   {
      try {
         $entidade = Exame::find($id);
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
      $tipoexames = Tipoexame::all();
      $entidade = Exame::find($id);
      return view('exame/form', ['entidade' => $entidade ,'tipoexames' => $tipoexames]);
   }
} ?>