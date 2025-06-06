<?php
namespace App\Http\Controllers;
use App\Models\PedidoMedicamento;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

   public function store(Request $request)
   {
      $rules = [
         "medicamento_id" => "required",
         "posologia" => "required"
      ];
      $feedbacks = [
         "medicamento_id.required" => "Selecione um medicamento.",
         "posologia.required" => "Informe a posologia do medicamento."
      ];

      $request->validate($rules, $feedbacks);

      try {
         DB::beginTransaction();
         $pedidoMedicamento = new PedidoMedicamento();
         $pedidoMedicamento->consulta_id = $request->consulta_id;
         $pedidoMedicamento->medicamento_id = $request->medicamento_id;
         $pedidoMedicamento->prescricao_indicada = $request->posologia;
         $pedidoMedicamento->save();

         $msg = ['valor' => trans("A prescrição do medicamento foi salva com sucesso!"), 'tipo' => 'success'];
         DB::commit();
      } catch (QueryException $e) {
         DB::rollBack();

         $msg = ['valor' => trans("Não foi possivel realizar prescrição do medicamento, tente novamente."), 'tipo' => 'danger'];
      }
      session()->flash('msg', $msg);

      return redirect()->route('especialista.iniciarAtendimento', [$request->consulta_id, "prescricoes"]);
   }

} ?>
