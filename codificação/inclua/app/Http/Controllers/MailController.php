<?php

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class MailController extends Controller
{
    function sendMail(Request $req){

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host="smtp.gmail.com";
        $mail->Subject = 'Contato pelo site: ';
        $mail->SMTPAuth =true;
        $mail->Username='ecomodasobral@gmail.com';
        $mail->Password='ylzatowvawrekvxb';
        $mail->SMTPSecure='ssl';
        $mail->IsHTML(true);
        $mail->CharSet='utf-8';
        $mail->SetFrom($req->email,"cliente",0);
        $mail->AddAddress('ecomodasobral@gmail.com');
        $msga = "O Cliente: ".$req->email.", enviou a seguinte msg: <br/> ".$req->msg;
        $mail->msgHTML($msga);
        $mail->Port = 465;
      //  $mail->SMTPDebug  = 1;
        $msg = $mail->Send();
        $msgret = ['valor'=>"Operação realizada com sucesso!)",'tipo'=>'success'];
        return view("frente/contato",['msg'=>$msgret]);
    }

    function sendMenssagem(){
        return Helper::enviarEmailSand();
    }
}
