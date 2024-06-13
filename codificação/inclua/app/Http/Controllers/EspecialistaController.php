<?php
namespace App\Http\Controllers;

use App\Models\Especialista;
use App\Models\Especialidade;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EspecialistaController extends Controller
{
   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
     
      $lista = Especialista::join('especialidades', 'especialidades.id', '=', 'especialidade_id')->          
      orderBy('especialistas.nome', 'asc')->
      select('especialistas.id','especialistas.nome', 'especialistas.telefone','especialidades.descricao as especialidade')->
      paginate(8);

      return view('especialista/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function new()
   {
      return view('especialista/form', ['entidade' => new Especialista(), 'especialidades' => Especialidade::all(), 'usuario' => new User()]);
   }
   function search(Request $request)
   {
      $filter = $request->query('filtro');
      $lista = Especialista::where('nome', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(8);
      return view('especialista/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filter', $filter);
   }
   function save(Request $request)
   {
      $input = $request->validate([
         'email' => 'required|unique:users,email,' . $request->usuario_id,
         'password' => 'confirmed',
      ]);
      if ($request->id) {
         $ent = Especialista::find($request->id);
         $ent->nome = $request->nome;
         $ent->telefone = $request->telefone;
         $ent->especialidade_id = $request->especialidade_id;
         $ent->usuario_id = $request->usuario_id;
         $ent->save();

         $usuario = User::find(intval($request->usuario_id));
         $usuario->nome_completo = $request->nome;
         $usuario->telefone = $request->telefone;
         $usuario->email = $request->email;
         if(isset($request->password)){
             $usuario->password = bcrypt($request->password);
         }
         $usuario->save();
      } else {
         $usuario = User::create([
            'nome_completo' => $request->nome,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'telefone' => $request->telefone,
            'tipo_user' => 'E' //E eh especialista
         ]);
        
       

         $entidade = Especialista::create([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'especialidade_id' => $request->especialidade_id,
            'usuario_id' => $request->usuario_id
         ]);

        
          //salvando o id do usuario no especialista
          $entidade->usuario_id = $usuario->id;
          $entidade->save();
        
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
      $usuario = User::find($entidade->usuario_id);
      return view('especialista/form', ['entidade' => $entidade, 'especialidades' => Especialidade::all(),'usuario' => $usuario]);
   }
} ?>