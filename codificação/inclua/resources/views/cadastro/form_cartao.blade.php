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
                <div class="card-body" style="padding: 0px;">
                    <div id="cardPaymentBrick_container">
                        <input type="hidden" name="id_usuario" id="id_usuario" value="{{ $id_usuario ?? $user->id }}">
                    </div>
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

        const id_usuario = document.getElementById("id_usuario").value
        const mp = new MercadoPago("{{env('MERCADOPAGO_PUBLIC_KEY')}}", {
          locale: 'pt-BR'
        });
        const bricksBuilder = mp.bricks();
        const renderCardPaymentBrick = async (bricksBuilder) => {
            const settings = {
                initialization: {
                    amount: {{ env('PRECO_ASSINATURA') }}, // valor total a ser pago
                },
                customization: {
                    visual: {
                        style: {
                            customVariables: {
                                theme: 'bootstrap', // | 'dark' | 'bootstrap' | 'flat'
                                textPrimaryColor: "#344675",
                                baseColor: "rgb(137,119,249)",
                                baseColorFirstVariant: "rgb(137,119,249)",
                                baseColorSecondVariant: "rgb(137,119,249)",
                                outlinePrimaryColor: "rgba(29, 37, 59, 0.2)",
                                fontSizeMedium: "14px",
                                fontSizeLarge: "14px",
                                borderRadiusMedium: "8px",
                            }
                        },
                        texts: {
                            formTitle: "Cartão de crédito",
                            installmentsSectionTitle: "Selecione o número de parcelas *",
                            cardholderName: {
                                label: "Nome do titular *",
                                placeholder: "Nome do titular como aparece no cartão"
                            },
                            email: {
                                label: "E-mail *"
                            },
                            cardholderIdentification: {
                                label: "Documento do titular *"
                            },
                            cardNumber: {
                                label: "Número do cartão *"
                            },
                            expirationDate: {
                                label: "Data de vencimento *"
                            },
                            securityCode: {
                                label: "Código de segurança *"
                            },
                            formSubmit: "Finalizar"
                        },
                    paymentMethods: {
                        types: {
                            excluded: ['debit_card']
                        }, 
                        maxInstallments: 12,
                    }
                    }
                },
                callbacks: {
                    onReady: () => {
                        // callback chamado quando o Brick estiver pronto
                    },
                    onSubmit: (cardFormData) => {
                        //  callback chamado o usuário clicar no botão de submissão dos dados
                        //  exemplo de envio dos dados coletados pelo Brick para seu servidor
                        return new Promise((resolve, reject) => {
                            fetch("{{route('assinatura.aprovar')}}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-Token":"{{ csrf_token() }}"
                                },
                                body: JSON.stringify({cardFormData, id_usuario})
                            })
                            .then((response) => {
                                // receber o resultado do pagamento
                                document.querySelector('button[type="submit"]').style.pointerEvents  = "unset"
                                response.json().then((jsonResponse) => {
                                    console.log(jsonResponse)
                                    if (jsonResponse.message.status == "rejected") {
                                        $("#modal-aviso-title").text("Cartão não aprovado")
                                        $("#modal-aviso-message").text("O cartão utilizado não foi aprovado. Verifique os dados inserido ou informe outro cartão.")
                                        $("#modal-aviso").modal()
                                    } else if (jsonResponse.message.status == "amountAlter") {
                                        $("#modal-aviso-title").text("Pagamento alterado")
                                        $("#modal-aviso-message").text("O valor a ser pago foi alterado, tente novamente sem realizar mudanças no valor.")
                                        $("#modal-aviso").modal()
                                    } else if (jsonResponse.message.status == "approved") {
                                        //window.location.href = "{{ route('home') }}";
                                    }
                                })
                                resolve();
                            })
                            .catch((error) => {
                                // lidar com a resposta de erro ao tentar criar o pagamento
                                reject();
                            })
                        });
                    },
                    onError: (error) => {
                        // callback chamado para todos os casos de erro do Brick
                    },
                },
            };
            window.cardPaymentBrickController = bricksBuilder.create('cardPayment', 'cardPaymentBrick_container', settings);
        };
        renderCardPaymentBrick(bricksBuilder);
    </script>
@endsection