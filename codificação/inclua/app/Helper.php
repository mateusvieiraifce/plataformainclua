<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use PHPMailer\PHPMailer\PHPMailer;

class Helper
{

    public static function sendSms($phone, $msg){
        error_log('aqui');
        $mensagem = urlencode(mb_convert_encoding($msg, "UTF-8", mb_detect_encoding($msg)));
        $url_api = "https://api.iagentesms.com.br/webservices/http.php?metodo=envio&usuario=mentrixmax@gmail.com&senha=Windows2000@&celular={$phone}&mensagem={$mensagem}";
        error_log($url_api);
        $response = Http::get($url_api);
        error_log($response);
    }

    public static function generateRandomNumberString($length) {
        $characters = '0123456789';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }

    public static function removerCaractereEspecial($string)
    {
        $string = preg_replace('/\W/', '', $string);
        return trim($string);
    }

    public static function removeMascaraCep($cep)
    {
        $cep = preg_replace('/\W/', '', $cep);
        return trim($cep);

    }

    public  static function sendEmail($assunto, $text, $emissor, $name=null)
    {

        $mail = new PHPMailer();
        $mail->addCustomHeader('MIME-Version', '1.0');
        $mail->addCustomHeader('X-Mailer', 'PHP/' . phpversion());
        $mail->addCustomHeader('X-Priority', '1');
        $mail->addCustomHeader('List-Unsubscribe', '<mailto:atendimento@plataformainclua.com>');

        $mail->ContentType = 'text/html; charset=utf-8\r\n';
        $mail->IsSMTP();
        $mail->Host = env('MAIL_HOST_TITAN');
        $mail->Subject = $assunto;
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME_TITAN');
        $mail->Password = env('MAIL_PASSWORD_TITAN');
        $mail->SMTPSecure = 'ssl';
        $mail->IsHTML(true);
        $mail->CharSet = 'utf-8';
        $mail->SetFrom(env('MAIL_USERNAME_TITAN'), env("MAIL_OWNER"), 0);
        $mail->AddAddress($emissor);
       # $msga = "O Cliente: " . $req->email . ", enviou a seguinte msg: <br/> " . $req->msg;


        //$email = new \SendGrid\Mail\Mail();
        //$email->setFrom(env("MAIL_SAND"), env("MAIL_OWNER"));
        //$email->setSubject($assunto);
        //$email->addTo($emissor, $name);
      /*  $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );*/
    //    $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));

        $imagePath = public_path('assets/img/logo-01.png');
        $mail->addEmbeddedImage($imagePath, 'logo', 'logo.png');

        $imagem_topo = '<img src="'.env('URL').'assets/img/logo-01.png" alt="topo" border="0" style="max-width:800px; max-height:150px; width: auto;
    height: auto;"/> <br/>';

        //dd($imagem_topo);
        $rodape = '</p> <br />
				<font style="display:block; text-align: center; margin: 30px auto 0 auto; position: relative" color"#000000">
                    Esta mensagem foi enviada de um endereço de e-mail que apenas envia mensagens.<br>
                    Para obter mais informações sobre sua conta, acesse nosso site.
                    <br /><br />
                    &copy; ' . date('Y') . ' Todos os direitos reservados Plataforma Inclua
                </font><br />
                ';

        $msga=$imagem_topo;
        $msga = $text;
        //$msga = $msga. $rodape;
        //$mail->msgHTML($msga);
        //$mail->Port = 465;
        //  $mail->SMTPDebug  = 1;
        //$msg = $mail->Send();
        //$email->addContent(
       //     "text/html", $msga
       // );

        $topo='<p><img src="cid:logo" alt="Company Logo"  style="max-width:800px; max-height:150px; width: auto;"></p>';
        $msga=$topo.$msga.$rodape;
        $mail->msgHTML($msga);

        $mail->AltBody = $msga;

        $mail->Port = 465;
        $mail->SMTPDebug  = 0;


        try {
           // $response = $sendgrid->send($email);
            $msg = $mail->Send();
            //print $response->statusCode();
           // dd($response->statusCode() );
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

    public  static function sendEmailSite($assunto, $text, $emissor, $name=null)
    {

        $email = new \SendGrid\Mail\Mail();
        $email->setFrom(env("MAIL_SAND"), env("MAIL_OWNER"));
        $email->setSubject($assunto);
        $email->addTo($emissor, $name);
        /*  $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
          $email->addContent(
              "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
          );*/
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY_2'));



        $imagem_topo = '<img src="'.env('URL').'assets/img/logo-01.png" alt="topo" border="0" style="max-width:800px; max-height:150px; width: auto;
    height: auto;"/> <br/>';

        //dd($imagem_topo);
        $rodape = '</p> <br />
				<font style="display:block; text-align: center; margin: 30px auto 0 auto; position: relative" color"#000000">
                    Esta mensagem foi enviada de um endereço de e-mail que apenas envia mensagens.<br>
                    Para obter mais informações sobre sua conta, envie e-mail para: '.env("EMAIL_ADMIN").'
                    <br /><br />
                    &copy; ' . date('Y') . ' Todos os direitos reservados Plataforma Inclua
                </font><br />
                ';

        $msga=$imagem_topo;
        $msga =$msga . $text;
        $msga = $msga. $rodape;
        //$mail->msgHTML($msga);
        //$mail->Port = 465;
        //  $mail->SMTPDebug  = 1;
        //$msg = $mail->Send();
        $email->addContent(
            "text/html", $msga
        );
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode();
            // dd($response->statusCode() );
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
        $email->addTo(env('MAIL_SAND'), "Example User");
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            dd($response->statusCode());
           /* print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";*/
        } catch (Exception $e) {
           dd($e->getMessage() );
            //echo 'Caught exception: '. ."\n";
        }
        return "Ok";
    }
    public static function mascaraCelular($fone)
    {
        // Remove qualquer caractere que não seja número
        $telefone = preg_replace('/[^0-9]/', '', $fone);

        // Aplica a máscara
        return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $telefone);
    }

