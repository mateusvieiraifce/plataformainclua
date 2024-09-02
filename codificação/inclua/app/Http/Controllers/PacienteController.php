<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Clinica;
use App\Models\Especialidadeclinica;
use App\Models\Especialistaclinica;
use App\Models\Consulta;
use App\Models\Especialista;
use App\Models\Especialidade;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $rules = [
            "nome" => "required|min:5",
            "data_nascimento" => "required",
            "sexo" => "required"
        ];
        $feedbacks = [
            "nome.required" => "O campo Nome é obrigatório.",
            "nome.min" => "O campo nome deve ter no mínomo 5 caracteres.",
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
            $paciente->save();

            $msg = ['valor' => trans("Cadastro do paciente realizado com sucesso!"), 'tipo' => 'success'];
            session()->flash('msg', $msg);
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Houve um erro ao realizar o cadastro do paciente. Tente novamente."), 'tipo' => 'danger'];
            session()->flash('msg', $msg);

            return back();
        }

        return redirect()->route('paciente.home');
    }

    public function createDadosUserPaciente($usuario_id)
    {
        return view('cadastro.paciente.form_dados', ['usuario_id' => $usuario_id]);
    }

    public function storeDadosUserPaciente(Request $request)
    {
        //REMOÇÃO DA MASCARA DO CELULAR E DOCUMENTO PARA COMPARAR COM O BD
        $request->request->set('celular', Helper::removerCaractereEspecial($request->celular));
        $request->request->set('cpf', Helper::removerCaractereEspecial($request->cpf));
        $rules = [
            "image" => "required",
            "cpf" => "required|unique:users,documento,{$request->usuario_id}",
            "nome" => "required|min:5",
            "celular" => "required|unique:users,celular,{$request->usuario_id}",
            "data_nascimento" => "required",
            "estado_civil" => "required",
            "sexo" => "required",
            'consentimento' => 'required',
        ];
        $feedbacks = [
            "image.required" => "O campo Imagem é obrigatório.",
            "cpf.required" => "O campo CPF é obrigatório.",
            "cpf.unique" => "Este CPF já foi utilizado.",
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


    function minhasconsultas($msg = null)
    {
        $filtro = "";
        if (isset($_GET['filtro'])) {
            $filtro = $_GET['filtro'];
        }
        $paciente = Paciente::where('usuario_id', '=', Auth::user()->id)->first();
        $statusConsulta = "Aguardando atendimento";
        $lista = Consulta::join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')->
        join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->
        join('especialidades', 'especialidades.id', '=', 'especialistas.especialidade_id')->
        where('paciente_id', '=', $paciente->id)->
        where('status', '=', $statusConsulta)->
        select(
            'consultas.id',
            'horario_agendado',
            'especialistas.nome as nome_especialista',
            'clinicas.nome as nome_clinica',
            'especialidades.descricao as descricao_especialidade'
         )->orderBy('horario_agendado', 'asc')->paginate(8);
      return view('userPaciente/minhasconsultas', ['lista' => $lista,  'msg' => $msg,'filtro' => $filtro]);
   }

    function historicoconsultas($msg = null)
    {
        $filtro = "";
        if (isset($_GET['filtro'])) {
            $filtro = $_GET['filtro'];
        }
        $paciente = Paciente::where('usuario_id', '=', Auth::user()->id)->first();
        $statusConsulta = "Finalizada";
        $lista = Consulta::join('especialistas', 'especialistas.id', '=', 'consultas.especialista_id')->
        join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->
        join('especialidades', 'especialidades.id', '=', 'especialistas.especialidade_id')->
        where('paciente_id', '=', $paciente->id)->
        where('status', '=', $statusConsulta)->
        orWhere('status', '=', 'Cancelada')->
        select(
            'consultas.id',
            'horario_agendado',
            'especialistas.nome as nome_especialista',
            'clinicas.nome as nome_clinica',
            'especialidades.descricao as descricao_especialidade',
            'status'
        )->orderBy('horario_agendado', 'desc')->paginate(8);
        return view('userPaciente/historicoconsultas', ['lista' => $lista, 'msg' => $msg, 'filtro' => $filtro]);
    }

   function marcarconsulta()
   {
      return view('userPaciente/marcarconsulta');
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
        $lista =  Especialidadeclinica::join('clinicas', 'clinicas.id', '=', 'especialidadeclinicas.clinica_id')
        ->where('especialidade_id', $especialidade_id)
        ->orderBy('nome', 'asc')
        ->select('clinicas.id', 'nome')->paginate(8);

     /*   Clinica::join('especialidadeclinicas', 'especialidadeclinicas.id', '=', 'clinica_id')
            ->where('especialidade_id', $especialidade_id)
            ->orderBy('nome', 'asc')
            ->select('clinicas.id', 'nome')->paginate(8);*/

       // dd($lista);
        return view('userPaciente/marcarConsultaViaEspecialidadePasso2', ['lista' => $lista, 'filtro' => $filter, 'especialidade_id' => $especialidade_id]);
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
        $paciente = Paciente::where('usuario_id', '=', Auth::user()->id)->first();

        //retornar todos a agenda(consutlas) do especialista vinculados a clinica
        $statusConsulta = "Disponível";
        $lista = Consulta::where('especialista_id', '=', $especialista_id)
            ->where('clinica_id', '=', $clinica_id)->
            where('status', '=', $statusConsulta)->
            select('consultas.id', 'horario_agendado', 'status')->orderBy('horario_agendado', 'asc')->paginate(8);
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
        $lista = Clinica::where('ativo', '1')->
        orderBy('nome', 'asc')
            ->select('clinicas.id', 'nome')->paginate(8);
        return view('userPaciente/marcarConsultaViaClinicaPasso1', ['lista' => $lista, 'filtro' => $filter]);
    }

    function pesquisarclinicamarcarconsulta()
    {
        //retonando a lista de clincias
        $filtro = "";
        if (isset($_GET['filtro'])) {
            $filtro = $_GET['filtro'];
        }
        $lista = Clinica::where('nome', 'like', "%" . $filtro . "%")
            ->orderBy('nome', 'asc')
            ->select('clinicas.id', 'nome')->paginate(8);
        $msg = null;
        if ($lista->isEmpty()) {
            $msg = ['valor' => trans("Não foi encontrado nenhuma clínica com o nome digitado!"), 'tipo' => 'primary'];
        }
        return view('userPaciente/marcarConsultaViaClinicaPasso1', ['lista' => $lista, 'filtro' => $filtro, 'msg' => $msg]);
    }

    function marcarConsultaViaClinicaPasso2($clinica_id)
    {
        //todas as especialidades que eh vinculado a clinica
        $lista = Especialidadeclinica::join('especialidades', 'especialidades.id', '=', 'especialidadeclinicas.especialidade_id')->where('clinica_id', $clinica_id)->orderBy('especialidades.descricao', 'asc')->select('especialidades.id', 'especialidades.descricao')->paginate(8);
        return view('userPaciente/marcarConsultaViaClinicaPasso2', ['lista' => $lista, 'clinica_id' => $clinica_id]);
    }

    function marcarConsultaViaClinicaPasso3($clinica_id, $especialidade_id)
    {
        //retornar todos os especialista vinculados a clinica e com a especiladade selecionada
        $lista = Especialistaclinica::join('especialistas', 'especialistas.id', '=', 'especialistaclinicas.especialista_id')->where('clinica_id', $clinica_id)->where('especialidade_id', $especialidade_id)->orderBy('especialistas.nome', 'asc')->select('especialistas.id', 'especialistas.nome')->paginate(8);
        return view('userPaciente/marcarConsultaViaClinicaPasso3', ['lista' => $lista, 'clinica_id' => $clinica_id]);
    }

    function marcarConsultaViaClinicaPasso4($clinica_id, $especialista_id)
    {
        $especialista = Especialista::find($especialista_id);
        $clinica = Clinica::find($clinica_id);
        $especialidade = Especialidade::find($especialista->especialidade_id);
        $paciente = Paciente::where('usuario_id', '=', Auth::user()->id)->first();

        //retornar todos a agenda(consutlas) do especialista vinculados a clinica
        $statusConsulta = "Disponível";

        $lista = Consulta::where('especialista_id', '=', $especialista_id)->where('clinica_id', '=', $clinica_id)->where('status', '=', $statusConsulta)->select('consultas.id', 'horario_agendado')->orderBy('horario_agendado', 'asc')->paginate(8);
      // dd($especialista,$lista);
        return view('userPaciente/marcarConsultaViaClinicaPasso4', ['lista' => $lista, 'especialista' => $especialista, 'clinica' => $clinica, 'especialidade' => $especialidade, 'paciente' => $paciente]);
    }


    function marcarConsultaViaClinicaFinalizar(Request $request)
    {
        $paciente =  Paciente::where('usuario_id', '=', Auth::user()->id)->first();

        $ent = Consulta::find($request->consulta_id);
        $ent->status = "Aguardando atendimento";
        $ent->paciente_id = $paciente->id;
        $ent->save();
        $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];

        return redirect()->route('anamnese.create');
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
        ->where('paciente_id', $paciente->id)->where('status', $statusConsulta)
        ->select(
            'consultas.id',
            'horario_agendado',
            'especialistas.nome as nome_especialista',
            'clinicas.nome as nome_clinica',
            'especialidades.descricao as descricao_especialidade'
        )
        ->orderBy('horario_agendado', 'asc')
        ->take(3)
        ->get();

      return view('userPaciente.home', ['consultas' => $consultas, 'filtro' => $filtro]);
   }

   function cancelarConsulta(Request $request)
   {
    //ver a questao financeira
    $consultaCancelada = Consulta::find($request->consulta_idM);

    $consultaNova = $consultaCancelada->replicate();
    $consultaNova->status="Disponível";
    $consultaNova->paciente_id = null;
    $consultaNova->save();

    $consultaCancelada->status="Cancelada";
    $consultaCancelada->motivocancelamento= $request->motivocancelamento;
    $consultaCancelada->save();
    $msg = ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success'];
    return  $this->minhasconsultas($msg);
   }
}


