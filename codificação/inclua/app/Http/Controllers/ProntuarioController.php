<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\PedidoExame;
use App\Models\PedidoMedicamento;
use App\Models\Prontuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProntuarioController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'dados_consulta' => 'required'
        ];
        $feedbacks = [
            'dados_consulta.required' => "Este campo é obrigatório."
        ];
        $request->validate($rules, $feedbacks);

        try {
            DB::beginTransaction();
            $prontuario = Prontuario::where("consulta_id", $request->consulta_id)->first();
            
            if (!$prontuario) {
                $prontuario = new Prontuario();
            }
            $prontuario->consulta_id = $request->consulta_id;
            $prontuario->dados_consulta = $request->dados_consulta;
            $prontuario->save();
            
            $msg = ['valor' => trans("Dados salvos com sucesso!"), 'tipo' => 'success'];
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();

            $msg = ['valor' => trans("Não foi possivel salvar os dados, tente novamente!"), 'tipo' => 'danger'];
        }
        session()->flash('msg', $msg);
        
        return redirect()->route('especialista.iniciarAtendimento', ["consulta_id" => $request->consulta_id, "aba" => "prontuarioatual"]);
    }

    public function filter(Request $request)
    {
        $consulta = Consulta::find($request->consulta_id);
        $paciente = Paciente::find($consulta->paciente_id);

        $prontuarioCompleto = Consulta::join('especialistas', 'especialistas.id', 'consultas.especialista_id')
            ->join('especialidades', 'especialidades.id', 'especialistas.especialidade_id')
            ->join('prontuarios', 'prontuarios.consulta_id', 'consultas.id')
            ->where('consultas.paciente_id', $paciente->id)
            ->where('especialidades.id', $request->especialidade_id)
            ->where('consultas.status', 'Finalizada')
            ->select(
                'consultas.id', 'consultas.horario_finalizado', 'especialistas.nome as especialista',
                'especialidades.descricao as especialidade', 'prontuarios.dados_consulta as prontuario'
            )
            ->orderBy('consultas.horario_finalizado', 'DESC')
            ->paginate(4,['*'], 'page_prontuario');

        foreach ($prontuarioCompleto as $prontuario) {
            $prontuario->pedido_medicamentos = PedidoMedicamento::join('consultas', 'consultas.id', 'pedido_medicamentos.consulta_id')
                ->join('medicamentos', 'medicamentos.id', 'pedido_medicamentos.medicamento_id')
                ->where('consultas.id', $prontuario->id)
                ->select('medicamentos.nome_comercial', 'pedido_medicamentos.prescricao_indicada')
                ->get();

            $prontuario->pedido_exames = PedidoExame::join('consultas', 'consultas.id', 'pedido_exames.consulta_id')
                ->join('exames', 'exames.id', 'pedido_exames.exame_id')
                ->where('consultas.id', $prontuario->id)
                ->select('exames.nome')
                ->get();
        }

        return back()->with('prontuarioCompleto', $prontuarioCompleto);
    }
}
