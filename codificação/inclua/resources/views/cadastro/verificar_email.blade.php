@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Verificar e-mail')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Verificar Email</h2>
                </div>
                <div class="card-body">
                    <form class="form" method="post" action="{{ route('validar.email') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">
                                Email informado
                            </label>
                            <div class="input-group input-medium">
                                <input type="email" id="email" class="form-control border-full"
                                    name="email" autocomplete="email" placeholder="Email" value="{{ $email }}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="codigo">
                                Digite o código recebido por Email <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('codigo') ? ' has-danger' : '' }}">
                                <input type="text" id="codigo" class="form-control border-full only-numbers {{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                                    name="codigo" maxlength="5" placeholder="Código" value="{{ old('codigo') }}" >
                                @include('alerts.feedback', ['field' => 'codigo'])
                            </div>
                            <div >
                                <a id="reenviar-email" href="#" class="input-group input-medium justify-content-end">re-enviar código via email</a>
                                <label id="wait" class="input-group input-medium justify-content-end link hidden">Solicite um novo código em&nbsp;<label id="timer" class="link"></label></label>
                            </div>
                        </div>

                        <div class="input-group input-medium justify-content-between">
                            <a href="{{ route('usuario.edit', ['usuario_id' => $usuario_id])}}" class="btn btn-secundary btn-round btn-lg">{{ __('Voltar') }}</a>
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Verificar') }}</button>
                        </div>
                        <input type="hidden" id="usuario_id" name="usuario_id" value="{{ $usuario_id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#reenviar-email').click(function() {
            $.ajax({
                type: 'GET',
                url: '{{ route("validar.reenviar_email") }}',
                data: {
                    usuario: $('#usuario_id').val()
                },
                success: function(response) {
                    nowuiDashboard.showNotification('top', 'right', 'Código enviado! Um novo código foi enviado por Email, verifique sua caixa de entrada ou spam.', 'success');
                },
                error: function(error) {
                    nowuiDashboard.showNotification('top', 'right', 'Código não enviado! "Não foi possível enviar um novo código, verifique o e-mail informado.', 'danger');
                }
            });

            //ADICIONAR TEMPO DE ESPERA PARA REENVIAR O CODIGO
            $('#reenviar-email').hide();
            temporizador(120);
            $("#wait").css("display", "flex");

            //EXIBIR NOVAMENTE A OPÇÃO DE SOLICITAR CÓDIGO
            setInterval(function () {
                $("#wait").css("display", "none");
                $("#reenviar-email").css("display", "flex");
            }, 120000);
        });

        var tempo = 0 // tempo em segundos
        var working = false; // sinaliza se o timer está ativado
        var intervaloID = 0; // identificação do intervalo que permite limpá-lo

        function temporizador(t) {
            if (working == false) {
                working = true;
                tempo = t;
                intervaloID = setInterval(exibeTempo, 1000); // 1s
                exibeTempo();
            }
        }

        function exibeTempo() {
            let min = parseInt(tempo / 60); // Pega a parte inteira dos minutos
            let seg = tempo % 60; // Calcula os segundos restantes
            let smin = min.toString().padStart(2, '0'); // Formata o número em duas casas
            let sseg = seg.toString().padStart(2, '0');

            let tempoTela = smin + ':' + sseg; // Variável para formatar no estilo cronômetro
            document.querySelector("#timer").textContent = tempoTela;
            tempo--;

            if (tempo < 0){ // zera temporizador
                working = false;
                clearInterval(intervaloID);
            }
        }
    </script>
@endsection
