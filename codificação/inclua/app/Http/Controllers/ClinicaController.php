<?php
namespace App\Http\Controllers;

use App\Models\Clinica;
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
      $lista = Clinica::where('nome', 'like', "%" . "%")->orderBy('id', 'desc')->paginate(10);
      return view('clinica/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }
   function new()
   {
      return view('clinica/form', ['entidade' => new Clinica()]);
   }
   function search(Request $request)
   {
      $filter = $request->query('filtro');
      $lista = Clinica::where('nome', 'like', "%" . $request->filtro . "%")->orderBy('id', 'desc')->paginate(10);
      return view('clinica/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filter', $filter);
   }
   function save(Request $request)
   {
      if ($request->id) {
         $ent = Clinica::find($request->id);
         $ent->nome = $request->nome;
         $ent->razaosocial = $request->razaosocial;
         $ent->cnpj = $request->cnpj;
         $ent->cep = $request->cep;
         $ent->rua = $request->rua;
         $ent->cidade = $request->cidade;
         $ent->bairro = $request->bairro;
         $ent->numero = $request->numero;
         $ent->telefone = $request->telefone;
         $ent->longitude = $request->longitude;
         $ent->latitude = $request->latitude;
         $ent->logotipo = $request->logotipo;
         $ent->numero_atendimento_social_mensal = $request->numero_atendimento_social_mensal;
         $ent->usuario_id = $request->usuario_id;
         $ent->save();
      } else {
         $entidade = Clinica::create([
            'nome' => $request->nome,
            'razaosocial' => $request->razaosocial,
            'cnpj' => $request->cnpj,
            'cep' => $request->cep,
            'rua' => $request->rua,
            'cidade' => $request->cidade,
            'bairro' => $request->bairro,
            'numero' => $request->numero,
            'telefone' => $request->telefone,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'logotipo' => $request->logotipo,
            'numero_atendimento_social_mensal' => $request->numero_atendimento_social_mensal,
            'usuario_id' => $request->usuario_id
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      return $this->list($msg);
   }
   function delete($id)
   {
      try {
         $entidade = Clinica::find($id);
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
      $entidade = Clinica::find($id);
      return view('clinica/form', ['entidade' => $entidade]);
   }
} ?>