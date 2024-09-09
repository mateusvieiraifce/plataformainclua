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

class ClinicaController extends Controller
{
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
   function save(Request $request)
   {


      $imageName = "";
      //salvando a logo na clinica
      if ($request->hasFile('image') && $request->file('image')->isValid()) {
         // Recupera a extensão do arquivo
         $requestImage = $request->image;
         $extension = $requestImage->extension();
         $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
         $pathAvatar = $request->file('image')->storeAs('logos-clinicas', $imageName);
      }

      if ($request->id) {
         $input = $request->validate([
            'email' => 'required|unique:users,email,' . $request->usuario_id,
            'cnpj' => ['required', new CnpjValidationRule, 'unique:clinicas,cnpj,' . $request->id,],
            'password' => 'confirmed',
            
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
         $ent->logotipo = !empty($pathAvatar) ? "storage/$pathAvatar" : null;
         $ent->ativo = 1;
         $ent->save();

         $entUsuario = User::find($request->usuario_id);
         $entUsuario->nome_completo = $request->nome_login;
         $entUsuario->email = $request->email;
         if (isset($request->password)) {
            $entUsuario->password = bcrypt($request->password);
         }
         $entUsuario->telefone = $request->telefone;
         $entUsuario->save();

      } else {
         $input = $request->validate([
            'email' => 'required|unique:users,email,' . $request->id,
            'cnpj' => ['required', new CnpjValidationRule, 'unique:clinicas,cnpj'],
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
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
            'ativo' => 1,
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
            $entidadeUsuario = User::find($entidade->usuario_id);
            //desativando a clinica
            $entidade->ativo = 0;
            $entidade->save();
            //desativando o usuario da clinica
            $entidadeUsuario->ativo = 0;
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
         "consentimento.required" => "O campo Termos e Condições de Uso é obrigatório."
      ];
      $request->validate($rules, $feedbacks);

      try {
         //SALVAR LOGO DA CLÍNICA
         if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            //VERIFICANDO SE EXISTE ALGUMA LOGO JA CADASTRADA PARA DELETAR
            $logotipo = Clinica::where('usuario_id', $request->usuario_id);
            if(!empty($logotipo->logotipo)) {
               //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
               $linkStorage = explode('/', $logotipo);
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
         $clinica->save();

         $userController = new UsuarioController();
         $userController->storeDados($request);

         $msg = ['valor' => trans("Cadastro de dados realizado com sucesso!"), 'tipo' => 'success'];
         session()->flash('msg', $msg);
     } catch (QueryException $e) {
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

   function marcarConsultaSelecionarPaciente($msg=null)
    {
        //retonando todos os pacientes
        $filter = "";
        if (isset($_GET['filtro'])) {
            $filter = $_GET['filtro'];
        }
        $lista = Paciente::select('id', 'nome','data_nascimento')->paginate(8);
        return view('userClinica/marcarConsulta/selecionarPacientePasso1', ['lista' => $lista, 'msg' => $msg,'filtro' => $filter]);
    }

    function pesquisarPacienteMarcarconsulta()
    {
        //retonando a lista de pacientes
        $filtro = "";
        if (isset($_GET['filtro'])) {
            $filtro = $_GET['filtro'];
        }
        $lista = Paciente::where('nome', 'like', "%" . $filtro . "%")
            ->orderBy('nome', 'asc')
            ->select('id', 'nome','data_nascimento')->paginate(8);
        $msg = null;
        if ($lista->isEmpty()) {
            $msg = ['valor' => trans("Não foi encontrado nenhum paciente com o nome digitado!"), 'tipo' => 'primary'];
        }
        return view('userClinica/marcarConsulta/selecionarPacientePasso1', ['lista' => $lista, 'filtro' => $filtro, 'msg' => $msg]);
   }

   function marcarConsultaSelecionarEspecialidade($paciente_id)
   {
        $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
        //todas as especialidades que eh vinculado a clinica
        $lista = Especialidadeclinica::join('especialidades', 'especialidades.id', 
        '=', 'especialidadeclinicas.especialidade_id')->
        where('clinica_id', $clinica->id)->
        orderBy('especialidades.descricao', 'asc')->
        select('especialidades.id', 'especialidades.descricao')->paginate(8);       
        return view('userClinica/marcarConsulta/selecionarEspecialidadePasso2', ['lista' => $lista, 'paciente_id' => $paciente_id]);
   }

   
   function marcarConsultaSelecionarEspecialista($paciente_id, $especialidade_id)
   {
      $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
       //retornar todos os especialista vinculados a clinica e com a especiladade selecionada
       $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=',
        'especialistaclinicas.especialista_id')->
       where('clinica_id', $clinica->id)->
       where('especialidade_id', $especialidade_id)->
       orderBy('especialistas.nome', 'asc')->
       select('especialistas.id', 'especialistas.nome')->paginate(8);
       return view('userClinica/marcarConsulta/selecionarEspecialistaPasso3', ['lista' => $lista, 'paciente_id' => $paciente_id, 'especialidade_id' =>$especialidade_id]);
   }

   
   function marcarConsultaSelecionarHoraConsulta($paciente_id, $especialista_id)
   {
       $especialista = Especialista::find($especialista_id);

       $clinica =  Clinica::where('usuario_id', '=', Auth::user()->id)->first();
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

        $ent->status = "Aguardando atendimento";
        $ent->paciente_id = $paciente->id;
        $ent->save();
        $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
        return  $this->marcarConsultaSelecionarPaciente($msg);
    }

   
}
   