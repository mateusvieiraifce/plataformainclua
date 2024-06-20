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
                        <div id="type-user" class="input-group {{ $errors->has('type_user') ? 'has-danger' : '' }} input-medium">
                            <select id="type_user" name="type_user" class="form-control border-full {{ $errors->has('type_user') ? 'is-invalid' : '' }}">
                                <option value=""></option>
                                <option id="paciente" @if (isset($user) && $user->tipo_user == "P") selected @endif value="formPaciente">Usuário</option>
                                <option id="especialista" @if (isset($user) && $user->tipo_user == "E") selected @endif value="formEspecialista">Especialista</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'type_user'])
                        </div>
                    </div>

                    <form id="formPaciente" class="form" method="post" action="{{ route('usuario.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">
                                Email <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input type="email" id="email" class="form-control border-full {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email" autocomplete="email" placeholder="Email" value="{{ (isset($user) ? $user->email : null) ?? old('email') }}" >
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">
                                Senha <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <input type="password" id="password" class="form-control border-full {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password" autocomplete="password" placeholder="Senha" value="{{ old('password') }}" >
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">
                                Confirme a senha <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                <input type="password" id="password_confirmation" class="form-control border-full {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                    name="password_confirmation" autocomplete="password_confirmation" placeholder="Confirmar senha" value="{{ old('password_confirmation') }}" >
                                @include('alerts.feedback', ['field' => 'password_confirmation'])
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Próximo') }}</button>
                        </div>
                        <input type="hidden" name="tipo_pessoa" value="F">
                        <input type="hidden" name="tipo_user" value="P">
                        <input type="hidden" id="id_usuario" name="id_usuario" value="{{ isset($user) ? $user->id : '' }}">
                    </form>
                    <form id="formEspecialista" class="form" method="post" action="">
                        @csrf
                        Form Especialista
                    </form>
                    <form id="formClinica" class="form" method="post" action="">
                        @csrf
                        Form Clínica
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function () {
        $("#type-user").change(function () {
            //ESCONDER FORM
            $('#formPaciente').hide();
            $('#formEspecialista').hide();
            $('#formClinica').hide();
            $(this).find(":selected").each(function () {
                //EXIBIR FORM SELECIONADO
                $("#"+$(this).val()).show();
            });
        });

        @if (old('tipo_user') == "P" || (isset($user) && $user->tipo_user == "P"))
            $("#paciente").prop("selected", true);
            $('#formPaciente').show();
        @endif

        @if (old('tipo_user') == "E" || (isset($user) && $user->tipo_user == "E"))
            $("#especialista").prop("selected", true);
            $('#formEspecialista').show();
        @endif

        @if (old('tipo_user') == "C" || (isset($user) && $user->tipo_user == "C"))
            $("#clinica").prop("selected", true);
            $('#formClinica').show();
        @endif
    });
    </script>
@endsection
