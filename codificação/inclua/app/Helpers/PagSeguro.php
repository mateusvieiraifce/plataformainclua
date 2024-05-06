<?php

namespace App\Helpers;

class PagSeguro
{

    private $email = "";

    private $sandbox = false;

    private $token;
    private $url;
    private $url_redirect;
    private $url_notificacao;
    private $url_transactions;
    private $url_lightbox;

    private $email_token = ''; //NÃO MODIFICAR
    private $statusCode = array(
        0 => 'Pendente',
        1 => 'Aguardando pagamento',
        2 => 'Em análise',
        3 => 'Pago',
        4 => 'Disponível',
        5 => 'Em disputa',
        6 => 'Devolvida',
        7 => 'Cancelada'
    );
    private $paymentMethod = array(
        0 => 'Pendente',
        1 => 'Cartão de crédito',
        2 => 'Boleto',
        3 => 'Débito online (TEF)',
        4 => 'Saldo PagSeguro',
        5 => 'Oi Paggo',
        6 => 'Depósito em conta'
    );

    public function __construct()
    {
        // SETAR VALOR true PARA TESTAR NA SANDBOX
        $this->sandbox = false;
        $this->email = env('PAGSEGURO_EMAIL');

        if ($this->sandbox === false) {
            //URL OFICIAL
            $this->token = env('PAGSEGURO_TOKEN_PRODUCAO');
            $this->url              = 'https://ws.pagseguro.uol.com.br/v2/checkout/';
            $this->url_redirect     = 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code=';
            $this->url_notificacao  = 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/';
            $this->url_transactions = 'https://ws.pagseguro.uol.com.br/v2/transactions/';
            $this->url_lightbox     = 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';
        } else {
            //URL SANDBOX
            $this->token = env('PAGSEGURO_TOKEN_TEST');
            $this->url              = 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout/';
            $this->url_redirect     = 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=';
            $this->url_notificacao  = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/notifications/';
            $this->url_transactions = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/';
            $this->url_lightbox     = 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';
        }

        $this->email_token = "?email=" . $this->email . "&token=" . $this->token;
        $this->url .= $this->email_token;
    }

    private function generateUrl($dados, $retorno)
    {
        //Configurações
        $data['email'] = $this->email;
        $data['token'] = $this->token;
        $data['currency'] = 'BRL';

        //Itens
        $data['itemId1'] = '0001';
        $data['itemDescription1'] = $dados['descricao'];
        $data['itemAmount1'] = number_format($dados['valor'], 2, ".", "");
        $data['itemQuantity1'] = $dados['quantidade'] ?? 1;

        //$data['itemShippingCost1'] = '00.00';

        //Dados do pedido
        $data['reference'] = $dados['codigo'];

        //Dados do comprador

        //Tratar telefone
        if (!empty($dados['telefone'])) {
            $telefone = str_replace('(', '', $dados['telefone']);
            $telefone = str_replace(')', '', $telefone);
            $telefone = str_replace('-', '', $telefone);
            $telefone = str_replace(' ', '', $telefone);
            $ddd = substr($telefone, 0, 2);
            $tamanho = strlen($telefone);
            $corte = ($tamanho - 2) * (-1);
            $telefone = substr($telefone, $corte);
        } else {
            $telefone = '31127000';
            $ddd = '88';
        }

          //Tratar CEP
        if (!empty($dados['cep'])) {
            $cep = implode('', explode('-', $dados['cep']));
            $cep = implode('', explode('.', $cep));
        } else {
            $cep = '62100000';
        }


        $data['senderName'] = $dados['nome'];
        $data['senderAreaCode'] = $ddd;
        $data['senderPhone'] = $telefone;
        if ($this->sandbox === false) {
            $data['senderEmail'] = $dados['email'];
        } else {
            $data['senderEmail'] = 'mateus.vieira@ifce.edu.br';
        }
        //		$data['shippingType'] = '3'; // 1: Encomenda normal (PAC)  -  2: SEDEX  -  3: Tipo de frete não especificado
        //		$data['shippingAddressStreet'] = $dados['rua'];
        //		$data['shippingAddressNumber'] = $dados['numero'];
        //		$data['shippingAddressComplement'] = ' ';
        //		$data['shippingAddressDistrict'] = $dados['bairro'];
        //		$data['shippingAddressPostalCode'] = $cep;
        //		$data['shippingAddressCity'] = $dados['cidade'];
        //		$data['shippingAddressState'] = strtoupper($dados['estado']);
        //		$data['shippingAddressCountry'] = 'BRA';
        $data['redirectURL'] = $retorno;
        $data['installmentQuantity'] = 1;
        //dd($data);
        return http_build_query($data);
    }

