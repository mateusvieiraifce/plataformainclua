@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Formulário de dados')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Cadastro de dados {{ env('APP_NODE') }}</h2>
                </div>
                <div class="card-body">
                    <form class="form" method="post" action="{{ route('usuario.clinica.store.dados') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">
                                Logo da clínica <span class="required">*</span>
                            </label>
                            <br>
                            <img class="img-avatar" src="{{ asset('assets/img/default-avatar.png') }}" id="preview" alt="Avatar">
                            <div class="custom-file">
                                <input class="custom-file-input hidden" type="file" id="image" name="logo" onchange="visualizarImagem(event)" accept="image/jpeg,image/jpg,image/png">
                                <label class="btn custom-file-label input-small {{ $errors->has('logo') ? 'is-invalid' : '' }}" for="image"></label>
                            </div>
                            @include('alerts.feedback', ['field' => 'logo'])
                        </div>

                        <div class="form-group">
                            <label for="documento">
                                CNPJ <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('documento') ? ' has-danger' : '' }}">
                                <input type="text" id="documento" class="form-control border-full {{ $errors->has('documento') ? 'is-invalid' : '' }}"
                                    name="documento" maxlength="18" placeholder="00.000.000/0000-00" oninput="mascaraCnpj(this)" onblur="consultarCNPJ(this)"
                                    value="{{ (isset($clinica) && $clinica->cnpj ? $clinica->cnpj : null) ?? old('documento') }}" required>
                                @include('alerts.feedback', ['field' => 'documento'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nome_fantasia">
                                Nome Fantasia <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('nome_fantasia') ? ' has-danger' : '' }}">
                                <input type="text" id="nome_fantasia" class="form-control border-full {{ $errors->has('nome_fantasia') ? 'is-invalid' : '' }}"
                                    name="nome_fantasia" placeholder="Nome Fantasia" value="{{ (isset($clinica) && $clinica->nome ? $clinica->nome : null) ?? old('nome_fantasia') }}" required>
                                @include('alerts.feedback', ['field' => 'nome_fantasia'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="razao_social">
                                Razão Social <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('razao_social') ? ' has-danger' : '' }}">
                                <input type="text" id="razao_social" class="form-control border-full {{ $errors->has('razao_social') ? 'is-invalid' : '' }}"
                                    name="razao_social" placeholder="Razão Social" value="{{ (isset($clinica) && $clinica->razaosocial ? $clinica->razaosocial : null) ?? old('razao_social') }}" required>
                                @include('alerts.feedback', ['field' => 'razao_social'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="telefone">
                                Telefone Fixo
                            </label>
                            <div class="input-group input-medium{{ $errors->has('telefone') ? ' has-danger' : '' }}">
                                <input type="text" id="telefone" class="form-control border-full {{ $errors->has('telefone') ? 'is-invalid' : '' }}"
                                    name="telefone" maxlength="14" placeholder="(**) ****-****" oninput="mascaraTelefone(this)"
                                    value="{{ (isset($clinica) ? $clinica->getTelefone($clinica->usuario_id) : null) ?? old('telefone') }}">
                                @include('alerts.feedback', ['field' => 'telefone'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="celular">
                                Celular <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                <input type="text" id="celular" class="form-control border-full {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                    name="celular" maxlength="15" placeholder="(**) 9****-****" oninput="mascaraCelular(this)"
                                    value="{{ (isset($clinica) ? $clinica->getCelular($clinica->usuario_id) : null) ?? old('celular') }}" required>
                                @include('alerts.feedback', ['field' => 'celular'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="numero_atendimento_social_mensal">
                                N° de atendimentos sociais mensais <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('numero_atendimento_social_mensal') ? ' has-danger' : '' }}">
                                <input type="number" id="numero_atendimento_social_mensal" class="form-control border-full {{ $errors->has('numero_atendimento_social_mensal') ? 'is-invalid' : '' }}"
                                    name="numero_atendimento_social_mensal" maxlength="15" placeholder="" value="{{ (isset($clinica) && $clinica->numero_atendimento_social_mensal ? $clinica->numero_atendimento_social_mensal : null) ?? old('numero_atendimento_social_mensal') }}" required>
                                @include('alerts.feedback', ['field' => 'numero_atendimento_social_mensal'])
                            </div>
                        </div>

                        <div class="input-group{{ $errors->has('consentimento') ? ' has-danger' : '' }}">
                            <div class="form-check text-left">
                                <label class="form-check-label {{ $errors->has('consentimento') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="checkbox" name="consentimento" @if ((isset($clinica) && $clinica->getUser->consentimento == "S") || old('consentimento') == "S") checked @endif value="S">
                                    <span class="form-check-sign"></span>
                                    {{ __('Eu Aceito') }}
                                    <a href="/docs/termos.pdf">{{ __('termos e condições de uso') }}</a>.
                                </label>
                                 @include('alerts.feedback', ['field' => 'consentimento'])
                            </div>
                        </div>
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Próximo') }}</button>
                        </div>
                        <input type="hidden" name="usuario_id" value="{{ $usuario_id ?? $clinica->id }}">
                        <input type="hidden" name="clinica_id" value="{{ isset($clinica) ? $clinica->id : null }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        //VALIDAÇÃO DO CNPJ
        $('#cnpj').blur(function() {
            if (this.value != '') {
                consultarCNPJ(this)
            }
        });

        document.getElementById('image').addEventListener('change', function() {
            var fileName = $(this).val().split('\\').pop();
        });

        function visualizarImagem(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
    @endsection
