<?php
namespace App\Http\Controllers;
use App\Models\PedidoMedicamento;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoMedicamentoController extends Controller
{
   function salveVarios(Request $request)
   {     
      $pedidos = $request->input('medicamentos');
      foreach ($pedidos as $item) {
         $entidade = PedidoMedicamento::create([
            'consulta_id' => $request->consulta_id,
            'medicamento_id' => $item
         ]);
      }
      return redirect()->route('especialista.iniciarAtendimento', [$request->consulta_id, "prescricoes"]);
   }

   function delete($id, $consulta_id)
   {
      try {
         $entidade = PedidoMedicamento::find($id);
         if ($entidade) {
            $entidade->delete();
            $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
         }
      } catch (QueryException $exp) {
         $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
      }
      return redirect()->route('especialista.iniciarAtendimento', [$consulta_id, "prescricoes"]);
   }
   function edit($id)
   {
      $entidade = PedidoMedicamento::find($id);
      return view('pedidomedicamento/form', ['entidade' => $entidade]);
   }

} ?>