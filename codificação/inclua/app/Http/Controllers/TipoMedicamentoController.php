<?php
namespace App\Http\Controllers;
use App\Models\TipoMedicamento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoMedicamentoController extends Controller
{
   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = TipoMedicamento::where('descricao', 'like', "%" . "%")->orderBy('id', 'desc')->paginate(8);
      return view('tipomedicamento/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function create()
   {
      return view('tipomedicamento/form', ['entidade' => new TipoMedicamento()]);
   }
   function search(Request $request)
   {
      $filter = $request->query('filtro');
      $lista = TipoMedicamento::where('descricao', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(8);
      return view('tipomedicamento/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filter', $filter);
   }
   function store(Request $request)
   {
      if ($request->id) {
         $ent = TipoMedicamento::find($request->id);
         $ent->descricao = $request->descricao;
         $ent->qtdFolha= $request-> qtdFolha;
         $ent->save();
      } else {
         $entidade = TipoMedicamento::create([
            'descricao' => $request->descricao,
            'qtdFolha'=> $request->qtdFolha
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }
   function delete($id)
   {
      try {
         $entidade = TipoMedicamento::find($id);
         if ($entidade) {
            $entidade->delete();
            $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
         }
      } catch (QueryException $exp) {
         $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
      }
      return $this->list($msg);
   }
   function edit($id)
   {
      $entidade = TipoMedicamento::find($id);
      return view('tipomedicamento/form', ['entidade' => $entidade]);
   }

} ?>