    public function executeCheckout($dados, $retorno, $lightBox = false, $devolver_link = false)
    {
        if ($dados['transaction_id'] != '' && $dados['transaction_id'] != null) {
            header('Location: ' . $this->url_redirect . $dados['transaction_id']);
        } else {
            $reference = $dados['codigo'];
            $dados = $this->generateUrl($dados, $retorno);

            $curl = curl_init($this->url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded; charset=UTF-8'));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);
            $xml = curl_exec($curl);

            if ($xml == 'Unauthorized') {
                //Insira seu código de prevenção a erros
                echo 'Erro: Dados invalidos - Unauthorized';
                exit; //Mantenha essa linha
            }

            curl_close($curl);
            $xml_obj = simplexml_load_string($xml);
            if (count($xml_obj->error) > 0) {
                $erro = $xml_obj->error;
                echo "Erro: " . $this->erroPS($erro->code);
                exit;
            }
            if ($lightBox === false) {
                $link_de_pagamento = $this->url_redirect . $xml_obj->code;

                if ($devolver_link) {
                    return $link_de_pagamento;
                }

                header("Location: {$link_de_pagamento}");
            } else {
                //Lightbox
                $javascript = '<script type="text/javascript" src="' . $this->url_lightbox . '"></script>
                <script type="text/javascript">
                    var callback = {
                        success : function(transactionCode){window.location.href="' . SUCESSO_LIGHTBOX . $reference . '"},
                        abort : function(){window.location.href="' . ERRO_LIGHTBOX . $reference . '"}
                    };';

                //Chamada do lightbox passando o código de checkout e os comandos para o callback
                $javascript .= "var isOpenLightbox = PagSeguroLightbox('{$xml_obj->code}', callback);";

                // Redireciona o comprador, caso o navegador não tenha suporte ao Lightbox
                $javascript .= 'if (!isOpenLightbox) location.href="' . $this->url_redirect . $xml_obj->code . '";
                </script>';

                echo $javascript;
            }
        }
    }

    /** RECEBE UMA NOTIFICAÇÃO DO PAGSEGURO
     *
     * @param type $POST
     * @return :
     *      [date] => 2019-08-22T14:34:27.000-03:00
    [code] => 3F62DA34-4C4F-4A85-89AF-B82B643F4A5D
    [reference] => 81
    [type] => 1
    [status] => 3
    [lastEventDate] => 2019-08-22T14:36:11.000-03:00
    [paymentMethod] => (
    [type] => 1
    [code] => 101
    )
    [grossAmount] => 39.90
    [discountAmount] => 0.00
    [feeAmount] => 2.39
    [netAmount] => 37.51
    [extraAmount] => 0.00
    [escrowEndDate] => 2019-09-05T14:36:11.000-03:00
    [installmentCount] => 1
    [itemCount] => 1
    [items] => (
    [item] => (
    [id] => 0001 [description] => DNA ASSESSMENT - RELATÓRIO COMPLETO
    [quantity] => 1
    [amount] => 39.90
    )
    )
    [sender] => (
    [email] => c70600011187649719818@sandbox.pagseguro.com.br
    [phone] => (
    [areaCode] => 11
    [number] => 99999999
    )
    [documents] => S(
    [document] => SimpleXMLElement Object (
    [type] => CPF [value] => 89023722353
    )
    )
    )
    [shipping] => (
    [address] => SimpleXMLElement Object (
    [street] => RUA SABINO GUIMARAES
    [number] => 60
    [complement] => ( )
    [district] => Centro
    [city] => SOBRAL
    [state] => CE
    [country] => BRA
    [postalCode] => 62010050
    )
    [type] => 3 ]
    [cost] => 0.00
    )
     */
    public function executeNotification($POST)
    {
        $url = $this->url_notificacao . $POST['notificationCode'] . $this->email_token;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $transaction = curl_exec($curl);
        if ($transaction == 'Unauthorized') {
            echo 'TRANSAÇÃO NÃO AUTORIZADA 1';
            exit;
        }
        curl_close($curl);
        $transaction_obj = simplexml_load_string($transaction);
        return $transaction_obj;
    }

    //Obtém o status de um pagamento com base no código do PagSeguro
    //Se o pagamento existir, retorna um código de 1 a 7
    //Se o pagamento não exitir, retorna NULL
    public function getStatusByCode($code)
    {
        $url = $this->url_transactions . $code . $this->email_token;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $transaction = curl_exec($curl);
        if ($transaction == 'Unauthorized') {
            //Insira seu código avisando que o sistema está com problemas
            //sugiro enviar um e-mail avisando para alguém fazer a manutenção
            echo 'TRANSAÇÃO NÃO AUTORIZADA';
            exit; //Mantenha essa linha para evitar que o código prossiga
        }
        $transaction_obj = simplexml_load_string($transaction);

        if (count($transaction_obj->error) > 0) {
            //Insira seu código avisando que o sistema está com problemas
            //echo 'ERRO: ';var_dump($transaction_obj);
            // Está dando um erro de InitialDate is required
        }

        if (isset($transaction_obj->status)) {
            return $transaction_obj;
        } else {
            return NULL;
        }
    }

    //Obtém o status de um pagamento com base na referência
    //Se o pagamento existir, retorna um código de 1 a 7
    //Se o pagamento não exitir, retorna NULL
    public function getStatusByReference($reference)
    {
        $url = $this->url_transactions . $this->email_token . "&reference=" . $reference;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $transaction = curl_exec($curl);
        if ($transaction == 'Unauthorized') {
            //Insira seu código avisando que o sistema está com problemas
            exit; //Mantenha essa linha para evitar que o código prossiga
        }
        $transaction_obj = simplexml_load_string($transaction);
        if (count($transaction_obj->error) > 0) {
            //Insira seu código avisando que o sistema está com problemas
            var_dump($transaction_obj);
        }
        if (isset($transaction_obj->transactions->transaction->status))
            return $transaction_obj->transactions->transaction->status;
        else
            return NULL;
    }

    public function getByReference($reference)
    {
        $url = $this->url_transactions . $this->email_token . "&reference=" . $reference;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $transaction = curl_exec($curl);
        if ($transaction == 'Unauthorized') {
            //Insira seu código avisando que o sistema está com problemas
            exit; //Mantenha essa linha para evitar que o código prossiga
        }
        $transaction_obj = simplexml_load_string($transaction);
        /*
        object(SimpleXMLElement)[14]
        public 'date' => string '2019-08-18T12:00:40.000-03:00' (length=29)
        public 'reference' => string '75' (length=2)
        public 'code' => string 'F49100D7-4CB9-433A-9FD2-C94D6FA6BBC8' (length=36)
        public 'type' => string '1' (length=1)
        public 'status' => string '3' (length=1)
        public 'paymentMethod' =>
          object(SimpleXMLElement)[12]
            public 'type' => string '1' (length=1)
        public 'grossAmount' => string '39.90' (length=5)
        public 'discountAmount' => string '0.00' (length=4)
        public 'feeAmount' => string '2.39' (length=4)
        public 'netAmount' => string '37.51' (length=5)
        public 'extraAmount' => string '0.00' (length=4)
        public 'lastEventDate' => string '2019-08-18T12:03:35.000-03:00' (length=29)
      */
        if (count($transaction_obj->error) > 0) {
            //Insira seu código avisando que o sistema está com problemas
            return NULL;
        }
        /*
         * object(SimpleXMLElement)#11 (5) { ["date"]=> string(29) "2019-08-13T01:33:14.000-03:00" ["transactions"]=> object(SimpleXMLElement)#12 (1) { ["transaction"]=> array(3) { [0]=> object(SimpleXMLElement)#13 (12) { ["date"]=> string(29) "2019-08-13T01:04:13.000-03:00" ["reference"]=> string(2) "63" ["code"]=> string(36) "F29FA501-E97D-475E-9459-72702FD25C87" ["type"]=> string(1) "1" ["status"]=> string(1) "3" ["paymentMethod"]=> object(SimpleXMLElement)#16 (1) { ["type"]=> string(1) "1" } ["grossAmount"]=> string(4) "1.00" ["discountAmount"]=> string(4) "0.00" ["feeAmount"]=> string(4) "0.45" ["netAmount"]=> string(4) "0.55" ["extraAmount"]=> string(4) "0.00" ["lastEventDate"]=> string(29) "2019-08-13T01:05:49.000-03:00" } [1]=> object(SimpleXMLElement)#14 (12) { ["date"]=> string(29) "2019-08-13T01:16:52.000-03:00" ["reference"]=> string(2) "63" ["code"]=> string(36) "B2306901-C896-4AB1-9CF3-2FB48668A16F" ["type"]=> string(1) "1" ["status"]=> string(1) "3" ["paymentMethod"]=> object(SimpleXMLElement)#16 (1) { ["type"]=> string(1) "1" } ["grossAmount"]=> string(4) "1.00" ["discountAmount"]=> string(4) "0.00" ["feeAmount"]=> string(4) "0.45" ["netAmount"]=> string(4) "0.55" ["extraAmount"]=> string(4) "0.00" ["lastEventDate"]=> string(29) "2019-08-13T01:17:49.000-03:00" } [2]=> object(SimpleXMLElement)#15 (12) { ["date"]=> string(29) "2019-08-13T01:20:32.000-03:00" ["reference"]=> string(2) "63" ["code"]=> string(36) "BF4DC2C4-475E-42E3-8948-A5688C59C2C7" ["type"]=> string(1) "1" ["status"]=> string(1) "3" ["paymentMethod"]=> object(SimpleXMLElement)#16 (1) { ["type"]=> string(1) "1" } ["grossAmount"]=> string(5) "39.90" ["discountAmount"]=> string(4) "0.00" ["feeAmount"]=> string(4) "2.39" ["netAmount"]=> string(5) "37.51" ["extraAmount"]=> string(4) "0.00" ["lastEventDate"]=> string(29) "2019-08-13T01:21:44.000-03:00" } } } ["resultsInThisPage"]=> string(1) "3" ["currentPage"]=> string(1) "1" ["totalPages"]=> string(1) "1" }
         */
        if (isset($transaction_obj->transactions->transaction))
            return $transaction_obj->transactions->transaction;
        else
            return NULL;
    }

    public function getStatusText($code)
    {
        $code = (int)$code;
        if ($code >= 1 && $code <= 7) {
            return $this->statusCode[$code];
        } else {
            return $this->statusCode[0];
        }
    }

    public function getPaymentMethodText($paymentMethod)
    {
        $paymentMethod = (int)$paymentMethod;
        if ($paymentMethod >= 1 && $paymentMethod <= 6) {
            return $this->paymentMethod[$paymentMethod];
        } else {
            return $this->paymentMethod[0];
        }
    }

    public function generatePaymentLink($dados_venda, $url_retorno)
    {
        return $this->executeCheckout($dados_venda, $url_retorno, false, true);
    }

    public function getPaymentLinkByTransactionCode($transaction_code)
    {
        return $this->url_redirect . str_replace('-', '', $transaction_code);
    }

    function erroPS($e)
    {
        switch ($e) {
            case '5003':
                $err = 'Falha de comunicação com a instituição financeira';
                break;
            case '10000':
                $err = 'Marca de cartão de crédito inválida';
                break;
            case '10001':
                $err = 'Número do cartão de crédito com comprimento inválido';
                break;
            case '10002':
                $err = 'Formato da data inválida';
                break;
            case '10003':
                $err = 'Campo de segurança CVV inválido';
                break;
            case '10004':
                $err = 'Código de verificação CVV é obrigatório';
                break;
            case '10006':
                $err = 'Campo de segurança com comprimento inválido';
                break;
            case '11001':
                $err = 'receiverEmail is required.';
                break;
            case '11002':
                $err = "receiverEmail invalid length: {0}";
                break;
            case '11003':
                $err = 'receiverEmail invalid value.';
                break;
            case '11004':
                $err = 'É necessário informar a moeda';
                break;
            case '11005':
                $err = 'Valor inválido para especificação da moeda';
                break;
            case '11006':
                $err = "redirectURL invalid length: {0}";
                break;
            case '11007':
                $err = "redirectURL invalid value: {0}";
                break;
            case '11008':
                $err = "reference invalid length: {0}";
                break;
            case '11009':
                $err = "Email do remetente com comprimento inválido: {0}";
                break;
            case '11010':
                $err = "Email do remetente está com valor inválido: {0}";
                break;
            case '11011':
                $err = "Nome do remetente está com comprimento inválido: {0}";
                break;
            case '11012':
                $err = "Nome do remetente está com valor inválido: {0}";
                break;
            case '11013':
                $err = "Valor de Código de Área inválido: {0}";
                break;
            case '11014':
                $err = "Telefone do remetente inválido: {0}";
                break;
            case '11015':
                $err = "O tipo de envio é obrigatório!.";
                break;
            case '11016':
                $err = "Tipo de envio inválido: {0}";
                break;
            case '11017':
                $err = "shippingPostalCode invalid Value: {0}";
                break;
            case '11018':
                $err = "shippingAddressStreet invalid length: {0}";
                break;
            case '11019':
                $err = "shippingAddressNumber invalid length: {0}";
                break;
            case '11020':
                $err = "shippingAddressComplement invalid length: {0}";
                break;
            case '11021':
                $err = "shippingAddressDistrict invalid length: {0}";
                break;
            case '11022':
                $err = "shippingAddressCity invalid length: {0}";
                break;
            case '11023':
                $err = "shippingAddressState invalid value: {0}, must fit the pattern: \w{2} (e. g. 'CE')";
                break;
            case '11024':
                $err = 'Quantidade inválida de itens';
                break;
            case '11025':
                $err = 'A identificação do item é necessária';
                break;
            case '11026':
                $err = 'A quantidade do item é necessária';
                break;
            case '11027':
                $err = "Quantidade do item está irregular: {0}";
                break;
            case '11028':
                $err = "O valor do item é necessário. (ex. '12.00')";
                break;
            case '11029':
                $err = "O Padrão do valor do item está inválido: {0}. Deve seguir o padrão: \d+.\d{2}";
                break;
            case '11030':
                $err = "Valor do item está irregular: {0}";
                break;
            case '11031':
                $err = "Item shippingCost invalid pattern: {0}. Must fit the patern: \d+.\d{2}";
                break;
            case '11032':
                $err = "Item shippingCost out of range: {0}";
                break;
            case '11033':
                $err = "A descrição do item é necessária.";
                break;
            case '11034':
                $err = "Descrição do item está com um comprimento inválido: {0}";
                break;
            case '11035':
                $err = "O peso do ítem está com um valor inválido: {0}";
                break;
            case '11036':
                $err = "Extra amount invalid pattern: {0}. Must fit the patern: -?\d+.\d{2}";
                break;
            case '11037':
                $err = "Extra amount out of range: {0}";
                break;
            case '11038':
                $err = "Invalid receiver for checkout: {0}, verify receiver's account status.";
                break;
            case '11039':
                $err = "Malformed request XML: {0}.";
                break;
            case '11040':
                $err = "MaxAge invalid pattern: {0}. Must fit the patern: \d+";
                break;
            case '11041':
                $err = "MaxAge out of range: {0}";
                break;
            case '11042':
                $err = "MaxUses invalid pattern: {0}. Must fit the patern: \d+";
                break;
            case '11043':
                $err = 'MaxUses out of range.';
                break;
            case '11044':
                $err = 'A data inicial é necessária.';
                break;
            case '11045':
                $err = 'A data inicial deve ser menor que o limite permitido.';
                break;
            case '11046':
                $err = 'A data inicial não deve ser maior que 6 meses.';
                break;
            case '11047':
                $err = 'A data inicial deve ser menor que a data final.';
                break;
            case '11048':
                $err = 'Intervalo de busca deve ser menor ou igual a 30 dias.';
                break;
            case '11049':
                $err = "A data final deve ser menor que o limite permitido.";
                break;
            case '11050':
                $err = "InitialDate invalid format, use 'yyyy-MM-ddTHH:mm' (eg. 2010-01-27T17:25).";
                break;
            case '11051':
                $err = "finalDate invalid format, use 'yyyy-MM-ddTHH:mm' (eg. 2010-01-27T17:25).";
                break;
            case '11052':
                $err = 'Página com valor inválido.';
                break;
            case '11053':
                $err = 'MaxPageResults invalid value (must be between 1 and 1000).';
                break;
            case '11157':
                $err = "CPF do remetente inválido: {0}";
                break;

            case '53004':
                $err = 'Quantidade inválida de itens';
                break;
            case '53005':
                $err = 'É necessário informar a moeda';
                break;
            case '53006':
                $err = 'Valor inválido para especificação da moeda';
                break;
            case '53007':
                $err = "Referência inválida comprimento: {0}";
                break;
            case '53008':
                $err = 'URL de notificação inválida';
                break;
            case '53009':
                $err = 'URL de notificação com valor inválido';
                break;
            case '53010':
                $err = 'O e-mail do remetente é obrigatório';
                break;
            case '53011':
                $err = 'Email do remetente com comprimento inválido';
                break;
            case '53012':
                $err = 'Email do remetente está com valor inválido';
                break;
            case '53013':
                $err = 'O nome do remetente é obrigatório';
                break;
            case '53014':
                $err = 'Nome do remetente está com comprimento inválido';
                break;
            case '53015':
                $err = 'Nome do remetente está com valor inválido';
                break;
            case '53017':
                $err = 'Foi detectado algum erro nos dados do seu CPF';
                break;
            case '53018':
                $err = 'O código de área do remetente é obrigatório';
                break;
            case '53019':
                $err = 'Há um conflito com o código de área informado, em relação a outros dados seus';
                break;
            case '53020':
                $err = 'É necessário um telefone do remetente';
                break;
            case '53021':
                $err = 'Valor inválido do telefone do remetente';
                break;
            case '53022':
                $err = 'É necessário o código postal do endereço de entrega';
                break;
            case '53023':
                $err = 'Código postal está com valor inválido';
                break;
            case '53024':
                $err = 'O endereço de entrega é obrigatório';
                break;
            case '53025':
                $err = "Endereço de entrega rua comprimento inválido: {0}";
                break;
            case '53026':
                $err = 'É necessário o número de endereço de entrega';
                break;
            case '53027':
                $err = 'Número de endereço de remessa está com comprimento inválido';
                break;
            case '53028':
                $err = 'No endereço de entrega há um comprimento inválido';
                break;
            case '53029':
                $err = 'O endereço de entrega é obrigatório';
                break;
            case '53030':
                $err = 'Endereço de entrega está com o distrito em comprimento inválido';
                break;
            case '53031':
                $err = 'É obrigatório descrever a cidade no endereço de entrega';
                break;
            case '53032':
                $err = 'O endereço de envio está com um comprimento inválido da cidade';
                break;
            case '53033':
                $err = 'É necessário descrever o Estado, no endereço de remessa';
                break;
            case '53034':
                $err = 'Endereço de envio está com valor inválido';
                break;
            case '53035':
                $err = 'O endereço do remetente é obrigatório';
                break;
            case '53036':
                $err = 'O endereço de envio está com o país em um comprimento inválido';
                break;
            case '53037':
                $err = 'O token do cartão de crédito é necessário';
                break;
            case '53038':
                $err = 'A quantidade da parcela é necessária';
                break;
            case '53039':
                $err = 'Quantidade inválida no valor da parcela';
                break;
            case '53040':
                $err = 'O valor da parcela é obrigatório.';
                break;
            case '53041':
                $err = 'Conteúdo inválido no valor da parcela';
                break;
            case '53042':
                $err = 'O nome do titular do cartão de crédito é obrigatório';
                break;
            case '53043':
                $err = 'Nome do titular do cartão de crédito está com o comprimento inválido';
                break;
            case '53044':
                $err = 'O nome informado no formulário do cartão de Crédito precisa ser escrito exatamente da mesma forma que consta no seu cartão obedecendo inclusive, abreviaturas e grafia errada';
                break;
            case '53045':
                $err = 'O CPF do titular do cartão de crédito é obrigatório';
                break;
            case '53046':
                $err = 'O CPF do titular do cartão de crédito está com valor inválido';
                break;
            case '53047':
                $err = 'A data de nascimento do titular do cartão de crédito é necessária';
                break;
            case '53048':
                $err = 'A data de nascimento do itular do cartão de crédito está com valor inválido';
                break;
            case '53049':
                $err = 'O código de área do titular do cartão de crédito é obrigatório';
                break;
            case '53050':
                $err = 'Código de área de suporte do cartão de crédito está com valor inválido';
                break;
            case '53051':
                $err = 'O telefone do titular do cartão de crédito é obrigatório';
                break;
            case '53052':
                $err = 'O número de Telefone do titular do cartão de crédito está com valor inválido';
                break;
            case '53053':
                $err = 'É necessário o código postal do endereço de cobrança';
                break;
            case '53054':
                $err = 'O código postal do endereço de cobrança está com valor inválido';
                break;
            case '53055':
                $err = 'O endereço de cobrança é obrigatório';
                break;
            case '53056':
                $err = 'A rua, no endereço de cobrança está com comprimento inválido';
                break;
            case '53057':
                $err = 'É necessário o número no endereço de cobrança';
                break;
            case '53058':
                $err = 'Número de endereço de cobrança está com comprimento inválido';
                break;
            case '53059':
                $err = 'Endereço de cobrança complementar está com comprimento inválido';
                break;
            case '53060':
                $err = 'O endereço de cobrança é obrigatório';
                break;
            case '53061':
                $err = 'O endereço de cobrança está com tamanho inválido';
                break;
            case '53062':
                $err = 'É necessário informar a cidade no endereço de cobrança';
                break;
            case '53063':
                $err = 'O item Cidade, está com o comprimento inválido no endereço de cobrança';
                break;
            case '53064':
                $err = 'O estado, no endereço de cobrança é obrigatório';
                break;
            case '53065':
                $err = 'No endereço de cobrança, o estado está com algum valor inválido';
                break;
            case '53066':
                $err = 'O endereço de cobrança do país é obrigatório';
                break;
            case '53067':
                $err = 'No endereço de cobrança, o país está com um comprimento inválido';
                break;
            case '53068':
                $err = 'O email do destinatário está com tamanho inválido';
                break;
            case '53069':
                $err = 'Valor inválido do e-mail do destinatário';
                break;
            case '53070':
                $err = 'A identificação do item é necessária';
                break;
            case '53071':
                $err = 'O ID do ítem está inválido';
                break;
            case '53072':
                $err = 'A descrição do item é necessária';
                break;
            case '53073':
                $err = 'Descrição do item está com um comprimento inválido';
                break;
            case '53074':
                $err = 'A quantidade do item é necessária';
                break;
            case '53075':
                $err = 'Quantidade do item está irregular';
                break;
            case '53076':
                $err = 'Há um valor inválido na quantidade do item';
                break;
            case '53077':
                $err = 'O valor do item é necessário';
                break;
            case '53078':
                $err = 'O Padrão do valor do item está inválido';
                break;
            case '53079':
                $err = 'Valor do item está irregular';
                break;
            case '53081':
                $err = 'O remetente está relacionado ao receptor! Esse é um erro comum que só o lojista pode cometer ao testar como compras. O erro surge quando uma compra é realizada com os mesmos dados cadastrados para receber os pagamentos da loja ou com um e-mail que é administrador da loja';
                break;
            case '53084':
                $err = 'Receptor inválido! Esse erro decorre de quando o lojista usa dados relacionados com uma loja ou um conta do PagSeguro, como e-mail principal da loja ou o e-mail de acesso à sua conta não PagSeguro';
                break;
            case '53085':
                $err = 'Método de pagamento indisponível';
                break;
            case '53086':
                $err = 'A quantidade total do carrinho está inválida';
                break;
            case '53087':
                $err = 'Dados inválidos do cartão de crédito';
                break;
            case '53091':
                $err = 'O Hash do remetente está inválido';
                break;
            case '53092':
                $err = 'A Bandeira do cartão de crédito não é aceita';
                break;
            case '53095':
                $err = 'Tipo de transporte está com padrão inválido';
                break;
            case '53096':
                $err = 'Padrão inválido no custo de transporte';
                break;
            case '53097':
                $err = 'Custo de envio irregular';
                break;
            case '53098':
                $err = 'O valor total do carrinho não pode ser negativo';
                break;
            case '53099':
                $err = 'Montante extra inválido';
                break;
            case '53101':
                $err = 'Valor inválido do modo de pagamento. O correto seria algo do tipo default e gateway';
                break;
            case '53102':
                $err = 'Valor inválido do método de pagamento. O correto seria algo do tipo Credicard, Boleto, etc.';
                break;
            case '53104':
                $err = 'O custo de envio foi fornecido, então o endereço de envio deve estar completo';
                break;
            case '53105':
                $err = 'As informações do remetente foram fornecidas, portanto o e-mail também deve ser informado';
                break;
            case '53106':
                $err = 'O titular do cartão de crédito está incompleto';
                break;
            case '53109':
                $err = 'As informações do endereço de remessa foram fornecidas, portanto o e-mail do remetente também deve ser informado';
                break;
            case '53110':
                $err = 'Banco EFT é obrigatório';
                break;
            case '53111':
                $err = 'Banco EFT não é aceito';
                break;
            case '53115':
                $err = 'Valor inválido da data de nascimento do remetente';
                break;
            case '53117':
                $err = 'Valor inválido do cnpj do remetente';
                break;
            case '53122':
                $err = "'O domínio do email do comprador está inválido. Você deve usar algo do tipo nome@dominio.com.br";
                break;
            case '53140':
                $err = 'Quantidade de parcelas fora do limite. O valor deve ser maior que zero';
                break;
            case '53141':
                $err = 'Este remetente está bloqueado';
                break;
            case '53142':
                $err = 'O cartão de crédito está com o token inválido';
                break;
            default:
                $err = 'Erro desconhecido: ' . $e;
        }
        return $err;
    }
}
