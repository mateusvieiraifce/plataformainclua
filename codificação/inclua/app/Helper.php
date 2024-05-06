<?php

namespace App;
use PHPMailer\PHPMailer\PHPMailer;

class Helper
{
    public static function removeMascFone($fone)
    {
        if ($fone) {
            $cep = str_replace("-", "", $fone);
            $cep = str_replace("(", "", $cep);
            $cep = str_replace(")", "", $cep);
            $cep = str_replace(".", "", $cep);
            $cep = str_replace(" ", "", $cep);
            return trim($cep);
        }
        return "";
    }

    public  static function sendEmail($assunto, $text, $emissor, $name=null)
    {

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("admin@ecomoda.sobralstartups.com", "Ecomoda");
        $email->setSubject($assunto);
        $email->addTo($emissor, $name);
      /*  $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );*/
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));


        /*$mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->Subject = $assunto;
        $mail->SMTPAuth = true;
        $mail->Username = 'ecomodasobral@gmail.com';
        $mail->Password = 'ylzatowvawrekvxb';
        $mail->SMTPSecure = 'ssl';
        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->SetFrom('ecomodasobral@gmail.com', "Ecomoda", 0);
        $mail->AddAddress($emissor);*/

        $imagem_topo = '<img src="'.env('URL').'assets/img/logo-01.png" alt="topo" border="0" style="max-width:800px; max-height:150px; width: auto;
    height: auto;"/> <br/>';

        //dd($imagem_topo);
        $rodape = '</p> <br />
				<font style="display:block; text-align: center; margin: 30px auto 0 auto; position: relative" color"#000000">
                    Esta mensagem foi enviada de um endereço de e-mail que apenas envia mensagens.<br>
                    Para obter mais informações sobre sua conta, envie e-mail para: '.env("EMAIL_ADMIN").'
                    <br /><br />
                    &copy; ' . date('Y') . ' Todos os direitos reservados Ecomoda
                </font><br />
                ';

        $msga=$imagem_topo;
        $msga =$msga . $text;
        $msga = $msga. $rodape;
        //$mail->msgHTML($msga);
        //$mail->Port = 465;
        //$mail->SMTPDebug  = 1;
        //$msg = $mail->Send();
        $email->addContent(
            "text/html", $msga
        );
        try {
            $response = $sendgrid->send($email);
          /*   print $response->statusCode() . "\n";
             print_r($response->headers());
             print $response->body() . "\n";
            print('enviou o email');
            dd('aqui');*/
        }
        catch (Exception $e) {
            dd($e->getMessage() );
        }
    }

    public static function padronizaMonetario($input)
    {
        return number_format($input, 2, ',', '.');
    }

    public static function parseTextDouble($input)
    {
        $output = strlen(trim($input)) == 0 ? 0 : $input;
        $output = str_replace(".", "", $output);
        $output = str_replace(",", ".", $output);
        return (float) $output;
    }


    public static function enviarEmailSand(){
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("admin@ecomoda.sobralstartups.com", "Example User");
        $email->setSubject("Sending with SendGrid is Fun");
        $email->addTo("mateus.vieira@ifce.edu.br", "Example User");
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
           /* print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";*/
        } catch (Exception $e) {
           dd($e->getMessage() );
            //echo 'Caught exception: '. ."\n";
        }
        return "Ok";
    }
}
