@extends('layouts.app', ['class' => 'login-page', 'page' => __(''), 'contentClass' => 'login-page'])
@section('title', 'Plataforma Inclua')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pagamento via PIX</div>

                    <div class="card-body text-center">
                        <h4>Valor: R$ {{ number_format($amount, 2, ',', '.') }}</h4>
                        <p>Escaneie o QR Code abaixo:</p>

                        <!-- QR Code -->
                        <img src="data:image/png;base64,{{ $qr_code_base64 }}"
                             alt="QR Code PIX"
                             class="img-fluid mb-3"
                             style="max-width: 300px;">

                        <!-- Código PIX para copiar -->
                        <div class="mb-3">
                            <label for="pix-code" class="form-label">Ou copie o código:</label>
                            <textarea id="pix-code" class="form-control" rows="3" readonly>{{ $qr_code }}</textarea>
                            <button onclick="copyPixCode()" class="btn btn-sm btn-secondary mt-2">Copiar</button>
                        </div>

                        <!-- Status do pagamento -->
                        <div id="payment-status" class="alert alert-info">
                            Status: {{ ucfirst($status) }}
                        </div>

                        <p class="text-muted">ID do pagamento: {{ $payment_id }}</p>
                        <p class="text-muted">Criado em: {{ \Carbon\Carbon::parse($created_at)->format('d/m/Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyPixCode() {
            const textarea = document.getElementById('pix-code');
            textarea.select();
            document.execCommand('copy');
            alert('Código PIX copiado!');
        }

        // Verificar status periodicamente (opcional)
        @if($status !== 'approved')
        setInterval(() => {
            fetch(`/pix/status/{{ $payment_id }}`)
                .then(response => response.json())
                .then(data => {
                    if(data.approved) {
                        document.getElementById('payment-status').innerHTML =
                            'Status: Aprovado! Obrigado pelo pagamento.';
                        document.getElementById('payment-status').className = 'alert alert-success';
                    }
                });
        }, 10000); // A cada 10 segundos
        @endif
    </script>
@endsection
