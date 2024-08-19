<?php
namespace App\Http\Controllers;
use App\Models\Tipoexame;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoexameController extends Controller
{
   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Tipoexame::where('descricao', 'like', "%" . "%")->orderBy('id', 'desc')->paginate(10);
      return view('tipoexame/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function new()
   {
      return view('tipoexame/form', ['entidade' => new Tipoexame()]);
   }
   function search(Request $request)
   {
      $filter = $request->query('filtro');
      $lista = Tipoexame::where('descricao', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(10);
      return view('tipoexame/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filter', $filter);
   }
   function save(Request $request)
   {
      if ($request->id) {
         $ent = Tipoexame::find($request->id);
         $ent->descricao = $request->descricao;
         $ent->save();
      } else {
         $entidade = Tipoexame::create([
            'descricao' => $request->descricao
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }
   function delete($id)
   {
      try {
         $entidade = Tipoexame::find($id);
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
      $entidade = Tipoexame::find($id);
      return view('tipoexame/form', ['entidade' => $entidade]);
   }
} ?>