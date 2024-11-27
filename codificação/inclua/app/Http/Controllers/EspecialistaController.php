<?php
namespace App\Http\Controllers;

use App\Helper;
use App\Models\Cartao;
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
use App\Models\Medicamento;
use App\Models\PedidoExame;
use App\Models\TipoMedicamento;
use Carbon\Carbon;
use App\Models\Fila;
use Illuminate\Support\Facades\Storage;

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
      //SALVANDO AVATAR DO ESPECIALISTA
      if ($request->hasFile('image') && $request->file('image')->isValid()) {
         //VERIFICANDO SE EXISTE ALGUM AVATAR JA CADASTRADO PARA DELETAR
         $usuario = User::find($request->usuario_id);
         
         if(!empty($usuario->avatar)) {
            //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
            $linkStorage = explode('/', $usuario->avatar);
            $linkStorage = "$linkStorage[1]/$linkStorage[2]";
            Storage::delete([$linkStorage]);
         }
         
         // Nome do Arquivo
         $requestImage = $request->image;
         // Recupera a extensão do arquivo
         $extension = $requestImage->extension();
         // Define o nome
         $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
         // Faz o upload:
         $pathAvatar = $request->file('image')->storeAs('avatar-user', $imageName);
      }

      //REMOÇÃO DA MASCARA DO CELULAR, TELEFONE E CNPJ PARA COMPARAR COM O BD
      $request->request->set('telefone', Helper::removerCaractereEspecial($request->telefone));
      $request->request->set('celular', Helper::removerCaractereEspecial($request->celular));
      try {
         if ($request->especialista_id) {
            $rules = [
               "email" => "required|unique:users,email,$request->usuario_id",
               "telefone" => "required|unique:users,telefone,$request->usuario_id",
               "celular" => "required|unique:users,celular,$request->usuario_id",
               "password" => "confirmed"
            ];
         } else {
            $rules = [
               "image" => "required",
               "telefone" => "nullable|unique:users,telefone",
               "celular" => "required|unique:users,celular",
               "nome_completo" => "required",
               "email" => "required|unique:users,email",
               "password" => "required|min:8|confirmed"
            ];
         }
         $feedbacks = [
            "image.required" => "O campo Avatar é obrigatório.",
            'telefone.unique' => 'Já existe um Especialista cadastrado com este telefone.',
            'celular.required' => 'O campo Celular é obrigatório.',
            'celular.unique' => 'Este número de celular já foi utilizado.',
            "nome_completo.required" => "O campo Nome é obrigatório.",
            "email.required" => "O campo E-mail é obrigatório.",
            "email.unique" => "Este E-mail já foi utilizado.",
            "password.required" => "O campo Senha é obrigatório.",
            "password.min" => "O campo Senha deve ter no mínico 8 caracteres.",
            "password.confirmed" => "A senha informada não corresponde."
         ];
         $request->validate($rules, $feedbacks);

         if($request->usuario_id) {
            $usuario = User::find($request->usuario_id);
         } else {
            $usuario = new User();
         }
         $usuario->nome_completo = $request->nome_completo;
         $usuario->email = $request->email;
         $usuario->avatar = !empty($pathAvatar) ? "storage/$pathAvatar" : ($especialista->avatar ?? null);
         $usuario->telefone = Helper::removerCaractereEspecial($request->telefone);
         $usuario->celular = Helper::removerCaractereEspecial($request->celular);
         $usuario->password = bcrypt($request->password);
         $usuario->tipo_user = "E";
         $usuario->etapa_cadastro = "F";
         $usuario->save();
         
         if($request->especialista_id) {
            $especialista = Especialista::find($request->especialista_id);
         } else {
            $especialista = new Especialista();
         }
         $especialista->nome = $request->nome_completo;
         $especialista->usuario_id = $usuario->id;
         $especialista->especialidade_id = $request->especialidade_id;
         $especialista->conta_bancaria = $request->conta_bancaria;
         $especialista->agencia = $request->agencia;
         $especialista->banco = $request->banco;
         $especialista->chave_pix = $request->chave_pix;
         $especialista->save();
         
         session()->flash('msg', ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success']);
      } catch (QueryException $e) {
         dd($e);
         session()->flash('msg', ['valor' => trans("Houve um erro ao realizar o cadastro, tente novamente!"), 'tipo' => 'danger']);

         return back()->withInput();
      }
      
      return redirect()->route('especialista.list');
   }
   function delete($id)
   {
      try {
         $especialista = Especialista::find($id);
         $usuario = User::find($especialista->usuario_id);
         if ($especialista) {
            $especialista->delete();
            $usuario->delete();
            session()->flash('msg', ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success']);
         }
      } catch (QueryException $exp) {
         session()->flash('msg', ['valor' => trans("Houve um erro ao deletar o especialista, tente novamente!"), 'tipo' => 'danger']);

         return back();
      }
      
      return redirect()->route('especialista.list');
   }
   function edit($id)
   {
      $especialista = Especialista::find($id);
      $usuario = User::find($especialista->usuario_id);

      return view('especialista/form', ['especialista' => $especialista, 'especialidades' => Especialidade::all(), 'usuario' => $usuario]);
   }

   function inicarAtendimento($consulta_id,$aba,$mostrarModal=null)
   {
      if (!($this->consultaPertenceEspecialistaLogado($consulta_id))) {
         return redirect()->route('consulta.listconsultaporespecialista');
      }
      
      $consulta = Consulta::find($consulta_id);
      $request = request();
      
      if ($request->metodo_pagamento == "null") {
         session()->flash('msg',  ['valor' => trans("Selecione a forma de pagamento com o cartão."), 'tipo' => 'danger']);

         return back();
      }

      if($request->metodo_pagamento == "Cartão") {
         return redirect()->route('consulta.pagamento', ['consulta_id' => $consulta->id, 'aba' => $aba]);
      } elseif ($request->metodo_pagamento) {
         $consulta->isPago = true;
         $consulta->forma_pagamento = $request->metodo_pagamento;
         $consulta->save();
      }
      
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
      $listaPedidosExames = PedidoExame::join('exames', 'exames.id', '=', 'pedido_exames.exame_id')
         ->where('consulta_id',$consulta->id)
         ->orderBy('pedido_exames.created_at', 'desc')
         ->select('pedido_exames.id as id', 'nome','laudo')
         ->get(); 

      //lista de pedidos de medicamentos
      $listaPedidosMedicamentos = PedidoMedicamento::
      join('medicamentos', 'medicamentos.id', '=', 'pedido_medicamentos.medicamento_id')->
      where('consulta_id',$consulta->id)->
      orderBy('pedido_medicamentos.created_at', 'desc')->
      select('pedido_medicamentos.id as id', 'nome_comercial','prescricao_indicada')->get(); 
    
      //modificando o statu da consulta para Consulta Em Atendimento
      // e removendo da fila de espera
      $ent = Consulta::find($consulta->id);
      $ent->status = "Em Atendimento";
      $dataAtual = Carbon::now('America/Fortaleza');
      $ent->horario_iniciado = $dataAtual->format('Y-m-d H:i:s');     
      $ent->save();
      
      //deletando o item da fila
      $entidadeFila = Fila::
         where('especialista_id', $consulta->especialista_id)->
         where('clinica_id', $consulta->clinica_id)->
         where('paciente_id', $consulta->paciente_id)->first();
      if ($entidadeFila) {
         $entidadeFila->delete();
      }
       
   


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
         'tipo_medicamentos' => TipoMedicamento::all(),
         'aba'=>$aba,
         'mostrarModal' =>$mostrarModal
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
      
      // Obter pacientes e o número de consultas que cada um teve
      $lista = Paciente::select('pacientes.id', 'pacientes.nome as nome_paciente',
      'pacientes.cpf', 'pacientes.data_nascimento', 
      DB::raw('COUNT(consultas.id) as total_consultas'))
         ->leftJoin('consultas', 'pacientes.id', '=', 'consultas.paciente_id')
      //   ->where('status', '=', $statusConsulta)
         ->where('especialista_id', '=', $especialista->id)
         ->groupBy('pacientes.id', 'pacientes.nome','pacientes.cpf','pacientes.data_nascimento')
         ->paginate(8);

      return view('userEspecialista/listTodosPacientes', [
         'lista' => $lista,       
         'especialista' => $especialista,       
      ]);

   }

   //lista dos pacientes que fez alguma consulta com o especialista logado
   function listaPacientesPesquisar($msg = null)
   {
      $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();     
      //retonando a lista de pacientes
      $filtro = "";
      if (isset($_GET['filtro'])) {
         $filtro = $_GET['filtro'];
      }
      //retonando a lista de pacientes
      $cpf = "";
      if (isset($_GET['cpf'])) {
            $cpf = $_GET['cpf'];
      }

      // Obter pacientes e o número de consultas que cada um teve
      $lista = Paciente::select('pacientes.id', 'pacientes.nome as nome_paciente',
      'pacientes.cpf', 'pacientes.data_nascimento', 
      DB::raw('COUNT(consultas.id) as total_consultas'))
         ->leftJoin('consultas', 'pacientes.id', '=', 'consultas.paciente_id')
      //   ->where('status', '=', $statusConsulta)
         ->where('especialista_id', '=', $especialista->id)
         ->where('nome', 'like', "%" . $filtro . "%")
         -> where('cpf', 'like', "%" . $cpf . "%")
         ->groupBy('pacientes.id', 'pacientes.nome','pacientes.cpf','pacientes.data_nascimento')
         ->paginate(8);

         $msg = null;
         if ($lista->isEmpty()) {
               $msg = ['valor' => trans("Não foi encontrado nenhum paciente!"), 'tipo' => 'primary'];
         }

      return view('userEspecialista/listTodosPacientes', [
         'lista' => $lista,       
         'especialista' => $especialista, 
         'filtro' => $filtro, 
         'cpf' => $cpf,       
         'msg' => $msg      
      ]);

   }

   function salvaNovoExame(Request $request){    
      $entidade = Exame::create([
         'nome' => $request->nome,
         'descricao' => $request->descricao,
         'tipoexame_id' => $request->tipoexame_id
      ]);
      //tentar passar o valor de mostrar modal de exames apos cadastrodo.
     return $this->inicarAtendimento($request->consulta_id,"exames",'modalPedirExame');
    //  return redirect()->route('especialista.iniciarAtendimento', [$request->consulta_id,"exames"]);
   }

   function salvaNovoMedicamento(Request $request){    
      $entidade = Medicamento::create([
         'nome_comercial' => $request->nome_comercial,
         'nome_generico' => $request->nome_generico,
         'forma' => $request->forma,
         'concentracao' => $request->concentracao,
         'via' => $request->via,
         'indicacao' => $request->indicacao,
         'posologia' => $request->posologia,
         'precaucao' => $request->precaucao,
         'advertencia' => $request->advertencia,
         'contraindicacao' => $request->contraindicacao,
         'composicao' => $request->composicao,
         'latoratorio_fabricante' => $request->latoratorio_fabricante,
         'tipo_medicamento_id' => $request->tipo_medicamento_id
      ]);
      //modal que vai ser exibido
      $mostrarModalMedicamento = 'modalPedirMedicamento';
      //tentar passar o valor de mostrar modal de medicamentos apos cadastrodo.
     return $this->inicarAtendimento($request->consulta_id,"prescricoes",$mostrarModalMedicamento);
   }

   


}