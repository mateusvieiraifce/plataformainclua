<?php
namespace App\Http\Controllers;
use App\Models\Pedidoexame;
use App\Models\Consulta;
use App\Models\Exame;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoExameController extends Controller
{
   function list($msg = null)
   {

      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Pedidoexame::where('nome', 'like', "%" . "%")->orderBy('id', 'desc')->paginate(10);
      return view('pedidoexame/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }

   function salveVarios(Request $request)
   {
      $pedidosExames = $request->input('pedidosExames');
      foreach ($pedidosExames as $item) {
         $entidade = Pedidoexame::create([
            'consulta_id' => $request->consulta_id,
            'exame_id' => $item
         ]);
      }
      return redirect()->route('especialista.iniciarAtendimento', $request->consulta_id);
   }

   function delete($id, $consulta_id)
   {
      $especialidadeController = new EspecialistaController();
      if ($especialidadeController->consultaPertenceEspecialistaLogado($consulta_id)) {
         try {
            $entidade = Pedidoexame::find($id);
            if ($entidade) {
               $entidade->delete();
               $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
            } else {
               $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
            }
         } catch (QueryException $exp) {
            $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
         }
      }
      return redirect()->route('especialista.iniciarAtendimento', $consulta_id);
   }

} ?>