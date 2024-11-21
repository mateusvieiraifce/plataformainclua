<?php
namespace App\Http\Controllers;

use App\Helper;
use App\Models\Clinica;
use App\Models\Endereco;
use App\Models\Paciente;
use App\Models\Especialidadeclinica;
use App\Models\Especialistaclinica;
use App\Models\Especialista;
use App\Models\Especialidade;
use App\Models\Consulta;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Rules\CnpjValidationRule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Mail\ConvidarEspecialistaMailable;
use Illuminate\Support\Facades\Mail;

class ClinicaController extends Controller
{

   public function enviarConviteEspecialista(Request $request)
   {  

      Mail::to($request->email_destino)->send(new ConvidarEspecialistaMailable());
       
      $msg = ['valor' => trans("E-mail enviado com sucesso!"), 'tipo' => 'success'];
      $especialistaclinicaController = new EspecialistaclinicaController();
      return $especialistaclinicaController->list($msg);
   }


   function list($msg = null)
   {
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Clinica::where('nome', 'like', "%" . "%")->
         orderBy('nome', 'asc')->
         paginate(8);
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
         select('clinicas.id', 'users.nome_completo as nome_responsavel', 'nome', 'cnpj', 'clinicas.telefone', 'clinicas.ativo')->
         paginate(8);
      return view('clinica/list', ['lista' => $lista, 'filtro' => $request->filtro])->with('filtro', $filter);
   }

