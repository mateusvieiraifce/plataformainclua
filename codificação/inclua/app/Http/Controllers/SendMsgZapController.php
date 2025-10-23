<?php

namespace App\Http\Controllers;

use App\Models\SendMsgZap;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SendMsgZapController extends Controller
{

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
