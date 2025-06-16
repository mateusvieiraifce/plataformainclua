<!DOCTYPE html>
<html>
<head>
    <title>Checkout Transparente</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #009ee3; color: white; border: none; padding: 12px 20px; border-radius: 4px; cursor: pointer; }
        .error { color: #d32f2f; margin-top: 5px; }
        .success { color: #388e3c; margin-top: 15px; }
    </style>
</head>
<body>
<h1>Finalizar Compra</h1>

<form id="paymentForm">
    <div class="form-group">
        <label for="cardNumber">Número do Cartão</label>
        <input type="text" id="cardNumber" placeholder="4509 9535 6623 3704" value="5200486719358259">
        <div id="cardNumberError" class="error"></div>
    </div>

    <div class="form-group">
        <label for="cardholderName">Nome no Cartão</label>
        <input type="text" id="cardholderName" placeholder="Como no cartão" value="Mateus A V Neto">
    </div>


    <div class="form-group">
        <label>Validade</label>
        <div style="display: flex; gap: 10px;">
            <input type="text" id="cardExpirationMonth" placeholder="MM" style="width: 20%;" value="04">
            <input type="text" id="cardExpirationYear" placeholder="AAAA" style="width: 30%;" value="2033">
        </div>
    </div>

    <div class="form-group">
        <label for="securityCode">Código de Segurança</label>
        <input type="text" id="securityCode" placeholder="123" value="615">
    </div>

    <div class="form-group">
        <label for="docType">Tipo de Documento</label>
        <select id="docType">
            <option value="CPF" selected >CPF</option>
        </select>
    </div>

    <div class="form-group">
        <label for="docNumber">Número do Documento</label>
        <input type="text" id="docNumber" placeholder="123.456.789-09" value="66664195372">
    </div>

    <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" placeholder="seu@email.com" value="mateus.vieira@ifce.edu.br">
    </div>

    <div class="form-group">
        <label for="amount">Valor (R$)</label>
        <input type="number" id="amount" value="10.50" step="0.01">
    </div>

    <button type="button" onclick="processPayment()">Pagar</button>
</form>

<div id="paymentResult" class="success"></div>

<script>
    // Inicializa o Mercado Pago com sua public key
    const mp = new MercadoPago('{{ $publicKey }}', {
        locale: 'pt-BR',
        advancedFraudPrevention: true
    });

    async function processPayment() {
        try {
            // Limpa resultados anteriores
            document.getElementById('paymentResult').innerHTML = '';

            // Cria token do cartão
            const token = await mp.createCardToken({
                cardNumber: document.getElementById('cardNumber').value.replace(/\s/g, ''),
                cardholderName: document.getElementById('cardholderName').value,
                cardExpirationMonth: document.getElementById('cardExpirationMonth').value,
                cardExpirationYear: document.getElementById('cardExpirationYear').value,
                securityCode: document.getElementById('securityCode').value,
                identificationType: document.getElementById('docType').value,
                identificationNumber: document.getElementById('docNumber').value.replace(/\D/g, '')
            });
         //   console.log(token);
            // Envia para seu backend
            const response = await fetch('/api/payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Idempotency-Key': "{{$publicKeyIdem}}"
                },
                body: JSON.stringify({
                    token: token.id,
                    payment_method_id: 'master', // Pode ser dinâmico
                    transaction_amount: parseFloat(document.getElementById('amount').value),
                    installments: 1, // Pode ser selecionável
                    description: 'Compra na Loja Online',
                    payer: {
                        email: document.getElementById('email').value,
                        identification: {
                            type: document.getElementById('docType').value,
                            number: document.getElementById('docNumber').value.replace(/\D/g, '')
                        }
                    }
                })
            });

            const result = await response.json();

            if (result.success) {
                document.getElementById('paymentResult').innerHTML = `
                        <h3>Pagamento realizado com sucesso!</h3>
                        <p>ID: ${result.payment.id}</p>
                        <p>Status: ${result.payment.status}</p>
                        <p>Detalhe: ${result.payment.status_detail}</p>
                    `;
            } else {
                throw new Error(result.error || 'Erro ao processar pagamento');
            }

        } catch (error) {
            document.getElementById('paymentResult').innerHTML = `
                    <p class="error">Erro: ${error.message}</p>
                `;
            console.error('Erro no pagamento:', error);
        }
    }
</script>
</body>
</html>
