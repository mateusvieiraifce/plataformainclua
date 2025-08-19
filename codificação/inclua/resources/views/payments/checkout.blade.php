@extends('layouts.app', ['page' => __('Pagamento'), 'pageSlug' => 'payments','class'=>'compras'])

@section('title', 'Plataforma Inclua')

    <!DOCTYPE html>
<html>
<head>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .card-element {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .card-errors {
            color: #fa755a;
            margin-top: 10px;
        }
    </style>
</head>


@section('content')


<div class="container">
    <h1>Finalizar Compra</h1>

    <form id="payment-form">
        @csrf

        <div class="card-element">
            <label for="card-element">Cartão de Crédito</label>
            <div id="card-element"></div>
            <div id="card-errors" class="card-errors"></div>
        </div>

        <input type="hidden" name="amount" value="{{$order->preco}}">
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <button type="submit" id="submit-button">Pagar R$ {{$order->preco}}
        </button>
    </form>
</div>

<script>
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();

    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
        },
        hidePostalCode: true,
    });

    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const cardErrors = document.getElementById('card-errors');

    let paymentIntentId;

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        submitButton.disabled = true;

        // Criar ou reutilizar Payment Intent
        if (!paymentIntentId) {
            try {
                const response = await fetch('/checkout/stripe/payment-intent', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: {{$order->preco}},
                        order_id: document.querySelector('input[name="order_id"]').value
                    })
                });

                const data = await response.json();
                paymentIntentId = data.paymentIntentId;

                // Confirmar pagamento
                const { error } = await stripe.confirmCardPayment(data.clientSecret, {
                    payment_method: {
                        card: cardElement,
                    }
                });

                if (error) {
                    cardErrors.textContent = error.message;
                    submitButton.disabled = false

                } else {
                    // Pagamento bem sucedido
                    const confirmResponse = await fetch('/checkout/stripe/confirm-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_intent_id: paymentIntentId
                        })
                    });

                    const result = await confirmResponse.json();
                    console.log(result);
                    if (result.success) {
                        alert('Pagamento realizado com sucesso!');
                        window.location.href = '{{route($retorno)}}';
                    } else {
                        alert('Erro ao processar pagamento');
                    }
                }

            } catch (error) {
                console.error('Error:', error);
                cardErrors.textContent = 'Erro ao processar pagamento';
                submitButton.disabled = false;
            }
        }
    });

    // Mostrar erros em tempo real
    cardElement.on('change', ({error}) => {
        if (error) {
            cardErrors.textContent = error.message;
        } else {
            cardErrors.textContent = '';
        }
    });
</script>

@endsection
</html>
