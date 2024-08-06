<?php
namespace App\Http\Controllers;

use App\Models\Avaliacaoespecilista;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Consulta;

class AvaliacaoespecilistaController extends Controller
{
   function new($consulta_id)
   {
      $consulta = Consulta::find($consulta_id);
      return view('avaliacaoespecilista/form', ['entidade' => new Avaliacaoespecilista(), 'consulta' => $consulta]);
   }

   function save(Request $request)
   {
      if ($request->id) {
         $ent = Avaliacaoespecilista::find($request->id);
         $ent->consulta_id = $request->consulta_id;
         $ent->qtdestrela = $request->qtdestrela;
         $ent->messagem = $request->messagem;
         $ent->save();
      } else {
         $entidade = Avaliacaoespecilista::create([
            'consulta_id' => $request->consulta_id,
            'qtdestrela' => $request->qtdestrela,
            'messagem' => $request->messagem,
         ]);
      }
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];

      $pacienteController = new PacienteController();
      return $pacienteController->historicoconsultas($msg);    
   }
  
  

} ?>