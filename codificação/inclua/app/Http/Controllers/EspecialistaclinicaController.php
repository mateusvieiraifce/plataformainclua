<?php
namespace App\Http\Controllers;

use App\Models\Especialistaclinica;
use App\Models\Especialista;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clinica;

class EspecialistaclinicaController extends Controller
{
   function list($clinica_id, $msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }

      $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialista_id')->  
      join('especialidades', 'especialidades.id', '=', 'especialistas.especialidade_id')->  
      where('clinica_id', '=', $clinica_id)->
      orderBy('especialistas.nome', 'asc')->
      select('especialistaclinicas.id','especialistas.nome', 'especialistas.telefone','especialidades.descricao as especialidade')->
      paginate(10);
      $clinica = clinica::find($clinica_id);
      return view('especialistaclinica/list', ['lista' => $lista, 'filtro' => $filter, 'clinica' => $clinica, 'msg' => $msg]);
   }
   function new($clinica_id)
   {
      $clinica = Clinica::find($clinica_id);
      return view('especialistaclinica/form', ['entidade' => new Especialistaclinica(), 'clinica' => $clinica, 'especialistas'=>Especialista::all()]);
   }
   function search(Request $request, $clinica_id)
   {
      $clinica = Clinica::find($clinica_id);
      $filter = $request->query('filtro');
      $lista = Especialistaclinica::where('nome', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(10);
      return view('especialistaclinica/list', ['lista' => $lista, 'filtro' => $request->filtro, 'clinica' => $clinica])->with('filter', $filter);
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
            'clinica_id' => $clinica_id
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($clinica_id, $msg);
   }
   function delete($id)
   {
      $clinica_id = 0;
      try {
         $entidade = Especialistaclinica::find($id);
         if ($entidade) {
            $clinica_id = $entidade->clinica_id;
            $entidade->delete();
            $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
         } else {
            $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
         }
      } catch (QueryException $exp) {
         $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
      }
      return $this->list($clinica_id, $msg);
   }
   function edit($id)
   {
      $entidade = Especialistaclinica::find($id);
      $clinica_id = $entidade->clinica_id;
      $clinica = Clinica::find($clinica_id);
      return view('especialistaclinica/form', ['entidade' => $entidade, 'clinica' => $clinica]);
   }

} ?>