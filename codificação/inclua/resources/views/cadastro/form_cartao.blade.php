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
                    <form class="form" method="post" action="{{ route('cartao.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="numero_cartao">
                                Número do cartão <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('numero_cartao') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="numero_cartao" class="form-control border-full {{ $errors->has('numero_cartao') ? ' is-invalid' : '' }}"
                                    name="numero_cartao" maxlength="19" placeholder="0000 0000 0000 0000" value="{{ old('numero_cartao') }}" >
                                @include('alerts.feedback', ['field' => 'numero_cartao'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="validade">
                                Validade <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('validade') ? ' has-danger' : '' }} input-medium">
                                <input type="month" id="validade" class="form-control border-full {{ $errors->has('validade') ? ' is-invalid' : '' }}"
                                    name="validade" placeholder="Validade" value="{{ old('validade') }}" >
                                @include('alerts.feedback', ['field' => 'validade'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cvv">
                                CVV <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('cvv') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="cvv" class="form-control border-full {{ $errors->has('cvv') ? ' is-invalid' : '' }}"
                                    name="cvv" maxlength="3" placeholder="***" value="{{ old('cvv') }}">
                                @include('alerts.feedback', ['field' => 'cvv'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nome_titular">
                                Nome do titular <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('nome_titular') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="nome_titular" class="form-control border-full {{ $errors->has('nome_titular') ? ' is-invalid' : '' }}"
                                    name="nome_titular" placeholder="Nome do titular igual ao cartão" value="{{ old('nome_titular') }}">
                                @include('alerts.feedback', ['field' => 'nome_titular'])
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Finalizar') }}</button>
                        </div>
                        <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">
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