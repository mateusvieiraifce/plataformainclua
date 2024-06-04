<html>
    <head>
        <script src="https://sdk.mercadopago.com/js/v2"></script>
    </head>
    <body>
        <style>
            #form-checkout {
            display: flex;
            flex-direction: column;
            max-width: 600px;
            }

            .container {
            height: 18px;
            display: inline-block;
            border: 1px solid rgb(118, 118, 118);
            border-radius: 2px;
            padding: 1px 2px;
            }
        </style>
        <form id="form-checkout">
            <div id="form-checkout__cardNumber" class="container"></div>
            <div id="form-checkout__expirationDate" class="container"></div>
            <div id="form-checkout__securityCode" class="container"></div>
            <input type="text" id="form-checkout__cardholderName" />
            <select id="form-checkout__issuer"></select>
            <select id="form-checkout__installments"></select>
            <select id="form-checkout__identificationType"></select>
            <input type="text" id="form-checkout__identificationNumber" />
            <input type="email" id="form-checkout__cardholderEmail" />

            <button type="submit" id="form-checkout__submit">Pagar</button>
        </form>

        <script>
            const mp = new MercadoPago("{{env('MERCADOPAGO_PUBLIC_KEY')}}");
            
            const cardForm = mp.cardForm({
                amount: "{{env('PRECO_ASSINATURA')}}",
                iframe: true,
                form: {
                    id: "form-checkout",
                    cardNumber: {
                    id: "form-checkout__cardNumber",
                    placeholder: "Número do cartão",
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
                    placeholder: "Titular do cartão",
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
    
    </body>
</html>