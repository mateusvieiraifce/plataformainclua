<?php
namespace App\Http\Controllers;

use App\Models\Especialidadeclinica;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Clinica;
use App\Models\Especialidade;

class EspecialidadeclinicaController extends Controller
{
   function listUserClinica($clinica_id = null, $msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }

      if (Auth::user()->tipo_user == "C") {
         $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      } else {
         $clinica = Clinica::find($clinica_id);
      }

      $lista = Especialidadeclinica::join('especialidades', 'especialidades.id', '=', 'especialidade_id')->
         where('clinica_id', '=', $clinica->id)->
         orderBy('especialidades.descricao', 'asc')->
         select('especialidadeclinicas.id', 'especialidades.descricao', 'valor', 'especialidadeclinicas.is_vinculado as isVinculado')->
         paginate(8);
      return view('userClinica/cadEspecialidade/list', [
         'lista' => $lista,
         'filtro' => $filter,
         'msg' => $msg, 
         'clinica' => $clinica
      ]);
   }

   function list($clinica_id, $msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }

      $clinica = Clinica::find($clinica_id);


      $lista = Especialidadeclinica::join('especialidades', 'especialidades.id', '=', 'especialidade_id')->
         where('clinica_id', '=', $clinica_id)->
         orderBy('id', 'desc')->
         select('especialidadeclinicas.id', 'especialidades.descricao', 'valor')->
         paginate(8);
      return view('especialidadeclinica/list', ['lista' => $lista, 'filtro' => $filter, 'clinica' => $clinica, 'msg' => $msg]);
   }

   function new($clinica_id)
   {
      $clinica = Clinica::find($clinica_id);
      return view('especialidadeclinica/form', ['entidade' => new Especialidadeclinica(), 'clinica' => $clinica, 'especialidades' => Especialidade::all()]);
   }

   function newUserClinica()
   {
      $clinica = Clinica::where('usuario_id', Auth::user()->id)->first();
      return view('userClinica/cadEspecialidade/form', ['entidade' => new Especialidadeclinica(), 'clinica' => $clinica, 'especialidades' => Especialidade::all()]);
   }

   function editUserClinica($id, $clinica_id = null)
   {
      $entidade = Especialidadeclinica::find($id);
      if (Auth::user()->tipo_user == "C") {
         $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      } else {
         $clinica = Clinica::find($clinica_id);
      }
      return view(
         'userClinica/cadEspecialidade/form',
         [
            'entidade' => $entidade,
            'clinica' => $clinica,
            'especialidades' => Especialidade::all()
         ]
      );
   }


   function search(Request $request, $clinica_id)
   {
      $clinica = Clinica::find($clinica_id);
      $lista = Especialidadeclinica::where('clinica_id', '=', $clinica_id)->orderBy('id', 'desc')->paginate(8);
      return view('especialidadeclinica/list', ['lista' => $lista, 'filtro' => $request->filtro, 'clinica' => $clinica])->with('filter', $filter);
   }
   function save(Request $request)
   {
      $clinica_id = $request->clinica_id;
      if ($request->id) {
         $ent = Especialidadeclinica::find($request->id);
         $ent->especialidade_id = $request->especialidade_id;
         $ent->valor = $request->valor;
         $ent->clinica_id = $clinica_id;
         $ent->save();
      } else {
         $entidade = Especialidadeclinica::create([
            'especialidade_id' => $request->especialidade_id,
            'valor' => $request->valor,
            'clinica_id' => $clinica_id,
            'is_vinculado' => true
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($clinica_id, $msg);
   }

   function saveUserClinica(Request $request)
   {
     
      $clinica_id = $request->clinica_id;
      if ($request->id) {
         $ent = Especialidadeclinica::find($request->id);
         $ent->valor = $request->valor;
         $ent->save();
      } else {
         $entidade = Especialidadeclinica::create([
            'especialidade_id' => $request->especialidade_id,
            'valor' => $request->valor,
            'clinica_id' => $clinica_id,
            'is_vinculado' => true
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->listUserClinica( $clinica_id, $msg);
   }


   function delete($id)
   {
      $clinica_id = 0;
      try {
         $entidade = Especialidadeclinica::find($id);
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

   function alterarvinculo($id)
   {
      try {
         $entidade = Especialidadeclinica::find($id);
         $clinica_id = $entidade->clinica_id;
         if ($entidade) {
            $entidade->is_vinculado = !$entidade->is_vinculado;
            $msg = ['valor' => trans("Vínculo alterado com sucesso!"), 'tipo' => 'success'];
            $entidade->save();
         }
      } catch (QueryException $exp) {
         $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
      }
      return $this->listUserClinica($clinica_id, $msg);
   }




   function edit($id)
   {
      $entidade = Especialidadeclinica::find($id);
      $clinica_id = $entidade->clinica_id;
      $clinica = Clinica::find($clinica_id);
      return view('especialidadeclinica/form', ['entidade' => $entidade, 'clinica' => $clinica, 'especialidades' => Especialidade::all()]);
   }

} ?>