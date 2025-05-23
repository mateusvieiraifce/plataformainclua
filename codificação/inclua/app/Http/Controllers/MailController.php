<?php

namespace App\Http\Controllers;

use App\Helper;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\Clinica;
use Illuminate\Support\Facades\Auth;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class MailController extends Controller
{
    function sendMail(Request $req)
    {

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->Subject = 'Contato pelo site: ';
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = 'ssl';
        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->SetFrom(env('MAIL_USERNAME'));
        $mail->AddAddress('mateus.vieira@ifce.edu.br');
        $msga = "O Cliente: " . $req->email . ", enviou a seguinte msg: <br/> " . $req->msg;
        $mail->msgHTML($msga);
        $mail->Port = 465;
        $mail->SMTPDebug  = 1;
       // $msg = $mail->Send();
        $msgret = ['valor' => "Operação realizada com sucesso!)", 'tipo' => 'success'];
        Helper::sendEmail("testes","teste","mateus.vieira@ifce.edu.br","Mateus");
        return "Ok";
    }

    function sendMenssagem()
    {
        return Helper::enviarEmailSand();
    }

    function sendEmailBack(Request $req)
    {
        $validated = $req->validate([
            'g-recaptcha-response' => 'required', // Validação do reCAPTCHA
        ], [
            'g-recaptcha-response.required' => 'Preencha o recaptcha', // Mensagem personalizada
        ]);

        $host = $req->getHost();

        if ( $host == "plataformainclua.com"|| $host == "app.plataformainclua.com") {
            $email = $req->email;
            $nome = $req->name;
            $tel = $req->phone;
            // $msg = $req->msg;
            $texto = " O Cliente: " . $nome . " Tel:" . $tel . " Email: " . $email . " \n Sugeriu: " . $req->message;
            Helper::sendEmailSite("Contato pelo site", $texto, "atendimento@plataformainclua.com", $nome);
            return view('msg.msg', ['msg_compra' => 'Menssagem enviada com sucessos!']);
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Acesso Negado'
            );
            echo json_encode($response);

        }
    }

    function enviarConviteEspecialista(Request $request)
    {
        $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();

        $assunto = "Convite para participar da Plataforma Inclua";
        $texto = " Prezado(a) ".$request->nome.", <br>
          É com grande entusiasmo que a clínica ".$clinica->nome." o(a) convida a se unir à Plataforma Inclua,
          uma rede inovadora e inclusiva de clínicas dedicadas a promover a acessibilidade
          e a qualidade nos serviços de saúde.  <br>
          <br>
          ".env('APP_URL')."
           <br>
           Nossa equipe estará à disposição para fornecer mais informações
           e ajudá-lo(a) a integrar-se à nossa rede de forma eficiente.

          ";

        $emissor = $request->email_destino;//email do destino
        $name="";

       // dd($texto);
        Helper::sendEmail($assunto, $texto,  $emissor, $name);

        $msg = ['valor' => trans("Convite enviado com sucesso!"), 'tipo' => 'success'];
        $especialistaclinicaController = new EspecialistaclinicaController();
        return $especialistaclinicaController->list($msg);


    }
}
