<!DOCTYPE html>
@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro de Dados de pagamento')
@section('content')


<div class="row">
    <div class="card card-register">
    <div class="col-md-7 mr-auto">

        <h2>Dados de pagamento</h2>


        <div class="card-body">
<div class="row">
<form id="paymentForm">
    @csrf
    <div class="form-group">
        <label for="cardNumber">Número do Cartão</label>
        <div class="input-group">
        <input type="text"  name="numero_cartao" class="form-control" id="cardNumber" placeholder="4509 9535 6623 3704" value="5031 4332 1540 6351">
        </div>
        <div id="cardNumberError" class="error"></div>
    </div>

    <div class="form-group">
        <label for="cardholderName">Nome no Cartão</label>
        <div class="input-group">
        <input type="text" class="form-control" id="cardholderName" placeholder="Como no cartão" value="APRO">
        </div>
    </div>


    <div class="form-group">
        <label>Validade</label>
        <div style="display: flex; gap: 30px;">
            <div class="input-group">
            <input type="text" class="form-control" id="cardExpirationMonth" placeholder="MM" style="width: 20%;"  value="11">
            <input type="text" class="form-control" id="cardExpirationYear" placeholder="AAAA" style="width: 30%;"  value="2030">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="securityCode">Código de Segurança</label>
        <div class="input-group">
        <input type="text" class="form-control" id="securityCode" placeholder="123" value="123" >
        </div>
    </div>

    <input type="hidden" id="docType" value="CPF">

    <div class="form-group">
        <label for="docNumber">Número do Documento</label>
        <div class="input-group">
        <input type="text"  class="form-control" id="docNumber" placeholder="123.456.789-09" value="12345678909">
        </div>
    </div>

    <div class="form-group">
        <label for="email">E-mail</label>
        <div class="input-group">
        <input type="email" class="form-control" id="email" placeholder="seu@email.com" value="mateus.vieira@ifce.edu.br">
        </div>
    </div>
    <input type="hidden" name="usuario_id" id="usuario_id" value="{{ $usuario_id ?? $user->id }}">
    <div class="form-group">
        <label for="amount">Valor (R$)</label>
        <div class="input-group">
        <input type="number"  class="form-control" id="amount" value="10.50" step="0.01">
        </div>
    </div>

    <button type="button" class="btn btn-primary" onclick="processPayment()">Concluir</button>
</form>

<div id="paymentResult" class="success"></div>
</div>
        </div>
    </div>
        <script src="https://sdk.mercadopago.com/js/v2"></script>
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
                    card:document.getElementById('cardNumber').value,
                    mes:document.getElementById('cardExpirationMonth').value,
                    ano:document.getElementById('cardExpirationYear').value,
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
                if (result.payment.status=="approved"){
                    window.location.href="{{route("checkout")}}"

                }
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

</div>
</div>
@endsection
