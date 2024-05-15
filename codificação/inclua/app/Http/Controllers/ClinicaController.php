<?php
namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Especialidadeclinica;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClinicaController extends Controller
{
   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Clinica::join('users', 'users.id', '=', 'usuario_id')->
         where('nome', 'like', "%" . "%")->
         orderBy('nome', 'asc')->
         select('clinicas.id', 'users.nome_completo as nome_responsavel', 'nome', 'cnpj', 'clinicas.telefone')->
         paginate(10);
      return view('clinica/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function new()
   {
      return view('clinica/form', ['entidade' => new Clinica(), 'usuario' => new User()]);
   }
   function search(Request $request)
   {
      $filter = $request->filtro;
      $lista = Clinica::join('users', 'users.id', '=', 'usuario_id')->
         where('nome', 'like', "%" . $filter . "%")->
         orderBy('nome', 'asc')->
         select('clinicas.id', 'users.name as nome_responsavel', 'nome', 'cnpj', 'clinicas.telefone')->
         paginate(10);
      return view('clinica/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filtro', $filter);
   }
   function save(Request $request)
   {
        $imageName = "";       
        //salvando a logo na clinica
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
         // Recupera a extensão do arquivo       
         $requestImage = $request->image;
         $extension = $requestImage->extension();
         $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
         $request->image->move(public_path('images/logosclinicas'), $imageName);
      }

      if ($request->id) {
         $input = $request->validate([
            'email' => 'required|unique:users,email,' . $request->usuario_id,
         ]);
         $ent = Clinica::find($request->id);
         $ent->nome = $request->nome;
         $ent->razaosocial = $request->razaosocial;
         $ent->cnpj = $request->cnpj;
         $ent->estado = $request->estado;
         $ent->cep = $request->cep;
         $ent->rua = $request->rua;
         $ent->cidade = $request->cidade;
         $ent->bairro = $request->bairro;
         $ent->numero = $request->numero;
         $ent->telefone = $request->telefone;
         $ent->longitude = $request->longitude;
         $ent->latitude = $request->latitude;
         $ent->numero_atendimento_social_mensal = $request->numero_atendimento_social_mensal;
         $ent->usuario_id = $request->usuario_id;
          //salvando o nome da imagem
         $ent->logotipo = $imageName;
         $ent->save();

         $entUsuario = User::find($request->usuario_id);
         $entUsuario->nome_completo = $request->nome_login;
         $entUsuario->email = $request->email;
         if(isset($request->password)){
            $entUsuario->password = bcrypt($request->password);
        }
         $entUsuario->telefone = $request->telefone;
         $entUsuario->save();

      } else {
         $input = $request->validate([
            'email' => 'required|unique:users,email,' . $request->id,
         ]);

         $usuario = User::create([
            'nome_completo' => $request->nome_login,
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'telefone' => $request->telefone,
            'tipo_user' => 'C', //c eh clinica
         ]);

         $entidade = Clinica::create([
            'nome' => $request->nome,
            'razaosocial' => $request->razaosocial,
            'cnpj' => $request->cnpj,
            'cep' => $request->cep,
            'estado' => $request->estado,
            'rua' => $request->rua,
            'cidade' => $request->cidade,
            'bairro' => $request->bairro,
            'numero' => $request->numero,
            'telefone' => $request->telefone,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'numero_atendimento_social_mensal' => $request->numero_atendimento_social_mensal,
            'usuario_id' => $request->usuario_id
         ]);
        
         //salvando o id do usuario na clinica
         $entidade->usuario_id = $usuario->id;
         //salvando o nome da imagem
         $entidade->logotipo = $imageName;
         $entidade->save();
      }




      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }
   function delete($id)
   {
      try {
         $entidade = Clinica::find($id);
         if ($entidade) {
            //deletando das as especialidades da clinica
            $lista = Especialidadeclinica::where('clinica_id', '=', $id)->get();
            foreach ($lista as $ent) {
               $ent->delete();
            }
            $entidadeUsuario = User::find($entidade->usuario_id);
            $entidade->delete();
            //deletando o usuario da clinica
            $entidadeUsuario->delete();
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
      $entidade = Clinica::find($id);

      $usuario = User::find($entidade->usuario_id);
      return view('clinica/form', ['entidade' => $entidade, 'usuario' => $usuario]);
   }



} ?>