<?php
namespace App\Http\Controllers;
use App\Models\Consulta;
use App\Models\Exame;
use App\Models\PedidoExame;
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
      $lista = PedidoExame::where('nome', 'like', "%" . "%")->orderBy('id', 'desc')->paginate(10);
      return view('pedidoexame/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }

   function salveVarios(Request $request)
   {    
      $pedidosExames = $request->input('exames');
      foreach ($pedidosExames as $item) {
         $entidade = Pedidoexame::create([
            'consulta_id' => $request->consulta_id,
            'exame_id' => $item
         ]);
      }
      return redirect()->route('especialista.iniciarAtendimento', [$request->consulta_id,"exames"]);
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
      return redirect()->route('especialista.iniciarAtendimento', [$consulta_id, "exames"]);
   }


   public function pedidoExamesPaciente()
   {
      $pedidoExames = PedidoExame::join('consultas', 'consultas.id', 'pedido_exames.consulta_id')
         ->join('exames', 'exames.id', 'pedido_exames.exame_id')
         ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
         ->join('especialistas', 'especialistas.id', 'consultas.especialista_id')
         ->where('pacientes.usuario_id', Auth::user()->id)
         ->select(
            'pedido_exames.*', 'pacientes.nome as nome_paciente', 'exames.nome as nome_exame', 'especialistas.nome as nome_especialista',
            'pedido_exames.created_at as data_solicitacao', 'pedido_exames.id as pedido_exame_id'
         )
         ->paginate(8);

      return view('userPaciente.exames.lista', ['pedidoExames' => $pedidoExames]);
   }

   public function storeArquivoExame(Request $request)
   {
      try {
         // Define um aleatório para o arquivo baseado no timestamps atual
         $name = uniqid(date('HisYmd'));   
         // Recupera a extensão do arquivo
         $extension = $request->arquivo->extension();   
         // Define finalmente o nome
         $nameFile = "{$name}.{$extension}";
         // Faz o upload:
         $local_arquivo_exame = "storage/".$request->arquivo->storeAs('exames', $nameFile);

         $pedido_exame = PedidoExame::find($request->pedido_exame_id);
         $pedido_exame->local_arquivo_exame = $local_arquivo_exame;
         $pedido_exame->save();

         session()->flash('msg', ['valor' => trans("O arquivo do exame foi salvo com sucesso!"), 'tipo' => 'success']);
      } catch (QueryException $e) {
         session()->flash('msg', ['valor' => trans("Houve um erro ao salvar o arquivo do exame, tente novamente."), 'tipo' => 'danger']);
      }
      
      return back();
   }

   public function checkExame(Request $request)
   {
      $pedido_exame = PedidoExame::find($request->pedido_exame_id);
      $pedido_exame->exame_efetuado = $request->efetuado;
      $pedido_exame->save();

      if ($request->efetuado == "Sim") {
         $response = "A confirmação do exame efetuado foi realizado com sucesso!";
      } else {
         $response = "A remoção do exame efetuado foi realizada com sucesso!";
      }

      return response()->json($response);
   }
} ?>