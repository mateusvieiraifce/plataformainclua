@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', "Formulário de usuário")
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Cadastro de usuário</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="type_user">
                            Informe seu nivel de usuário <span class="required">*</span>
                        </label>
                        <div id="type-user" class="input-group {{ $errors->has('type_user') ? 'has-danger' : '' }} input-medium {{ isset($user) && ($user->tipo_user) ? "disabled" : null}}">
                            <select id="type_user" name="type_user" class="form-control border-full {{ $errors->has('type_user') ? 'is-invalid' : '' }}" {{ isset($user) && ($user->tipo_user) ? "disabled" : null}}>
                                <option value=""></option>
                                <option id="paciente" @if (isset($user) && $user->tipo_user == "P") selected @endif value="formPaciente">Paciente</option>
                                <option id="especialista" @if (isset($user) && $user->tipo_user == "E") selected @endif value="formEspecialista">Especialista</option>
                                <option id="clinica" @if (isset($user) && $user->tipo_user == "C") selected @endif value="formClinica">Clínica</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'type_user'])
                        </div>
                    </div>
                    
                    <form id="formUser" class="form hidden" method="post" action="{{ route('usuario.store') }}">
                        @csrf
                        <div class="form-group hidden user-name">
                            <label for="nome">
                                Nome <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('nome') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="nome" class="form-control border-full {{ $errors->has('nome') ? ' is-invalid' : '' }}"
                                    name="nome" placeholder="Nome do Administrador da Clínica" value="{{ (isset($user) && $user->nome_completo ? $user->nome_completo : null) ?? old('nome') }}">
                                @include('alerts.feedback', ['field' => 'nome'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">
                                Email <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input type="email" id="email" class="form-control border-full {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email" autocomplete="email" placeholder="Email" value="{{ (isset($user) ? $user->email : null) ?? old('email') }}" required>
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">
                                Senha <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <input type="password" id="password" class="form-control border-full {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password" autocomplete="password" placeholder="Senha" minlength="8" maxlength="15" value="{{ old('password') }}" required>
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation">
                                Confirme a senha <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                <input type="password" id="password_confirmation" class="form-control border-full {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                    name="password_confirmation" autocomplete="password_confirmation" minlength="8" maxlength="15" placeholder="Confirmar senha" value="{{ old('password_confirmation') }}" required>
                                @include('alerts.feedback', ['field' => 'password_confirmation'])
                            </div>
                        </div>
                        
                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Próximo') }}</button>
                        </div>
                        <input type="hidden" id="tipo_pessoa" name="tipo_pessoa" value="">
                        <input type="hidden" id="tipo_user" name="tipo_user" value="">
                        <input type="hidden" id="usuario_id" name="usuario_id" value="{{ isset($user) ? $user->id : '' }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
        $("#type-user").change(function () {
            $('#formUser').show();
            $('.user-name').hide();
            $("#nome").prop("required", false);
            $(this).find(":selected").each(function () {
                //EXIBIR FORM COM MUDANÇAS
                if ($(this).val() == "formPaciente") {
                    $("#tipo_pessoa").val("F");
                    $("#tipo_user").val("P");
                } else if ($(this).val() == "formEspecialista") {
                    $("#tipo_pessoa").val("F");
                    $("#tipo_user").val("E");
                } else if ($(this).val() == "formClinica") {
                    $('.user-name').show();
                    $("#nome").prop("required", true);
                    $("#tipo_pessoa").val( "J");
                    $("#tipo_user").val("C");
                }
            });            
        });

        @if (old('tipo_user') == "P" || (isset($user) && $user->tipo_user == "P"))
            $("#paciente").prop("selected", true);
            $("#tipo_pessoa").val("F");
            $("#tipo_user").val("P");
            $('#formUser').show();
        @endif

        @if (old('tipo_user') == "E" || (isset($user) && $user->tipo_user == "E"))
            $("#especialista").prop("selected", true);
            $("#tipo_pessoa").val("F");
            $("#tipo_user").val("E");
            $('#formUser').show();
        @endif

        @if (old('tipo_user') == "C" || (isset($user) && $user->tipo_user == "C"))
            $("#clinica").prop("selected", true);
            $("#tipo_pessoa").val( "J");
            $("#tipo_user").val("C");
            $('#formUser').show();
        @endif
    });
    </script>
@endsection
