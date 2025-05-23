<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Anamnese;
use App\Models\Cartao;
use App\Models\Clinica;
use App\Models\Especialidadeclinica;
use App\Models\Especialistaclinica;
use App\Models\Consulta;
use App\Models\Especialista;
use App\Models\Especialidade;
use App\Models\Paciente;
use App\Models\PedidoExame;
use App\Models\PedidoMedicamento;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PacienteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->tipo_user == "P") {
            $pacientes = Paciente::where('usuario_id', $user->id)->get();

            return view('userPaciente.paciente.lista', ['pacientes' => $pacientes]);
        }
    }

    public function create()
    {
        return view('userPaciente.paciente.form');
    }

    public function store(Request $request)
    {
        //REMOÇÃO DA MASCARA DOCUMENTO PARA COMPARAR COM O BD
        $request->request->set('documento', Helper::removerCaractereEspecial($request->documento));
        $rules = [
            "nome" => "required|min:5",
            "documento" => "required|unique:users,documento,{$request->usuario_id}",
            'data_nascimento' => 'required|date|before_or_equal:today',
            "sexo" => "required"
        ];
        $feedbacks = [
            "nome.required" => "O campo Nome é obrigatório.",
            "nome.min" => "O campo nome deve ter no mínomo 5 caracteres.",
            "documento.required" => "O campo CPF é obrigatório.",
            "documento.unique" => "Este CPF já foi utilizado.",
            "data_nascimento.required" => "O campo Data de nascimento é obrigatório.",
            "estado_civil.required" => "O campo Estado civil é obrigatório.",
            "sexo.required" => "O campo Gênero é obrigatório."
        ];
        $request->validate($rules, $feedbacks);

        try {
            $paciente = new Paciente();
            $paciente->usuario_id = Auth::user()->id;
            $paciente->nome = $request->nome;
            $paciente->data_nascimento = $request->data_nascimento;
            $paciente->sexo = $request->sexo;
            $paciente->cpf = $request->documento;
            $paciente->save();

            $msg = ['valor' => trans("Cadastro do paciente realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {

                $msg = ['valor' => trans("Já existe um paciente com este CPF. Tente novamente."), 'tipo' => 'danger'];
                session()->flash('msg', $msg);
                return back()->withInput();

            }
            $msg = ['valor' => trans("Houve um erro ao realizar o cadastro do paciente. Tente novamente."), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
            return back()->withInput();
        }

        return redirect()->route('paciente.index');
    }

    public function edit($id) {
        $paciente = Paciente::find($id);
        return view('userPaciente.paciente.edit', ['paciente' => $paciente]);
    }

    public function update(Request $request) {
        $request->request->set('documento', Helper::removerCaractereEspecial($request->documento));
        $rules = [
            "nome" => "required|min:5",
            "documento" => "required|unique:users,documento,{$request->usuario_id}",
            'data_nascimento' => 'required|date|before_or_equal:today',
            "sexo" => "required"
        ];
        $feedbacks = [
            "nome.required" => "O campo Nome é obrigatório.",
            "nome.min" => "O campo nome deve ter no mínomo 5 caracteres.",
            "documento.required" => "O campo CPF é obrigatório.",
            "documento.unique" => "Este CPF já foi utilizado.",
            "data_nascimento.required" => "O campo Data de nascimento é obrigatório.",
            "estado_civil.required" => "O campo Estado civil é obrigatório.",
            "sexo.required" => "O campo Gênero é obrigatório."
        ];

        $request->validate($rules, $feedbacks);

        try {

        $paciente = Paciente::find($request->id);
        $paciente->usuario_id = Auth::user()->id;
        $paciente->nome = $request->nome;
        $paciente->data_nascimento = $request->data_nascimento;
        $paciente->sexo = $request->sexo;
        $paciente->cpf = $request->documento;
        $paciente->save();

        $msg = ['valor' => trans("Edição do paciente realizada com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {

                $msg = ['valor' => trans("Já existe um paciente com este CPF. Tente novamente."), 'tipo' => 'danger'];
                session()->flash('msg', $msg);
                return back()->withInput();

            }
            $msg = ['valor' => trans("Houve um erro ao realizar o cadastro do paciente. Tente novamente."), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
            return back()->withInput();
        }

        return redirect()->route('paciente.index');
    }

    public function createDadosUserPaciente($usuario_id)
    {
        return view('cadastro.paciente.form_dados', ['usuario_id' => $usuario_id]);
    }

    public function storeDadosUserPaciente(Request $request)
    {
        //REMOÇÃO DA MASCARA DO CELULAR E DOCUMENTO PARA COMPARAR COM O BD
        $request->request->set('celular', Helper::removerCaractereEspecial($request->celular));
        $request->request->set('documento', Helper::removerCaractereEspecial($request->documento));
        $rules = [
            "image" => "required",
            "documento" => "required|unique:users,documento,{$request->usuario_id}|unique:pacientes,cpf,{$request->usuario_id}",
            "nome" => "required|min:5",
            "celular" => "required|unique:users,celular,{$request->usuario_id}",
            "data_nascimento" => "required",
            "estado_civil" => "required",
            "sexo" => "required",
            'consentimento' => 'required',
        ];
        $feedbacks = [
            "image.required" => "O campo Imagem é obrigatório.",
            "documento.required" => "O campo CPF é obrigatório.",
            "documento.unique" => "Este CPF já foi utilizado.",
            "nome.required" => "O campo Nome é obrigatório.",
            "nome.min" => "O campo nome deve ter no mínomo 5 caracteres.",
            "celular.required" => "O campo Celular é obrigatório.",
            "celular.unique" => "Este número de celular já foi utilizado.",
            "data_nascimento.required" => "O campo Data de nascimento é obrigatório.",
            "estado_civil.required" => "O campo Estado civil é obrigatório.",
            "sexo.required" => "O campo Gênero é obrigatório.",
            "consentimento.required" => "O campo Termos e Condições de Uso é obrigatório.",
        ];
        $request->validate($rules, $feedbacks);

        try {
            if ($request->id_paciente) {
                $paciente = Paciente::find($request->id_paciente);
            } else {
                $paciente = new Paciente();
            }

            $paciente->nome = $request->nome;
            $paciente->usuario_id = $request->usuario_id;
            $paciente->data_nascimento = $request->data_nascimento;
            $paciente->sexo = $request->sexo;
            $paciente->cpf = $request->documento;
            $paciente->responsavel = true;
            $paciente->save();

            $userController = new UsuarioController();
            $userController->storeDados($request);

            $msg = ['valor' => trans("Cadastro de dados realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            session()->flash('msg', ['valor' => trans("Erro ao realizar o cadastro do paciente!"), 'tipo' => 'danger']);

            return back();
        }

        return redirect()->route('view.verificar_celular', ['usuario_id' => $paciente->usuario_id]);
    }

    public function editDadosUserPaciente($usuario_id)
    {
        $user = User::find($usuario_id);
        $user->celular = $user->celular == null ? '' : Helper::mascaraCelular($user->celular);
        $user->documento = $user->documento == null ? '' : Helper::mascaraCPF($user->documento);

        return view('cadastro.paciente.form_dados', ['user' => $user]);
    }

    public function createEnderecoPaciente($usuario_id)
    {
        return view('cadastro.paciente.form_endereco', ['usuario_id' => $usuario_id]);
    }

    public function storeEnderecoPaciente(Request $request)
    {
        $rules = [
            "cep" => "required",
            "cidade" => "required",
            "estado" => "required",
            "endereco" => "required",
            "numero" => "required",
            "bairro" => "required",
        ];
        $feedbacks = [
            "cep.required" => "O campo CEP é obrigatório.",
            "cidade.required" => "O campo Cidade é obrigatório.",
            "estado.required" => "O campo Estado é obrigatório.",
            "endereco.required" => "O campo Endereço é obrigatório.",
            "numero.required" => "O campo Número é obrigatório.",
            "bairro.required" => "O campo Bairro é obrigatório."
        ];
        $request->validate($rules, $feedbacks);

        try {
            $enderecoController = new EnderecoController();
            $enderecoController->storeEndereco($request);

            $user = User::find($request->usuario_id);

            if (env('ASSINATURA_OBRIGATORIA')) {
                $user->etapa_cadastro = '4';
            } else {
                $user->etapa_cadastro = "F";
                Auth::loginUsingId($user->id);
            }

            $user->save();

            $msg = ['valor' => trans("Cadastro de endereço realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        if (env('ASSINATURA_OBRIGATORIA')) {
            return redirect()->route('cartao.create', ['usuario_id' => $request->usuario_id]);
        } else {
            session()->flash('wellcome', true);
            return redirect()->route('home');
        }
    }

    function minhasconsultas($msg = null)
    {
        $filtro = "";
        if (isset($_GET['filtro'])) {
            $filtro = $_GET['filtro'];
        }
        $paciente = Paciente::where('usuario_id', '=', Auth::user()->id)->first();
        $statusConsulta = "Aguardando atendimento";
        $consultas = Consulta::join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')
            ->join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')
            ->join('especialidades', 'especialidades.id', '=', 'especialistas.especialidade_id')
            ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
            ->join('users', 'users.id', 'pacientes.usuario_id')
            ->where('users.id', $paciente->usuario_id)
            ->where('status', '=', $statusConsulta)
            ->select(
                'pacientes.nome',
                'consultas.id',
                'horario_agendado',
                'especialistas.nome as nome_especialista',
                'clinicas.nome as nome_clinica',
                'especialidades.descricao as descricao_especialidade'
            )
            ->orderBy('horario_agendado', 'asc')
            ->paginate(8);
      return view('userPaciente/minhasconsultas', ['consultas' => $consultas,  'msg' => $msg,'filtro' => $filtro]);
   }

    function historicoConsultas($msg = null)
    {
        $user = auth()->user();
        $filtro = "";
        if (isset($_GET['filtro'])) {
            $filtro = $_GET['filtro'];
        }
        $paciente = Paciente::where('usuario_id', '=', Auth::user()->id)->first();
        $statusConsulta = "Finalizada";

        if ($user->tipo_user == "P") {
            $consultas = Consulta::join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')
                ->join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')
                ->join('especialidades', 'especialidades.id', '=', 'especialistas.especialidade_id')
                ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
                ->join('users', 'users.id', 'pacientes.usuario_id')
                ->where('users.id', $paciente->usuario_id)
                ->where('status', '=', $statusConsulta)
                ->orWhere('status', '=', 'Cancelada')
                ->select(
                    'consultas.id',
                    'horario_agendado',
                    'especialistas.nome as nome_especialista',
                    'clinicas.nome as nome_clinica',
                    'especialidades.descricao as descricao_especialidade',
                    'status',
                    'consultas.especialista_id',
                    'consultas.clinica_id',
                    'pacientes.nome as nome_paciente'
                )
                ->orderBy('horario_agendado', 'desc')
                ->paginate(8);
        } elseif ($user->tipo_user == "R") {
            $consultas = Consulta::join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')
                ->join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')
                ->join('especialidades', 'especialidades.id', '=', 'especialistas.especialidade_id')
                ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
                ->join('users', 'users.id', 'pacientes.usuario_id')
                ->where('status', '=', $statusConsulta)
                ->orWhere('status', '=', 'Cancelada')
                ->select(
                    'consultas.id',
                    'horario_agendado',
                    'especialistas.nome as nome_especialista',
                    'clinicas.nome as nome_clinica',
                    'especialidades.descricao as descricao_especialidade',
                    'status',
                    'consultas.especialista_id',
                    'consultas.clinica_id',
                    'pacientes.nome as nome_paciente'
                )
                ->orderBy('horario_agendado', 'desc')
                ->paginate(8);
        }

        return view('userPaciente.historicoconsultas', ['consultas' => $consultas, 'msg' => $msg, 'filtro' => $filtro]);
    }

   function marcarconsulta($paciente_id = null)
   {
      if(isset($paciente_id)){
        //estou armazenando em uma sessao o id do paciente selecionado para ser usado no finalizar consulta
        // Armazena a variável na sessão
         session()->put('paciente_id', $paciente_id);
      }
      return view('userPaciente/marcarconsulta');
   }

    function marcarconsultaSelecionarPaciente()
    {
        $user = Auth::user();

        if ($user->tipo_user == "P") {
            $pacientes = Paciente::where('usuario_id', $user->id)->paginate(8);
        } elseif ($user->tipo_user = "R") {
            $pacientes = Paciente::paginate(8);
        }

        return view('userPaciente/marcarconsulta/marcarConsultaEscolherPaciente', ['pacientes' => $pacientes]);
    }

    function marcarConsultaViaEspecialidadePasso1()
    {
        //retonando a lista de especialidades
        $filter = "";
        if (isset($_GET['filtro'])) {
            $filter = $_GET['filtro'];
        }
        $lista = Especialidade::where('descricao', 'like', "%" . "%")->orderBy('descricao', 'asc')->paginate(8);
        return view('userPaciente/marcarConsultaViaEspecialidadePasso1', ['lista' => $lista, 'filtro' => $filter]);
    }

    function marcarConsultaViaEspecialidadePasso2($especialidade_id)
    {
        //retonando a lista de clinicas que possui a especialidade selecionada na opcao anterior
        $filter = "";
        if (isset($_GET['filtro'])) {
            $filter = $_GET['filtro'];
        }

        $clinicas = Especialidadeclinica::join('clinicas', 'clinicas.id', '=', 'especialidadeclinicas.clinica_id')
            ->join('consultas', 'consultas.clinica_id', 'clinicas.id')
            ->where('consultas.status', 'Disponível')
            ->where('especialidade_id', $especialidade_id)
            ->orderBy('nome', 'asc')
            ->select('clinicas.id', 'nome')
            ->groupBy('clinicas.id','nome')
            ->paginate(8);

        return view('userPaciente/marcarConsultaViaEspecialidadePasso2', ['clinicas' => $clinicas, 'filtro' => $filter, 'especialidade_id' => $especialidade_id]);
    }

    function marcarConsultaViaEspecialidadePasso3($especialidade_id, $clinica_id)
    {
        //retonando a lista de especialista que esta vinculado a clinica selecionada na opcao anterior
        $filter = "";
        if (isset($_GET['filtro'])) {
            $filter = $_GET['filtro'];
        }
        $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialistaclinicas.especialista_id')->
        where('clinica_id', $clinica_id)->where('especialidade_id', $especialidade_id)->
        orderBy('especialistas.nome', 'asc')->select('especialistas.id', 'especialistas.nome')->paginate(8);
        return view('userPaciente/marcarConsultaViaEspecialidadePasso3', ['lista' => $lista, 'clinica_id' => $clinica_id, 'especialidade_id' => $especialidade_id]);
    }

    function marcarConsultaViaEspecialidadePasso4($clinica_id, $especialista_id)
    {
        $especialista = Especialista::find($especialista_id);
        $clinica = Clinica::find($clinica_id);
        $especialidade = Especialidade::find($especialista->especialidade_id);

        $paciente_id = session()->get('paciente_id');
        // Verifica se a variável existe
        if ($paciente_id) {
            $paciente = Paciente::find($paciente_id);
        }else{
            $paciente = Paciente::where('usuario_id', '=', Auth::user()->id)->first();
        }

        //retornar todos a agenda(consutlas) do especialista vinculados a clinica
        $statusConsulta = "Disponível";
        $lista = Consulta::where('especialista_id', '=', $especialista_id)
            ->where('clinica_id', '=', $clinica_id)->
            where('status', '=', $statusConsulta)->
            select('consultas.id', 'horario_agendado', 'status')->orderBy('horario_agendado', 'asc')
            ->get();
        //dd($lista);
        return view('userPaciente/marcarConsultaViaEspecialidadePasso4', ['lista' => $lista, 'especialista' => $especialista, 'clinica' => $clinica, 'especialidade' => $especialidade, 'paciente' => $paciente]);
    }
    function marcarConsultaViaClinicaPasso1()
    {
        //retonando a lista de clinicas
        $filter = "";
        if (isset($_GET['filtro'])) {
            $filter = $_GET['filtro'];
        }

        $clinicas = Clinica::join('consultas', 'consultas.clinica_id', 'clinicas.id')
            ->where('ativo', '1')
            ->where('consultas.status', 'Disponível')
            ->orderBy('nome', 'asc')
            ->select('clinicas.id', 'nome')
            ->groupBy('clinicas.id','nome')
            ->paginate(8);

        return view('userPaciente/marcarConsultaViaClinicaPasso1', ['clinicas' => $clinicas, 'filtro' => $filter]);
    }

    function pesquisarclinicamarcarconsulta(Request $request)
    {
        $lista = Clinica::join('enderecos', 'enderecos.user_id', 'clinicas.usuario_id')
            ->where('clinicas.nome', 'like', "%" . $request->nome . "%")
            ->where('enderecos.cidade', 'like', "%" . $request->cidade . "%")
            ->where('enderecos.estado', 'like', "%" . $request->estado . "%")
            ->orderBy('clinicas.nome', 'asc')
            ->select('clinicas.id', 'nome')
            ->paginate(8);


        if ($lista->isEmpty()) {
            $msg = ['valor' => trans("Não foi encontrado nenhuma clínica com os dados informados!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }

        return back()->with('lista', $lista)->withInput();
    }

    function marcarConsultaViaClinicaPasso2($clinica_id)
    {
        //todas as especialidades que eh vinculado a clinica
        $lista = Especialidadeclinica::join('especialidades', 'especialidades.id', '=', 'especialidadeclinicas.especialidade_id')
            ->where('clinica_id', $clinica_id)
            ->orderBy('especialidades.descricao', 'asc')
            ->select('especialidades.id', 'especialidades.descricao')
            ->paginate(8);

        return view('userPaciente/marcarConsultaViaClinicaPasso2', ['lista' => $lista, 'clinica_id' => $clinica_id]);
    }

    function marcarConsultaViaClinicaPasso3($clinica_id, $especialidade_id)
    {
        //retornar todos os especialista vinculados a clinica e com a especiladade selecionada
        $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialistaclinicas.especialista_id')
            ->join('consultas', 'consultas.especialista_id', 'especialistas.id')
            ->where('especialistaclinicas.clinica_id', $clinica_id)
            ->where('especialidade_id', $especialidade_id)
            ->where('consultas.status', 'Disponível')
            ->orderBy('especialistas.nome', 'asc')
            ->select('especialistas.id', 'especialistas.nome')
            ->groupBy('id')
            ->paginate(8);

        return view('userPaciente/marcarConsultaViaClinicaPasso3', ['lista' => $lista, 'clinica_id' => $clinica_id]);
    }

    function marcarConsultaViaClinicaPasso4($clinica_id, $especialista_id)
    {
        $especialista = Especialista::find($especialista_id);
        $clinica = Clinica::find($clinica_id);
        $especialidade = Especialidade::find($especialista->especialidade_id);

        $paciente_id = session()->get('paciente_id');
        // Verifica se a variável existe
        if ($paciente_id) {
            $paciente = Paciente::find($paciente_id);
        }else{
            $paciente = Paciente::where('usuario_id', '=', Auth::user()->id)->first();
        }
        //retornar todos a agenda(consutlas) do especialista vinculados a clinica
        $statusConsulta = "Disponível";

        $lista = Consulta::where('especialista_id', '=', $especialista_id)
            ->where('clinica_id', '=', $clinica_id)
            ->where('status', '=', $statusConsulta)
            ->select('consultas.id', 'horario_agendado')
            ->orderBy('horario_agendado', 'asc')
            ->get();

        return view('userPaciente/marcarConsultaViaClinicaPasso4', ['lista' => $lista, 'especialista' => $especialista, 'clinica' => $clinica, 'especialidade' => $especialidade, 'paciente' => $paciente]);
    }

    function marcarConsultaViaClinicaFinalizar(Request $request)
    {
        $paciente_id = session()->get('paciente_id');
        session()->forget('paciente_id');
        // Verifica se a variável existe
        if ($paciente_id) {
            $paciente = Paciente::find($paciente_id);
        }else{
            $paciente = Paciente::where('usuario_id', '=', Auth::user()->id)->first();
        }

        $consulta = Consulta::find($request->consulta_id);
        $consulta->status = "Aguardando atendimento";
        $consulta->paciente_id = $paciente->id;
        $consulta->save();


        $anamnese = Anamnese::where('paciente_id', $paciente->id)->first();
        $clinica = Clinica::find($consulta->clinica_id);

        //VERIFICAR SE A CLINICA REQUER A ANAMNESE, SE SIM, VERIFIQUE SE AINDA NÃO FOI REALIZADA PELO PACIENTE
        if ($clinica->anamnese_obrigatoria == "S" && !isset($anamnese)) {
            $msg = ['valor' => trans("Consulta marcada com sucesso! Agora  realize com calma a anamnese."), 'tipo' => 'success'];
            session()->flash('msg', $msg);

            return redirect()->route('anamnese.create', ['paciente_id' => $paciente->id]);
        } else {
            $msg = ['valor' => trans("Consulta marcada com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);

            if (Auth::user()->tipo_user == "R") {
                return redirect()->route('paciente.marcarconsultaSelecionarPaciente');
            } else {
                return redirect()->route('paciente.minhasconsultas');
            }
        }
    }
    function home($msg = null)
   {
      $filtro = "";
      if (isset($_GET['filtro'])) {
         $filtro = $_GET['filtro'];
      }

      $paciente = Paciente::where('usuario_id', Auth::user()->id)->first();

      $statusConsulta = "Aguardando atendimento";
      $consultas = Consulta::join('especialistas', 'especialistas.id', 'consultas.especialista_id')
        ->join('clinicas', 'clinicas.id', 'consultas.clinica_id')
        ->join('especialidades', 'especialidades.id', 'especialistas.especialidade_id')
        ->join('pacientes', 'pacientes.id', 'consultas.paciente_id')
        ->where('pacientes.usuario_id', $paciente->usuario_id)->where('status', $statusConsulta)
        ->select(
            'consultas.id',
            'horario_agendado',
            'especialistas.nome as nome_especialista',
            'clinicas.nome as nome_clinica',
            'especialidades.descricao as descricao_especialidade',
            'pacientes.nome as nome_paciente',
        )
        ->orderBy('horario_agendado', 'asc')
        ->paginate(8);

      return view('userPaciente.home', ['consultas' => $consultas, 'filtro' => $filtro]);
   }
   
    public function cancelarConsulta(Request $request)
    {
        $consulta = Consulta::find($request->consulta_id);
        $consultaController = new ConsultaController();
        $userLogged = Auth::user();

        if (Helper::verificarPrazoCancelamentoGratuito($consulta->horario_agendado)) {
            $retornoConsultaCancelada = $consultaController->cancelarConsultaSemTaxa($request);
        } else {
            $cartao = Paciente::join('consultas', 'consultas.paciente_id', 'pacientes.id')
                ->join('users', 'users.id', 'pacientes.usuario_id')
                ->join('assinaturas', 'assinaturas.user_id', 'users.id')
                ->join('cartoes', 'cartoes.id', 'assinaturas.cartao_id')
                ->where('pacientes.id', $consulta->paciente_id)
                ->select('cartoes.*', 'assinaturas.id as assinatura_id')
                ->first();

            if ($cartao) {
                //CRIAR O CHECKOUT
                $checkout = Helper::createCheckouSumupTaxa();
                //PASSAR O ID DA CUNSULTA E MOTIVO DE CANCELAMENTO
                session()->put("consulta_id_$checkout->id", $consulta->id);
                session()->put("motivo_cancelamento_$checkout->id", $request->motivo_cancelamento);
                //CRIAR O PAGAMENTO
                $pagamento = Helper::createPagamento($cartao, $checkout);
                $pagamentoController = new PagamentoController();

                if (isset($pagamento->status) && $pagamento->status == "FAILED") {
                    $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('TAXA_CANCELAMENTO_CONSULTA'))), $pagamento->transactions[0]->transaction_code, 'Negado', 'Taxa de cancelamento da consulta');

                    return redirect()->route('callback.cancelamento.consulta', ['checkout_id' => $pagamento->id]);
                } elseif (isset($pagamento->status) && $pagamento->status == "PAID") {
                    $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('TAXA_CANCELAMENTO_CONSULTA'))), $pagamento->transactions[0]->transaction_code, 'Aprovado', 'Taxa de cancelamento da consulta');

                    return redirect()->route('callback.cancelamento.consulta', ['checkout_id' => $pagamento->id]);
                } elseif (isset($pagamento->next_step)) {
                    $pagamentoController->store($cartao->user_id, floatval(Helper::converterMonetario(env('TAXA_CANCELAMENTO_CONSULTA'))), $pagamento->next_step->current_transaction->transaction_code, 'Pendente', 'Taxa de cancelamento da consulta');

                    return redirect($pagamento->next_step->url);
                }
            } else {
                if (env('ASSINATURA_OBRIGATORIA')) {
                    $msg = ['valor' => trans("Nenhum cartão associado!"), 'tipo' => 'danger'];
                } else {
                    $consulta = Consulta::find($consulta->id);
                    $consulta->status="Cancelada";
                    $consulta->motivocancelamento = $request->motivo_cancelamento;
                    $consulta->id_usuario_cancelou = Auth::user()->id;
                    $consulta->save();

                    date_default_timezone_set('America/Sao_Paulo');
                    $dataConsultaCancelada = Carbon::parse($consulta->horario_agendado);
                    $dataAtual = Carbon::now();


                    if ($dataConsultaCancelada->gt($dataAtual)) {
                        $consultaNova = $consulta->replicate();
                        $consultaNova->status = "Disponível";
                        $consultaNova->paciente_id = null;
                        $consultaNova->save();
                    }

                    $msg = ['valor' => trans("Operação Realizada com sucesso!"), 'tipo' => 'success'];
                }
           }
        }
        session()->flash('msg', $msg);
            
        if ($userLogged->tipo_user == "E") {
            return redirect()->route('consulta.listconsultaporespecialista');
        } elseif ($userLogged->tipo_user == "P") {
            return redirect()->route('paciente.minhasconsultas');
        }
    }


 function prontuario($paciente_id){

    // dd($consulta_id);
    $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();

    $paciente = Paciente::find($paciente_id);
    $usuarioPaciente = User::find($paciente->usuario_id);
    $qtdConsultasRealizadas = Consulta::where('status', '=', 'Finalizada')->
        where('paciente_id', '=', $paciente_id)->
     //   where('especialista_id', '=', $especialista->id)->
        orderBy('horario_iniciado', 'asc')->count();

    $page_exames = 1;
    if(isset(request()->query()['page_exames'])){
        $page_exames = request()->query()['page_exames'];
    }
    //lista de pedidos de exames
    $listaPedidosExames = PedidoExame::join('exames', 'exames.id', '=', 'pedido_exames.exame_id')
    ->join('consultas', 'consultas.id', '=', 'pedido_exames.consulta_id')
    ->where('paciente_id',$paciente->id)
    ->orderBy('pedido_exames.created_at', 'desc')
    ->select('pedido_exames.id as id', 'nome','laudo', 'pedido_exames.created_at as data_pedido')
  //  ->paginate(5)
    ->paginate(5, ['*'], 'page_exames',$page_exames )
    ->setPageName('page_exames')
    ->appends(request()->query());
  //  ->appends(['page_exames' => request()->get('page_exames'),request()->query()])
   // ->setPageName('page_exames');

    // Criando novas instâncias do paginator com pageName desejado
    $listaPedidosExames = new \Illuminate\Pagination\LengthAwarePaginator(
        $listaPedidosExames->items(),
        $listaPedidosExames->total(),
        $listaPedidosExames->perPage(),
        request()->get('page_exames', $listaPedidosExames->currentPage()), // Pega a página atual para exames
        ['path' => request()->url(), 'pageName' => 'page_exames'] // Define o path e o pageName
    );


    $page_medicamentos = 1;
    if(isset(request()->query()['page_medicamentos'])){
        $page_medicamentos = request()->query()['page_medicamentos'];
    }
    //lista de pedidos de medicamentos
    $listaPedidosMedicamentos = PedidoMedicamento::
    join('medicamentos', 'medicamentos.id', '=', 'pedido_medicamentos.medicamento_id')
    ->join('consultas', 'consultas.id', '=', 'pedido_medicamentos.consulta_id')
    ->where('paciente_id',$paciente->id)
    ->orderBy('pedido_medicamentos.created_at', 'desc')
    ->select('pedido_medicamentos.id as id', 'nome_comercial','prescricao_indicada','pedido_medicamentos.created_at as data_pedido' )
   ->paginate(5, ['*'], 'page_medicamentos',$page_medicamentos )
    ->setPath(request()->url())->appends(request()->query())->setPageName('page_medicamentos');

    // Criando novas instâncias do paginator com pageName desejado
    $listaPedidosMedicamentos = new \Illuminate\Pagination\LengthAwarePaginator(
        $listaPedidosMedicamentos->items(),
        $listaPedidosMedicamentos->total(),
        $listaPedidosMedicamentos->perPage(),
        request()->get('page_medicamentos', $listaPedidosMedicamentos->currentPage()), // Pega a página atual para exames
        ['path' => request()->url(), 'pageName' => 'page_medicamentos'] // Define o path e o pageName
    );

    //na tabela de exames fazer a parte de arquivos feito pelo antony

    //  dd($listaPedidosExames);
    return view('userEspecialista.prontuario.prontuario', [
        'paciente' => $paciente,
        'usuarioPaciente' => $usuarioPaciente,
        'qtdConsultasRealizadas' => $qtdConsultasRealizadas,
        'listaPedidosExames' => $listaPedidosExames,
        'listaPedidosMedicamentos' =>  $listaPedidosMedicamentos,
    ]);

    }
}


