<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\Consulta;
use App\Models\Especialista;
use App\Models\Paciente;
use App\Models\SendMsgZap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SendMsgZapController extends Controller
{


    public function notificationDay(Request $request){
        $inicioDia = Carbon::now()->startOfDay();
        $finDia = Carbon::now()->endOfDay();
        $allConsultsAgenda = Consulta::whereNotNull(["horario_agendado","paciente_id"])->whereNull("id_usuario_cancelou")
            ->where("horario_agendado",">=", $inicioDia)->wherewhere("horario_agendado","<=", $finDia)->get();

        foreach ($allConsultsAgenda as $consulta) {
            $paciente = Paciente::find($consulta->paciente_id);
            $especialista = Especialista::find($consulta->especialista_id);
            $celularPaciente = $paciente->user->celular;
            $celularEspecialista = $especialista->user->celular;

            $clinica = Clinica::find($consulta->clinica_id);

            $local = " na clínica:". $clinica->nome;
            if ($consulta->remota){
                $local = "Remota";
            }
            $agora = Carbon::parse($consulta->horario_agendado);

            $msgZAPEspe = new SendMsgZap();
            $msgZAPEspe->msg = "Hoje você tem consulta com o  " . $paciente->nome . ", no : " . $agora->format('d/m/Y H:i') . $local;
            $msgZAPEspe->phone = "55" . $celularEspecialista;
            $msgZAPEspe->instance = "mateus";
            $msgZAPEspe->enviado = false;
            $msgZAPEspe->save();

            $msgZAPPaciente = new SendMsgZap();
            $msgZAPPaciente->msg = "Hoje você tem consulta com especialista: " . $especialista->nome . ", Agendada para : " . $agora->format('d/m/Y H:i') . $local;
            $msgZAPPaciente->phone = "55" . $celularPaciente;
            $msgZAPPaciente->instance = "mateus";
            $msgZAPPaciente->enviado = false;
            $msgZAPPaciente->save();
        }

        response()->json([
            'message' => 'Operaçao realizada com sucesso!'
        ], Response::HTTP_OK);

    }

    public function getAllMsg(Request $request)
    {
        try {
            $allMsg = SendMsgZap::where("enviado", false)->get();
            return $allMsg;
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'API EXCEPTION',
                'message' => 'HA Algum problema no banco de dados!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function updateMsg($id=null)
    {
        try {
            $allMsg = SendMsgZap::where("id","=",$id)->first();
            if ($allMsg==null){
                response()->json([
                    'message' => 'Msg Não Encontrada!'
                ], Response::HTTP_NOT_FOUND);
            }
            $allMsg->enviado = true;
            $allMsg->save();
            response()->json([
                'message' => 'Operaçao realizada com sucesso!'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'API EXCEPTION',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    //
}
