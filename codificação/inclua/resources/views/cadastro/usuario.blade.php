@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro de usuário')
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
                                <option id="paciente" value="formPaciente">Paciente</option>
                                <option id="especialista" value="formEspecialista">Especialista</option>
                                <option id="clinica" value="formClinica">Clínica</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'type_user'])
                        </div>{{-- 
                        <div class="custom-radio">
                            <input type="radio" name="type_user" id="paciente" value="P">
                            <label class="form-check-label" for="paciente">Paciente</label>
                        </div>
                        <div class="custom-radio">
                            <input type="radio" name="type_user" id="especialista" value="E">
                            <label class="form-check-label" for="especialista">Especialista</label>
                        </div>
                        <div class="custom-radio">
                            <input type="radio" name="type_user" id="clinica" value="C">
                            <label class="form-check-label" for="clinica">Clínica</label>
                        </div> --}}
                    </div>
                    
                    <form id="formPaciente" class="form" method="post" action="{{ route('usuario.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">
                                Email <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input type="email" id="email" class="form-control border-full {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email" autocomplete="email" placeholder="Email" value="{{ old('email') }}" >
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

        @if (old('tipo_user') == "P")
            $("#paciente").prop("selected", true);
            $('#formPaciente').show();
        @endif

        @if (old('tipo_user') == "E")
            $("#especialista").prop("selected", true);
            $('#formEspecialista').show();
        @endif

        @if (old('tipo_user') == "C")
            $("#clinica").prop("selected", true);
            $('#formClinica').show();
        @endif
    });
    </script>
@endsection
