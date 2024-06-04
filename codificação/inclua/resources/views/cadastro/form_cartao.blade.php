@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro de Dados de pagamento')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Dados de pagamento</h2>
                </div>
                <div class="card-body">
                    <form id="form-checkout" class="form">
                        <div class="form-group">
                            <label for="numero_cartao">
                                Número do cartão <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('validade') ? ' has-danger' : '' }}">
                                <div id="form-checkout__cardNumber" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="validade">
                                Validade <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('validade') ? ' has-danger' : '' }}">
                                <div id="form-checkout__expirationDate" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cvv">
                                CVV <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('validade') ? ' has-danger' : '' }}">
                                <div id="form-checkout__securityCode" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nome_titular">
                                Nome do titular <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('validade') ? ' has-danger' : '' }}">
                                <input type="text" id="form-checkout__cardholderName" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="banco">
                                Banco <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('validade') ? ' has-danger' : '' }}">
                                <select id="form-checkout__issuer" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="parcelas">
                                Parcelas <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('validade') ? ' has-danger' : '' }}">
                                <select id="form-checkout__installments" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tipo_documento">
                                Tipo de Documento <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('validade') ? ' has-danger' : '' }}">
                                <select id="form-checkout__identificationType" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}"></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="documento">
                                Documento <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('validade') ? ' has-danger' : '' }}">
                                <input type="text" id="form-checkout__identificationNumber" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">
                                Email <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('validade') ? ' has-danger' : '' }}">
                                <input type="email" id="form-checkout__cardholderEmail" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}" />
                            </div>
                        </div>

                        <div class="input-group">
                            <button id="form-checkout__submit" type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Finalizar') }}</button>
                        </div>
                    </form>
                </div>                    
            </div>
        </div>
    </div>
    @include("layouts.modal_aviso")
    {{-- IMPORTAÇÃO SDK MERCADO PAGO --}}
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    
    <script>
        $(document).ready(function () {
            //APLICAÇÃO DA MASCARA NO NÚMERO DO CARTÃO
            document.getElementById('numero_cartao').addEventListener('input', function() {
                if ($('#numero_cartao').val().length >= 4) {
                    let documento = marcaraNumeroCartao(this)
                }
            })

            $('#numero_cartao').blur(function () {
                if (this.value != '') {
                    validarCartao(this)
                }
            })
        })

        const mp = new MercadoPago("{{env('MERCADOPAGO_PUBLIC_KEY')}}");
        const cardForm = mp.cardForm({
            amount: "{{env('PRECO_ASSINATURA')}}",
            iframe: true,
            form: {
                id: "form-checkout",
                cardNumber: {
                id: "form-checkout__cardNumber",
                placeholder: "0000 0000 0000 0000",
                },
                expirationDate: {
                id: "form-checkout__expirationDate",
                placeholder: "MM/YY",
                },
                securityCode: {
                id: "form-checkout__securityCode",
                placeholder: "Código de segurança",
                },
                cardholderName: {
                id: "form-checkout__cardholderName",
                placeholder: "Nome do titular igual ao cartão",
                },
                issuer: {
                id: "form-checkout__issuer",
                placeholder: "Banco emissor",
                },
                installments: {
                id: "form-checkout__installments",
                placeholder: "Parcelas",
                },        
                identificationType: {
                id: "form-checkout__identificationType",
                placeholder: "Tipo de documento",
                },
                identificationNumber: {
                id: "form-checkout__identificationNumber",
                placeholder: "Número do documento",
                },
                cardholderEmail: {
                id: "form-checkout__cardholderEmail",
                placeholder: "E-mail",
                },
            },
            callbacks: {
                onFormMounted: error => {
                    if (error) return console.warn("Form Mounted handling error: ", error);
                },
                onSubmit: event => {
                    event.preventDefault();

                    const {
                        paymentMethodId: payment_method_id,
                        issuerId: issuer_id,
                        cardholderEmail: email,
                        amount,
                        token,
                        installments,
                        identificationNumber,
                        identificationType,
                    } = cardForm.getCardFormData();

                    fetch("{{route('cartao.save')}}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token":"{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            token,
                            issuer_id,
                            payment_method_id,
                            transaction_amount: Number(amount),
                            installments: Number(installments),
                            description: "Plataforma Inclua - Assinatura",
                            payer: {
                                email,
                                identification: {
                                    type: identificationType,
                                    number: identificationNumber,
                                },
                            },
                        }),
                    })
                    .then(response => console.log(response.json(), response.status));
                },
            },
        });
    </script>
@endsection