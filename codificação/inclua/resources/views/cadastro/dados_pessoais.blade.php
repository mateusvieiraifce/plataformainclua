@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro de Dados')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Cadastro de dados pessoais</h2>
                </div>
                <div class="card-body">
                    <form class="form" method="post" action="{{ route('usuario.dados.pessoais') }}">
                        @csrf
                        <div class="form-group">
                            <label for="cpf">
                                CPF <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('cpf') ? ' has-danger' : '' }}">
                                <input type="text" id="cpf" class="form-control border-full {{ $errors->has('cpf') ? 'is-invalid' : '' }}"
                                    name="cpf" maxlength="14" placeholder="000.000.000-00" value="{{ old('cpf') }}" autofocus>
                                @include('alerts.feedback', ['field' => 'cpf'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="nome">
                                Nome <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('nome') ? ' has-danger' : '' }}">
                                <input type="text" id="nome" class="form-control border-full {{ $errors->has('nome') ? 'is-invalid' : '' }}"
                                    name="nome" placeholder="Nome Completo" value="{{ old('nome') }}">
                                @include('alerts.feedback', ['field' => 'nome'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="celular">
                                Celular <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                <input type="text" id="celular" class="form-control border-full {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                    name="celular" maxlength="15" placeholder="Fone:(**) 9****-****" value="{{ old('celular') }}">
                                @include('alerts.feedback', ['field' => 'celular'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="rg">
                                RG <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('rg') ? ' has-danger' : '' }}">
                                <input type="text" id="rg" class="form-control border-full {{ $errors->has('rg') ? 'is-invalid' : '' }}"
                                    name="rg" placeholder="RG" value="{{ old('rg') }}">
                                @include('alerts.feedback', ['field' => 'rg'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="data_nascimento">
                                Data de Nascimento <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('data_nascimento') ? ' has-danger' : '' }}">
                                <input type="date" id="data_nascimento" class="form-control border-full {{ $errors->has('data_nascimento') ? 'is-invalid' : '' }}"
                                    name="data_nascimento" placeholder="Nome Completo" value="{{ old('data_nascimento') }}">
                                @include('alerts.feedback', ['field' => 'data_nascimento'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="estado_civil">
                                Estado Civil <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('estado_civil') ? ' has-danger' : '' }}">
                                <select name="estado_civil" class="form-control border-full {{ $errors->has('estado_civil') ? 'is-invalid' : '' }}">
                                    <option value=""></option>
                                    <option value="S" {{ old('estado_civil') == 'S' ? "Selected" : '' }}>Solteiro(a)</option>
                                    <option value="C" {{ old('estado_civil') == 'C' ? "Selected" : '' }}>Casado(a)</option>
                                    <option value="D" {{ old('estado_civil') == 'D' ? "Selected" : '' }}>Divorciado(a)</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'estado_civil'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="sexo">
                                Gênero <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('sexo') ? ' has-danger' : '' }}">
                                <select name="sexo" class="form-control border-full {{ $errors->has('sexo') ? 'is-invalid' : '' }}">
                                    <option value=""></option>
                                    <option value="F" {{ old('sexo') == 'F' ? "Selected" : '' }}>Fenimino</option>
                                    <option value="M" {{ old('sexo') == 'M' ? "Selected" : '' }}>Musculino</option>
                                    <option value="O" {{ old('sexo') == 'O' ? "Selected" : '' }}>Outro</option>
                                    <option value="N" {{ old('sexo') == 'N' ? "Selected" : '' }}>Prefiro não informar</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'sexo'])
                            </div>
                        </div>
                        
                        <div class="input-group{{ $errors->has('consentimento') ? ' has-danger' : '' }}">
                            <div class="form-check text-left">
                                <label class="form-check-label {{ $errors->has('consentimento') ? 'is-invalid' : '' }}">
                                    <input class="form-check-input" type="checkbox" name="consentimento" value="S">

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
                        <input type="hidden" name="tipo_pessoa" value="F">
                        <input type="hidden" name="tipo_user" value="P">
                        <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            //APLICAÇÃO DA MASCARA NO CPF
            document.getElementById('cpf').addEventListener('input', function() {
                if ($('#cpf').val().length >= 10) {
                    formatarDocumento(this)
                }
            })
            
            //VALIDAÇÃO DO CPF
            $('#cpf').blur(function() {
                if (this.value != '') {
                    var retorno = validarDocumento(this, 'cpf')
                }
            });

            //APLICAÇÃO DA MASCARA NO TELEFONE
            document.getElementById('celular').addEventListener('input', function() {
                if ($('#celular').val().length >= 10) {
                    mascaraCelular(this)
                }
            })
        });
    </script>
    @endsection
