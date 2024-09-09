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
                    <h2 class="title">Cadastro de dados</h2>
                </div>
                <div class="card-body">
                    <form class="form" method="post" action="{{ route('usuario.paciente.store.dados') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">
                                Imagem de perfil <span class="required">*</span>
                            </label>
                            <br>
                            <img class="img-avatar" src="{{ asset('assets/img/default-avatar.png') }}" id="preview" alt="Avatar">
                            <div class="custom-file">
                                <input class="custom-file-input hidden" type="file" id="image" name="image" onchange="visualizarImagem(event)" accept="image/jpeg,image/jpg,image/png">
                                <label class="btn custom-file-label input-small {{ $errors->has('image') ? 'is-invalid' : '' }}" for="image"></label>
                            </div>
                            @include('alerts.feedback', ['field' => 'image'])
                        </div>

                        <div class="form-group">
                            <label for="documento">
                                CPF <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('documento') ? ' has-danger' : '' }}">
                                <input type="text" id="documento" class="form-control border-full {{ $errors->has('documento') ? 'is-invalid' : '' }}"
                                    name="documento" maxlength="14" placeholder="000.000.000-00" oninput="mascaraCpf(this)" onblur="validarCPF(this)"
                                    value="{{ (isset($user) && $user->documento ? $user->documento : null) ?? old('documento') }}" required>
                                @include('alerts.feedback', ['field' => 'documento'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nome">
                                Nome <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('nome') ? ' has-danger' : '' }}">
                                <input type="text" id="nome" class="form-control border-full {{ $errors->has('nome') ? 'is-invalid' : '' }}"
                                    name="nome" placeholder="Nome Completo" value="{{ (isset($user) ? $user->nome_completo : null) ?? old('nome') }}" required>
                                @include('alerts.feedback', ['field' => 'nome'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="celular">
                                Celular <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                <input type="text" id="celular" class="form-control border-full {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                    name="celular" maxlength="15" placeholder="(**) 9****-****" oninput="mascaraCelular(this)"
                                    value="{{ (isset($user) && $user->celular ? $user->celular : null) ?? old('celular') }}" required>
                                @include('alerts.feedback', ['field' => 'celular'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="rg">
                                RG
                            </label>
                            <div class="input-group input-medium{{ $errors->has('rg') ? ' has-danger' : '' }}">
                                <input type="text" id="rg" class="form-control border-full {{ $errors->has('rg') ? 'is-invalid' : '' }}"
                                    name="rg" placeholder="RG" value="{{ (isset($user) ? $user->rg : null) ?? old('rg') }}">
                                @include('alerts.feedback', ['field' => 'rg'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="data_nascimento">
                                Data de Nascimento <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('data_nascimento') ? ' has-danger' : '' }}">
                                <input type="date" id="data_nascimento" class="form-control border-full {{ $errors->has('data_nascimento') ? 'is-invalid' : '' }}"
                                    name="data_nascimento" placeholder="Nome Completo" value="{{ (isset($user) ? $user->data_nascimento : null) ?? old('data_nascimento') }}" required>
                                @include('alerts.feedback', ['field' => 'data_nascimento'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="estado_civil">
                                Estado Civil <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('estado_civil') ? ' has-danger' : '' }}">
                                <select name="estado_civil" class="form-control border-full {{ $errors->has('estado_civil') ? 'is-invalid' : '' }}" required>
                                    <option value=""></option>
                                    <option value="S" @if ((isset($user) && $user->estado_civil == 'S') || old('estado_civil') == 'S') selected @endif>Solteiro(a)</option>
                                    <option value="C" @if ((isset($user) && $user->estado_civil == 'C') || old('estado_civil') == 'C') selected @endif>Casado(a)</option>
                                    <option value="D" @if ((isset($user) && $user->estado_civil == 'D') || old('estado_civil') == 'D') selected @endif>Divorciado(a)</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'estado_civil'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sexo">
                                Gênero <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('sexo') ? ' has-danger' : '' }}">
                                <select name="sexo" class="form-control border-full {{ $errors->has('sexo') ? 'is-invalid' : '' }}" required>
                                    <option value=""></option>
                                    <option value="F" @if ((isset($user) && $user->sexo == 'F') || old('sexo') == 'F') selected @endif>Feminino</option>
                                    <option value="M" @if ((isset($user) && $user->sexo == 'M') || old('sexo') == 'M') selected @endif>Masculino</option>
                                    <option value="O" @if ((isset($user) && $user->sexo == 'O') || old('sexo') == 'O') selected @endif>Outro</option>
                                    <option value="N" @if ((isset($user) && $user->sexo == 'N') || old('sexo') == 'N') selected @endif>Prefiro não informar</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'sexo'])
                            </div>
                        </div>

                        <div class="input-group{{ $errors->has('consentimento') ? ' has-danger' : '' }}">
                            <div class="form-check text-left">
                                <label class="form-check-label {{ $errors->has('consentimento') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="checkbox" name="consentimento" @if ((isset($user) && $user->consentimento == "S") || old('consentimento') == "S") checked @endif value="S">

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
                        <input type="hidden" name="usuario_id" value="{{ $usuario_id ?? $user->id }}">
                        <input type="hidden" name="id_paciente" value="{{ isset($user) ? $user->getIdPaciente($user->id) : null }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        //VALIDAÇÃO DO CPF
        $('#cpf').blur(function() {
            if (this.value != '') {
                var retorno = validarDocumento(this, 'cpf')
            }
        });
        
        document.getElementById('image').addEventListener('change', function() {
            var fileName = $(this).val().split('\\').pop();
            //  $(this).next('.custom-file-label').html(fileName);
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
