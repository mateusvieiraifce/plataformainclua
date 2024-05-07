<?php
namespace App\Http\Controllers;

use App\Models\Formapagamento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormapagamentoController extends Controller
{
   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Formapagamento::where('descricao', 'like', "%" . "%")->orderBy('id', 'desc')->paginate(10);
      return view('formapagamento/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function new()
   {
      return view('formapagamento/form', ['entidade' => new Formapagamento()]);
   }
   function search(Request $request)
   {
      $filter = $request->query('filtro');
      $lista = Formapagamento::where('descricao', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(10);
      return view('formapagamento/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filter', $filter);
   }
   function save(Request $request)
   {
      if ($request->id) {
         $ent = Formapagamento::find($request->id);
         $ent->descricao = $request->descricao;
         $ent->save();
      } else {
         $entidade = Formapagamento::create([
            'descricao' => $request->descricao
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }
   function delete($id)
   {
      try {
         $entidade = Formapagamento::find($id);
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
      $entidade = Formapagamento::find($id);
      return view('formapagamento/form', ['entidade' => $entidade]);
   }
} ?>