   public function save(Request $request)
   {
      //SALVAR LOGO DA CLÍNICA
      if ($request->hasFile('image') && $request->file('image')->isValid()) {
         //VERIFICANDO SE EXISTE ALGUMA LOGO JA CADASTRADA PARA DELETAR
         $clinica = Clinica::where('usuario_id', $request->usuario_id)->first();
         
         if(!empty($clinica->logotipo)) {
            //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
            $linkStorage = explode('/', $clinica);
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
         $pathLogo = $request->file('image')->storeAs('logos-clinicas', $imageName);
      }

      //REMOÇÃO DA MASCARA DO CELULAR, TELEFONE E CNPJ PARA COMPARAR COM O BD
      $request->request->set('telefone', Helper::removerCaractereEspecial($request->telefone));
      $request->request->set('celular', Helper::removerCaractereEspecial($request->celular));
      try {
         if ($request->clinica_id) {
            $rules = [
               "cnpj" => "required|unique:clinicas,cnpj,$request->clinica_id|unique:users,documento,$request->usuario_id",
               "email" => "required|unique:users,email,$request->usuario_id",
               "telefone" => "required|unique:users,telefone,$request->usuario_id",
               "celular" => "required|unique:users,celular,$request->usuario_id",
               "password" => "confirmed"
            ];
         } else {
            $rules = [
               "image" => "required",
               "cnpj" => "required|unique:clinicas,cnpj|unique:users,documento",
               "nome_fantasia" => "required",
               "razao_social" => "required",
               "telefone" => "nullable|unique:users,telefone",
               "celular" => "required|unique:users,celular",
               "numero_atendimento_social_mensal" => "required",
               "cep" => "required",
               "cidade" => "required",
               "estado" => "required",
               "endereco" => "required",
               "numero" => "required",
               "bairro" => "required",
               "longitude" => "required",
               "latitude" => "required",
               "nome_completo" => "required",
               "email" => "required|unique:users,email",
               "password" => "required|min:8|confirmed"
            ];
         }
         $feedbacks = [
            "image.required" => "O campo Logo da Clínica é obrigatório.",
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            "cnpj.unique" => "Este CNPJ já foi utilizado.",
            'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório.',
            'razao_social.required' => 'O campo Razão Social é obrigatório.',
            'telefone.unique' => 'Já existe uma clínica cadastrada com este telefone.',
            'celular.required' => 'O campo Celular é obrigatório.',
            'celular.unique' => 'Este número de celular já foi utilizado.',
            'numero_atendimento_social_mensal.required' => "O campo N° de atendimentos sociais mensais é obrigatório.",
            "cep.required" => "O campo CEP é obrigatório.",
            "cidade.required" => "O campo Cidade é obrigatório.",
            "estado.required" => "O campo Estado é obrigatório.",
            "endereco.required" => "O campo Endereço é obrigatório.",
            "numero.required" => "O campo Número é obrigatório.",
            "bairro.required" => "O campo Bairro é obrigatório.",
            "longitude.required" => "O campo Longitude é obrigatório.",
            "latitude.required" => "O campo Latitude é obrigatório.",
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
         $usuario->documento = Helper::removerCaractereEspecial($request->cnpj);
         $usuario->telefone = Helper::removerCaractereEspecial($request->telefone);
         $usuario->celular = Helper::removerCaractereEspecial($request->celular);
         $usuario->password = bcrypt($request->password);
         $usuario->tipo_user = "C";
         $usuario->etapa_cadastro = "F";
         $usuario->save();
         
         if($request->clinica_id) {
            $clinica = Clinica::find($request->clinica_id);
         } else {
            $clinica = new Clinica();
         }
         $clinica->nome = $request->nome_fantasia;
         $clinica->razaosocial = $request->razao_social;
         $clinica->cnpj = Helper::removerCaractereEspecial($request->cnpj);
         $clinica->numero_atendimento_social_mensal = $request->numero_atendimento_social_mensal;
         $clinica->ativo = 1;
         $clinica->usuario_id = $usuario->id;
         $clinica->logotipo = !empty($pathLogo) ? "storage/$pathLogo" : ($clinica->logotipo ?? null);
         $clinica->save();

         if($request->endereco_id) {
            $endereco = Endereco::find($request->endereco_id);
         } else {
            $endereco = new Endereco();
         }
         $endereco->user_id = $usuario->id;
         $endereco->cep = Helper::removeMascaraCep($request->cep);
         $endereco->cidade = $request->cidade;
         $endereco->estado = $request->estado;
         $endereco->rua = $request->endereco;
         $endereco->numero = $request->numero;
         $endereco->complemento = $request->complemento;
         $endereco->longitude = $request->longitude;
         $endereco->latitude = $request->latitude;
         $endereco->bairro = $request->bairro;
         $endereco->principal = true;
         $endereco->save();
         session()->flash('msg', ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success']);
      } catch (QueryException $e) {
         session()->flash('msg', ['valor' => trans("Houve um erro ao realizar o cadastro, tente novamente!"), 'tipo' => 'danger']);

         return back()->withInput();
      }
      
      return redirect()->route('clinica.list');
   }

   function delete($id)
   {
      try {
         $entidade = Clinica::find($id);
         if ($entidade) {
            $entidadeUsuario = User::find($entidade->usuario_id);
            //desativando a clinica
            $entidade->ativo = !$entidade->ativo;
            $entidade->save();
            //desativando o usuario da clinica
            $entidadeUsuario->ativo = !$entidadeUsuario->ativo;
            $entidadeUsuario->save();
         }
         $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      } catch (QueryException $exp) {
         $msg = ['valor' => $exp->getMessage(), 'tipo' => 'primary'];
      }
      return $this->list($msg);
   }
   function edit($id)
   {
      $clinica = Clinica::find($id);
      $usuario = User::find($clinica->usuario_id);
      $endereco = Endereco::where('user_id', $usuario->id)->where('principal', true)->first();
      
      return view('clinica/form', ['clinica' => $clinica, 'usuario' => $usuario, 'endereco' => $endereco]);
   }
   
   public function createDadosUserClinica($usuario_id)
   {
      return view('cadastro.clinica.form_dados', ['usuario_id' => $usuario_id]);
   }

   public function storeDadosUserClinica(Request $request)
   {
      //REMOÇÃO DA MASCARA DO CELULAR, TELEFONE E CNPJ PARA COMPARAR COM O BD
      $request->request->set('telefone', Helper::removerCaractereEspecial($request->telefone));
      $request->request->set('celular', Helper::removerCaractereEspecial($request->celular));
      $request->request->set('documento', Helper::removerCaractereEspecial($request->documento));
      $rules = [
         "logo" => "required",
         "nome_fantasia" => "required",
         "razao_social" => "required",
         "documento" => "required|unique:users,documento,{$request->usuario_id}",
         "telefone" => "unique:users,telefone,{$request->usuario_id}",
         "celular" => "required|unique:users,celular,{$request->usuario_id}",
         "numero_atendimento_social_mensal" => "required",
         "anamnese_obrigatoria" => "required",
         'consentimento'=>'required'
      ];
      $feedbacks = [
         "logo.required" => "O campo Logo da Clínica é obrigatório.",
         'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório.',
         'razao_social.required' => 'O campo Razão Social é obrigatório.',
         'documento.required' => 'O campo CNPJ é obrigatório.',
         "documento.unique" => "Este CNPJ já foi utilizado.",
         'telefone.unique' => 'Já existe uma clínica cadastrada com este telefone.',
         'celular.required' => 'O campo Celular é obrigatório.',
         'celular.unique' => 'Este número de celular já foi utilizado.',
         'numero_atendimento_social_mensal.required' => "O campo N° de atendimentos sociais mensais é obrigatório.",
         'anamnese_obrigatoria.required' => "O campo Anamnese é obrigatório.",
         "consentimento.required" => "O campo Termos e Condições de Uso é obrigatório."
      ];
      $request->validate($rules, $feedbacks);
      try {
         //SALVAR LOGO DA CLÍNICA
         if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            //VERIFICANDO SE EXISTE ALGUMA LOGO JA CADASTRADA PARA DELETAR
            $clinica = Clinica::where('usuario_id', $request->usuario_id);
            
            if(!empty($clinica->logotipo)) {
               //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
               $linkStorage = explode('/', $clinica);
               $linkStorage = "$linkStorage[1]/$linkStorage[2]";
               Storage::delete([$linkStorage]);
            }
            
            // Nome do Arquivo
            $requestImage = $request->logo;
            // Recupera a extensão do arquivo
            $extension = $requestImage->extension();
            // Define o nome
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
            // Faz o upload:
            $pathAvatar = $request->file('logo')->storeAs('logos-clinicas', $imageName);
         }

         $clinica = Clinica::where('usuario_id', $request->usuario_id)->first();
         if(empty($clinica)) {
            $clinica = new Clinica();
         }

         $clinica->usuario_id = $request->usuario_id;
         $clinica->nome = $request->nome_fantasia;
         $clinica->razaosocial = $request->razao_social;
         $clinica->cnpj = Helper::removerCaractereEspecial($request->documento);
         $clinica->logotipo = "storage/$pathAvatar" ;
         $clinica->numero_atendimento_social_mensal = $request->numero_atendimento_social_mensal;
         $clinica->anamnese_obrigatoria = $request->anamnese_obrigatoria;
         $clinica->save();

         $userController = new UsuarioController();
         $userController->storeDados($request);

         $msg = ['valor' => trans("Cadastro de dados realizado com sucesso!"), 'tipo' => 'success'];
         session()->flash('msg', $msg);
     } catch (QueryException $e) {
      dd($e);
         session()->flash('msg', ['valor' => trans("Erro ao realizar o cadastro da clínica!"), 'tipo' => 'danger']);

         return back();
     }

     return redirect()->route('view.verificar_celular', ['usuario_id' => $clinica->usuario_id]);
   }

   public function editDadosUserClinica($usuario_id)
   {
      $clinica = Clinica::where('usuario_id', $usuario_id)->first();
      $clinica->cnpj = $clinica->cnpj != null ? Helper::mascaraCNPJ($clinica->cnpj) : '';
      $clinica->celular = $clinica->celular != null ? Helper::mascaraCelular($clinica->celular) : '';

      return view('cadastro.clinica.form_dados', ['usuario_id' => $usuario_id, 'clinica' => $clinica]);
   }

   public function createEnderecoClinica($usuario_id)
   {
      $clinica = Clinica::where('usuario_id', $usuario_id)->first();
      return view('cadastro.clinica.form_endereco', ['usuario_id' => $usuario_id, 'clinica' => $clinica]);
   }

   public function storeEnderecoClinica(Request $request)
   {
      $rules = [
         "cep" => "required",
         "cidade" => "required",
         "estado" => "required",
         "endereco" => "required",
         "numero" => "required",
         "bairro" => "required",
         "longitude" => "required",
         "latitude" => "required"
      ];
      $feedbacks = [
         "cep.required" => "O campo CEP é obrigatório.",
         "cidade.required" => "O campo Cidade é obrigatório.",
         "estado.required" => "O campo Estado é obrigatório.",
         "endereco.required" => "O campo Endereço é obrigatório.",
         "numero.required" => "O campo Número é obrigatório.",
         "bairro.required" => "O campo Bairro é obrigatório.",
         "longitude.required" => "O campo Longitude é obrigatório.",
         "latitude.required" => "O campo Latitude é obrigatório."
      ];
      $request->validate($rules, $feedbacks);

      try {
         $enderecoController = new EnderecoController();
         $enderecoController->storeEndereco($request);

         $user = User::find($request->usuario_id);
         $user->etapa_cadastro = "F";
         $user->save();

         $clinica = Clinica::find($request->clinica_id);
         $clinica->ativo = 1;
         $clinica->save();

         Auth::loginUsingId($user->id);
         $msg = ['valor' => trans("Seu cadastro foi finalizado com sucesso!"), 'tipo' => 'success'];
         session()->flash('msg', $msg);
      } catch (QueryException $e) {
         $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
         session()->flash('msg', $msg);

         return back();
      }

      return redirect()->route('home');
   }

   function marcarConsultaSelecionarPaciente($clinica_id = null, $msg = null)
    {
      $lista = Paciente::orderBy('nome', 'asc')->paginate(8);  
      
      return view('userClinica/marcarConsulta/selecionarPacientePasso1', ['lista' => $lista, 'clinica_id' => $clinica_id, 'msg' => $msg, 'filtro' => null,'cpf' => null]);
   }

    function pesquisarPacienteMarcarconsulta()
    {
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

         $lista = Paciente::where('nome', 'like', "%" . $filtro . "%")
            ->where('cpf', 'like', "%" . $cpf . "%")
            ->orderBy('nome', 'asc')
            ->paginate(8);
         
         if ($lista->isEmpty()) {
            $msg = ['valor' => trans("Não foi encontrado nenhum paciente!"), 'tipo' => 'primary'];
            session()->flash('msg', $msg);
         }

         return back()->with('lista', $lista)->withInput();
   }

   function marcarConsultaSelecionarEspecialidade($paciente_id, $clinica_id = null)
   {
      if ( Auth::user()->tipo_user == "E") {
         $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      } else {
         $clinica = Clinica::find($clinica_id);
      }
        //todas as especialidades que eh vinculado a clinica
        $lista = Especialidadeclinica::join('especialidades', 'especialidades.id', 
        '=', 'especialidadeclinicas.especialidade_id')->
        where('clinica_id', $clinica->id)->
        where('is_vinculado', 1)->
        orderBy('especialidades.descricao', 'asc')->
        select('especialidades.id', 'especialidades.descricao')->paginate(8);       
        return view('userClinica/marcarConsulta/selecionarEspecialidadePasso2', ['lista' => $lista, 'clinica' => $clinica, 'paciente_id' => $paciente_id]);
   }
   
   function marcarConsultaSelecionarEspecialista($paciente_id, $especialidade_id, $clinica_id = null)
   {
      if (Auth::user()->tipo_user == "E") {
         $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      } else {
         $clinica = Clinica::find($clinica_id);
      }
      
       //retornar todos os especialista vinculados a clinica e com a especiladade selecionada
       $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=',
        'especialistaclinicas.especialista_id')->
       where('clinica_id', $clinica->id)->
       where('especialidade_id', $especialidade_id)->
       orderBy('especialistas.nome', 'asc')->
       select('especialistas.id', 'especialistas.nome')->paginate(8);
       return view('userClinica/marcarConsulta/selecionarEspecialistaPasso3', ['lista' => $lista, 'clinica' => $clinica, 'paciente_id' => $paciente_id, 'especialidade_id' =>$especialidade_id]);
   }

   
   function marcarConsultaSelecionarHoraConsulta($paciente_id, $especialista_id, $clinica_id = null)
   {
       $especialista = Especialista::find($especialista_id);

       if (Auth::user()->tipo_user == "E") {
         $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      } else {
         $clinica = Clinica::find($clinica_id);
      }
       $especialidade = Especialidade::find($especialista->especialidade_id);
       $paciente = Paciente::find($paciente_id);
       //retornar todos a agenda(consultas) do especialista vinculados a clinica
       $statusConsulta = "Disponível";

       $lista = Consulta::where('especialista_id', '=', $especialista_id)->
       where('clinica_id', '=', $clinica->id)->
       where('status', '=', $statusConsulta)->
       select('consultas.id', 'horario_agendado')->
       orderBy('horario_agendado', 'asc')->get();
     // dd($especialista,$lista);
       return view('userClinica/marcarConsulta/selecionarHoraConsultaPasso4', ['lista' => $lista, 'especialista' => $especialista, 'clinica' => $clinica, 'especialidade' => $especialidade, 'paciente' => $paciente]);
   }

   function marcarConsultaFinalizar(Request $request)
    {   
      $paciente =  Paciente::find($request->paciente_id);
      $ent = Consulta::find($request->consulta_id);
      $clinica_id = $ent->clinica_id;
      $ent->status = "Aguardando atendimento";
      $ent->paciente_id = $paciente->id;
      $ent->save();
      $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
      
      return  $this->marcarConsultaSelecionarPaciente($clinica_id, $msg);
    }


     //lista dos pacientes que fez alguma consulta com a clinica logada
 
     function listaPacientes($msg = null)
   {
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
     
    //  $statusConsulta = "Finalizada";
      // Obter pacientes e o número de consultas que cada um teve
      $lista = Paciente::select('pacientes.id', 'pacientes.nome as nome_paciente',
      'pacientes.cpf', 'pacientes.data_nascimento', 
      DB::raw('COUNT(consultas.id) as total_consultas'))
         ->leftJoin('consultas', 'pacientes.id', '=', 'consultas.paciente_id')
      //   ->where('status', '=', $statusConsulta)
         ->where('clinica_id', '=', $clinica->id)
         ->groupBy('pacientes.id', 'pacientes.nome','pacientes.cpf','pacientes.data_nascimento')
         ->paginate(8);

      return view('userClinica/listPacientes', [
         'lista' => $lista,
         'filtro' => null,        
         'msg' => $msg
      ]);
   }

   //lista dos pacientes que fez alguma consulta com a clinica logada
   function listaPacientesPesquisar($msg = null)
   {
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
      

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

    //  $statusConsulta = "Finalizada";
      // Obter pacientes e o número de consultas que cada um teve
      $lista = Paciente::select('pacientes.id', 'pacientes.nome as nome_paciente',
      'pacientes.cpf', 'pacientes.data_nascimento', 
      DB::raw('COUNT(consultas.id) as total_consultas'))
         ->leftJoin('consultas', 'pacientes.id', '=', 'consultas.paciente_id')
       //  ->where('status', '=', $statusConsulta)
         ->where('clinica_id', '=', $clinica->id)
         ->where('nome', 'like', "%" . $filtro . "%")
         -> where('cpf', 'like', "%" . $cpf . "%")
         ->groupBy('pacientes.id', 'pacientes.nome','pacientes.cpf','pacientes.data_nascimento')
         ->paginate(8);

         $msg = null;
         if ($lista->isEmpty()) {
               $msg = ['valor' => trans("Não foi encontrado nenhum paciente!"), 'tipo' => 'primary'];
         }
      return view('userClinica/listPacientes', [
         'lista' => $lista,
         'filtro' => $filtro, 
         'cpf' => $cpf,       
         'msg' => $msg
      ]);
   }

   
   function canelarconsultaViaClinica(Request $request)
   {  
   // dd($request);
    //ver a questao financeira
    $consultaCancelada = Consulta::find($request->consulta_id);

    $dataConsultaCancelada = Carbon::parse($consultaCancelada->horario_agendado);
    $dataAtual = Carbon::now();   
    // Verifica se a data da consulta é maior que a data atual para poder duplicar
    if ($dataConsultaCancelada->gt($dataAtual)) {      
      $consultaNova = $consultaCancelada->replicate();
      $consultaNova->status="Disponível";
      $consultaNova->isPago= false;
      $consultaNova->forma_pagamento=null;
      $consultaNova->paciente_id = null;
      $consultaNova->save();  
    }
    
    $consultaCancelada->status="Cancelada";
    $consultaCancelada->motivocancelamento= $request->motivocancelamento;
    $consultaCancelada->id_usuario_cancelou =  Auth::user()->id;
    $consultaCancelada->save();
    $msg = ['valor' => trans("Consulta cancelada com sucesso!"), 'tipo' => 'success'];

    $request->merge([
      'nomepaciente' => $request->nomepacienteM,
      'cpf' => $request->cpfM,
      'inicio_data' => $request->inicio_dataM,
      'final_data' => $request->final_dataM,
      'especialista_id' =>  $request->especialista_idM
    ]);   

   
    $consultaController = new ConsultaController();
    return  $consultaController->listConsultaAgendadaUserClinicaPesquisar($request,$msg);
   }


   function formRelatorioEspecialista()
   {
      
   }
   
}
   