    public static function mascaraTelefone($telefone)
    {
        // Remove qualquer caractere que não seja número
        $telefone = preg_replace('/[^0-9]/', '', $telefone);

        // Aplica a máscara
        return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $telefone);
    }

    public static function mascaraCPF($cpf)
    {
        // Remove qualquer caractere que não seja número
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Aplica a máscara
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    public static function mascaraCNPJ($cnpj)
    {
        // Remove qualquer caractere que não seja número
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Aplica a máscara
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
    }

    public static function mascaraDocumento($documento)
    {
        $size = strlen($documento);

        if ($size == 11) {
            $documento = Helper::mascaraCPF($documento);
        } else if ($size == 14) {
            $documento = Helper::mascaraCnpj($documento);
        }

        return $documento;
    }

    public static function mascaraCEP($cep)
    {
        // Remove qualquer caractere que não seja número
        $cep = preg_replace('/[^0-9]/', '', $cep);

        // Aplica a máscara
        return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $cep);
    }

    public static function pagamentoMercadoPago($descricao,$qnt,$preco,$ref)
    {
        try {
            $token = env('MERCADOPAGO_ACCESS_TOKEN');
            $dadosPagamento = [
                'items' =>
                    [[
                        'description'=>$descricao,
                        'title' => 'DNA ASSESSMENTS',
                        'quantity' => $qnt,
                        'currency_id' => 'BRL',
                        'unit_price' => $preco, // Preço do produto
                    ]],
                'external_reference'=>$ref,

            ];

            // Requisição para o Mercado Pago
            $response = Http::withToken($token)->post('https://api.mercadopago.com/checkout/preferences', $dadosPagamento);


            $data = json_decode($response->getBody(), true);

            //dd($data);
            //$linkDePagamento = $response['sandbox_init_point']; // Link de pagamento
            return $data;


        } catch (Exception $e) {
            // Lidar com erros da API do MercadoPago
            return redirect()->route('subscription.index')->with('error', 'Erro ao buscar os planos: ' . $e->getMessage());
        }
    }

    //Função para adicionar meses a uma determinada data
    public static function addMonthsToDate($date, $months)
    {
        $nextdate = strtotime("{$date} + {$months} months");
        return date('Y-m-d', $nextdate);
    }

    public static function createCheckoutSumup($renovacao = false)
    {
        $route = ($renovacao) ? route('callback.payment.assinatura.renovar') : route('callback.payment.assinatura');

        //CODIGO CREATE CHECKOUT
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sumup.com/v0.1/checkouts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "checkout_reference": "Assinatura '.Helper::generateRandomNumberString(5).'",
                "amount": '.floatval(Helper::converterMonetario(env('PRECO_ASSINATURA'))).',
                "currency": "BRL",
                "pay_to_email": "'.env('EMAIL_TO_PAY').'",
                "description": "Plataforma Inclua - Assinatura",
                "redirect_url": "'. $route .'"
            }',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'Authorization: Bearer '.env("SAMUP_KEY")
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return $response;
    }

    public static function createPagamento($cartao, $checkout)
    {
        //PAGAMENTO PADRÃO
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sumup.com/v0.1/checkouts/'.$checkout->id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => '{
                "payment_type": "card",
                "card": {
                    "name": "'.$cartao->nome_titular.'",
                    "number": "'.Crypt::decrypt($cartao->numero_cartao).'",
                    "expiry_month": "'.$cartao->mes_validade.'",
                    "expiry_year": "'.$cartao->ano_validade.'",
                    "cvv": "'.Crypt::decrypt($cartao->codigo_seguranca).'"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'Authorization: Bearer '.env("SAMUP_KEY")
            ),
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return $response;
    }

    public static function getCheckout($checkout_id)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sumup.com/v0.1/checkouts/'.$checkout_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'Authorization: Bearer '.env("SAMUP_KEY")
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return $response;
    }

    public static function teste($url)
    {
        $response = Http::get($url);

        return $response;
    }

    public static function converterMonetario($input)
    {
        $output = strlen(trim($input)) == 0 ? 0 : $input;
        $output = str_replace(".", ".", $output);
        $output = str_replace(",", ".", $output);
        return (float) $output;
    }

    public static function descryptNumberCard($numeroCartao)
    {
        $numero = Crypt::decrypt($numeroCartao);
        $numero = Helper::encodeNumberCard($numero);
        return $numero;
    }

    public static function encodeNumberCard($numeroCartao)
    {
        $numeroCartao = preg_replace('/(\d{4})(\d{4})(\d{4})(\d{4})/', '**** **** **** $4', $numeroCartao);

        return $numeroCartao;
    }

    public static function verificarPrazoCancelamentoGratuito($dataConsulta)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataConsulta = Carbon::parse($dataConsulta);
        $now = Carbon::now();

        $diferencaMinutos = $now->diffInMinutes($dataConsulta);
        $diferencaHoras = $diferencaMinutos / 60;

        if ($now <= $dataConsulta && $diferencaHoras >= env('PRAZO_CANCELAMENTO_GRATUITO')) {
            return true;
        }

        return false;
    }

    public static function createCheckouSumupTaxa()
    {
        //CODIGO CREATE CHECKOUT
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sumup.com/v0.1/checkouts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "checkout_reference": "Taxa '.Helper::generateRandomNumberString(5).'",
                "amount": '.floatval(Helper::converterMonetario(env('TAXA_CANCELAMENTO_CONSULTA'))).',
                "currency": "BRL",
                "pay_to_email": "'.env('EMAIL_TO_PAY').'",
                "description": "Plataforma Inclua - Taxa de cancelamento da consulta",
                "redirect_url": "'. route('callback.cancelamento.consulta') .'"
            }',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'Authorization: Bearer '.env("SAMUP_KEY")
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return $response;
    }

    public static function createCheckoutSumupConsulta($valorConsulta)
    {
        //CODIGO CREATE CHECKOUT
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.sumup.com/v0.1/checkouts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "checkout_reference": "Pagamento Consulta '.Helper::generateRandomNumberString(5).'",
                "amount": '.floatval(Helper::converterMonetario($valorConsulta)).',
                "currency": "BRL",
                "pay_to_email": "'.env('EMAIL_TO_PAY').'",
                "description": "Plataforma Inclua - Pagamento Consulta",
                "redirect_url": "'. route('callback.pagamento.consulta') .'"
            }',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'content-type: application/json',
                'Authorization: Bearer '.env("SAMUP_KEY")
            ),
        ));
        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);

        return $response;
    }
}
