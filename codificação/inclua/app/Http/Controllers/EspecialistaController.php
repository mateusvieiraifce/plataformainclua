<?php
namespace App\Http\Controllers;

use App\Helper;
use App\Models\Especialista;
use App\Models\PedidoMedicamento;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Especialidade;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tipoexame;
use App\Models\Exame;
use App\Models\Pedidoexame;
use App\Models\Medicamento;

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
         select('especialistas.id', 'especialistas.nome', 'especialidades.descricao as especialidade')->
         paginate(8);

      return view('especialista/list', ['lista' => $lista, 'filtro' => $filter, 'msg' => $msg]);
   }

   public function createDadosUserEspecialista($usuario_id)
   {
      $especialidades = Especialidade::all();
      return view('cadastro.especialista.form_dados', ['usuario_id' => $usuario_id, 'especialidades' => $especialidades]);
   }

   public function storeDadosUserEspecialista(Request $request)
   {
      //REMOÇÃO DA MASCARA DO CELULAR COMPARAR COM O BD
      $request->request->set('celular', Helper::removerCaractereEspecial($request->celular));
      $rules = [
         "nome" => "required|min:5",
         "celular" => "required|unique:users,celular,{$request->usuario_id}",
         "especialidade" => "required",
         'consentimento' => 'required'
      ];
      $feedbacks = [
         "nome.required" => "O campo nome é obrigatório.",
         "nome.min" => "O campo nome deve ter no mínomo 5 caracteres.",
         "celular.required" => "O campo Celular é obrigatório.",
         "celular.unique" => "Este número de celular já foi utilizado.",
         "especialidade.required" => "O campo Especialidade é obrigatório.",
         "consentimento.required" => "O campo Termos e Condições de Uso é obrigatório."
      ];
      $request->validate($rules, $feedbacks);

      try {
         if ($request->especialista_id) {
            $especialista = Especialista::find($request->especialista_id);
         } else {
            $especialista = new Especialista();
         }

         $especialista->nome = $request->nome;
         $especialista->especialidade_id = $request->especialidade;
         $especialista->usuario_id = $request->usuario_id;
         $especialista->save();

         $userController = new UsuarioController();
         $userController->storeDados($request);

         $msg = ['valor' => trans("Cadastro de dados realizado com sucesso!"), 'tipo' => 'success'];
         session()->flash('msg', $msg);
      } catch (QueryException $e) {
         $msg = ['valor' => trans("Erro ao realizar o cadastro do especialista!"), 'tipo' => 'danger'];
         session()->flash('msg', $msg);

         return back();
      }

      return redirect()->route('view.verificar_celular', ['usuario_id' => $especialista->usuario_id]);
   }

   public function editDadosUserEspecialista($usuario_id)
   {
      $user = User::find($usuario_id);
      $user->celular = $user->celular != null ? Helper::mascaraCelular($user->celular) : '';
      $especialidades = Especialidade::all();

      return view('cadastro.especialista.form_dados', ['user' => $user, 'especialidades' => $especialidades]);
   }

   public function createDadosBancarios($usuario_id)
   {
      return view('cadastro.especialista.form_bancario', ['usuario_id' => $usuario_id]);
   }

   public function storeDadosBancarios(Request $request)
   {
      $rules = [
         "conta_bancaria" => "required",
         "agencia" => "required",
         "banco" => "required",
         "chave_pix" => "required"
      ];
      $feedbacks = [
         "conta_bancaria.required" => "O campo Conta Bancária é obrigatório.",
         "agencia.required" => "O Agência é obrigatório.",
         "banco.required" => "O campo Banco é obrigatório.",
         "chave_pix.required" => "O campo Pix é obrigatório.",
      ];
      $request->validate($rules, $feedbacks);

      try {
         $especialista = Especialista::where("usuario_id", $request->usuario_id)->first();
         $especialista->conta_bancaria = $request->contaconta_bancaria;
         $especialista->agencia = $request->agencia;
         $especialista->banco = $request->banco;
         $especialista->chave_pix = $request->chave_pix;
         $especialista->save();

         $user = User::find($request->usuario_id);
         $user->etapa_cadastro = "F";
         $user->save();

         Auth::loginUsingId($user->id);
         session()->flash('msg', ['valor' => trans("Seu cadastro foi realizado com sucesso!"), 'tipo' => 'success']);
      } catch (QueryException $e) {
         $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
         session()->flash('msg', $msg);

         return back();
      }

      return redirect()->route('home');
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
         if (isset($request->password)) {
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
      return view('especialista/form', ['entidade' => $entidade, 'especialidades' => Especialidade::all(), 'usuario' => $usuario]);
   }

   function inicarAtendimento($consulta_id,$aba,$mostrarModalExame=null)
   {
      if (!($this->consultaPertenceEspecialistaLogado($consulta_id))) {
         return redirect()->route('consulta.listconsultaporespecialista');
      }
      $consulta = Consulta::find($consulta_id);
      $paciente = Paciente::find($consulta->paciente_id);
      $usuarioPaciente = User::find($paciente->usuario_id);
      $primeiraConsulta = Consulta::where('status', '=', 'Finalizada')->
         where('paciente_id', '=', $consulta->paciente_id)->
         where('especialista_id', '=', $consulta->especialista_id)->
         orderBy('horario_iniciado', 'asc')->first();
      $qtdConsultasRealizadas = Consulta::where('status', '=', 'Finalizada')->
         where('paciente_id', '=', $consulta->paciente_id)->
         where('especialista_id', '=', $consulta->especialista_id)->
         orderBy('horario_iniciado', 'asc')->count();
     
      $tipoexames = Tipoexame::orderBy('descricao', 'asc')->get();
      $exames = Exame::orderBy('nome', 'asc')->get();

      $medicamentos = Medicamento::orderBy('nome_comercial', 'asc')->get();

      //lista de pedidos de exames
      $listaPedidosExames = Pedidoexame::
      join('exames', 'exames.id', '=', 'pedido_exames.exame_id')->
      where('consulta_id',$consulta->id)->
      orderBy('pedido_exames.created_at', 'desc')->
      select('pedido_exames.id as id', 'nome','laudo')->get(); 

      //lista de pedidos de medicamentos
      $listaPedidosMedicamentos = PedidoMedicamento::
      join('medicamentos', 'medicamentos.id', '=', 'pedido_medicamentos.medicamento_id')->
      where('consulta_id',$consulta->id)->
      orderBy('pedido_medicamentos.created_at', 'desc')->
      select('pedido_medicamentos.id as id', 'nome_comercial','prescricao_indicada')->get(); 
    
      //dd($listaPedidosExames);
    //  dd($consulta_id,$aba);
      return view('userEspecialista/iniciaratendimento', [
         'consulta' => $consulta,
         'paciente' => $paciente,
         'usuarioPaciente' => $usuarioPaciente,
         'primeiraConsulta' => $primeiraConsulta,
         'qtdConsultasRealizadas' => $qtdConsultasRealizadas,
         'tipoexames' => $tipoexames,
         'exames' => $exames,
         'listaPedidosExames' => $listaPedidosExames,
         'medicamentos' => $medicamentos ,
         'listaPedidosMedicamentos' =>  $listaPedidosMedicamentos,
         'aba'=>$aba,
         'mostrarModalExame' =>$mostrarModalExame
      ]);

   }


   function finalizarAtendimento($consulta_id)
   {
      $ent = Consulta::find($consulta_id);
      $ent->status = "Finalizada";
      //  $ent->horario_iniciado = $request->horario_iniciado;
      //  $ent->horario_finalizado = $request->horario_finalizado;
      $ent->save();
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];

      $consultaController = new ConsultaController();
      return $consultaController->listconsultaporespecialista($msg);
   }

   function consultaPertenceEspecialistaLogado($consulta_id)
   {
      //aqui verifica se a consulta pertece realmente ao especialista
      //pois o usuario pode alterar o id da consulta na url
      $consulta = Consulta::find($consulta_id);
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      if ($consulta->especialista_id != $especialista->id) {
         return false;
      } else {
         return true;
      }
   }

   //lista dos pacientes que fez alguma consulta com o especialista logado
   function listaPacientes($msg = null)
   {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }

      $statusConsulta = "Finalizada";

      // Obter pacientes e o número de consultas que cada um teve
      $lista = Paciente::select('pacientes.id', 'pacientes.nome as nome_paciente', DB::raw('COUNT(consultas.id) as total_consultas'))
         ->leftJoin('consultas', 'pacientes.id', '=', 'consultas.paciente_id')
         ->where('status', '=', $statusConsulta)
         ->where('especialista_id', '=', $especialista->id)
         ->groupBy('pacientes.id', 'pacientes.nome')
         ->paginate(8);



      return view('userEspecialista/listpacienteporespecialista', [
         'lista' => $lista,
         'filtro' => $filter,
         'especialista' => $especialista,
         'msg' => $msg
      ]);

   }

   function salvaNovoExame(Request $request){    
      $entidade = Exame::create([
         'nome' => $request->nome,
         'descricao' => $request->descricao,
         'tipoexame_id' => $request->tipoexame_id
      ]);

      $mostrarModalExame = true;
      //tentar passar o valor de mostrar modal de exames apos cadastrodo.
     return $this->inicarAtendimento($request->consulta_id,"exames",$mostrarModalExame);
   
    //  return redirect()->route('especialista.iniciarAtendimento', [$request->consulta_id,"exames"]);
   }


}