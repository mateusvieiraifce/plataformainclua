@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro de Dados para pagamento')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Dados para pagamento</h2>
                </div>
                <div class="card-body">                    
                    <form class="form" method="post" action="{{ route('pagamento.assinatura') }}">
                        @csrf
                        <div class="form-group">
                            <label for="numero_cartao">
                                Número do cartão <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('numero_cartao') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="numero_cartao" class="form-control border-full {{ $errors->has('numero_cartao') ? ' is-invalid' : '' }}"
                                    name="numero_cartao" maxlength="19" placeholder="0000 0000 0000 0000" value="{{ old('numero_cartao') }}" required>
                                @include('alerts.feedback', ['field' => 'numero_cartao'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="validade">
                                Validade <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('validade') ? ' has-danger' : '' }} input-medium">
                                <input type="month" id="validade" class="form-control border-full {{ $errors->has('validade') ? ' is-invalid' : '' }}"
                                    name="validade" placeholder="Validade" value="{{ old('validade') }}" required>
                                @include('alerts.feedback', ['field' => 'validade'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="codigo_seguranca">
                                Código de segurança <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('codigo_seguranca') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="codigo_seguranca" class="form-control border-full {{ $errors->has('codigo_seguranca') ? ' is-invalid' : '' }}"
                                    name="codigo_seguranca" maxlength="3" placeholder="***" value="{{ old('codigo_seguranca') }}" required>
                                @include('alerts.feedback', ['field' => 'codigo_seguranca'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nome_titular">
                                Nome do titular <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('nome_titular') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="nome_titular" class="form-control border-full {{ $errors->has('nome_titular') ? ' is-invalid' : '' }}"
                                    name="nome_titular" placeholder="Nome do titular igual ao cartão" value="{{ old('nome_titular') }}" required>
                                @include('alerts.feedback', ['field' => 'nome_titular'])
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Finalizar') }}</button>
                        </div>
                        <input id="instituicao" type="hidden" name="instituicao" value="">
                        <input type="hidden" name="usuario_id" value="{{ $usuario_id }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>
    @include("layouts.modal_aviso")
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
    </script>
@endsection