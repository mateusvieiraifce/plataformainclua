<?php
namespace App\Http\Controllers;
use App\Models\Medicamento;
use App\Models\TipoMedicamento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicamentoController extends Controller
{
   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Medicamento::where('nome_comercial', 'like', "%" . "%")->orderBy('id', 'desc')->paginate(8);
      return view('medicamento/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function create()
   {

      return view('medicamento/form', ['entidade' => new Medicamento(), 'tipo_medicamentos' => TipoMedicamento::all()]);
   }
   function search(Request $request)
   {
      $filter = $request->query('filtro');
      $lista = Medicamento::where('nome_comercial', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(8);
      return view('medicamento/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filter', $filter);
   }
   function store(Request $request)
   {
      if ($request->id) {
         $ent = Medicamento::find($request->id);
         $ent->nome_comercial = $request->nome_comercial;
         $ent->nome_generico = $request->nome_generico;
         $ent->forma = $request->forma;
         $ent->concentracao = $request->concentracao;
         $ent->via = $request->via;
         $ent->indicacao = $request->indicacao;
         $ent->posologia = $request->posologia;
         $ent->precaucao = $request->precaucao;
         $ent->advertencia = $request->advertencia;
         $ent->contraindicacao = $request->contraindicacao;
         $ent->composicao = $request->composicao;
         $ent->latoratorio_fabricante = $request->latoratorio_fabricante;
         $ent->tipo_medicamento_id = $request->tipo_medicamento_id;
         $ent->save();
      } else {
         $entidade = Medicamento::create([
            'nome_comercial' => $request->nome_comercial,
            'nome_generico' => $request->nome_generico,
            'forma' => $request->forma,
            'concentracao' => $request->concentracao,
            'via' => $request->via,
            'indicacao' => $request->indicacao,
            'posologia' => $request->posologia,
            'precaucao' => $request->precaucao,
            'advertencia' => $request->advertencia,
            'contraindicacao' => $request->contraindicacao,
            'composicao' => $request->composicao,
            'latoratorio_fabricante' => $request->latoratorio_fabricante,
            'tipo_medicamento_id' => $request->tipo_medicamento_id
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }
   function delete($id)
   {
      try {
         $entidade = Medicamento::find($id);
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
      $entidade = Medicamento::find($id);
      return view('medicamento/form', ['entidade' => $entidade,'tipo_medicamentos' => TipoMedicamento::all()]);
   }

} ?>