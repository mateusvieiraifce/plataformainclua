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
                    <h2 class="title">Cadastro de Dados</h2>
                </div>
                <div class="card-body">                    
                    <form class="form" method="post" action="{{ route('usuario.especialista.store.dados') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nome">
                                Nome <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('nome') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="nome" class="form-control border-full {{ $errors->has('nome') ? ' is-invalid' : '' }}"
                                    name="nome" placeholder="Nome Completo" value="{{ (isset($user) && $user->nome_completo ? $user->nome_completo : null) ?? old('nome') }}">
                                @include('alerts.feedback', ['field' => 'nome'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="celular">
                                Celular <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                <input type="text" id="celular" class="form-control border-full {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                    name="celular" maxlength="15" placeholder="Fone:(**) 9****-****" value="{{ (isset($user) && $user->celular ? $user->celular : null) ?? old('celular') }}">
                                @include('alerts.feedback', ['field' => 'celular'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="especialidade">
                                Especialidade <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('especialidade') ? ' has-danger' : '' }}">
                                <select name="especialidade" class="form-control border-full {{ $errors->has('especialidade') ? 'is-invalid' : '' }}">
                                    <option value=""></option>
                                    @foreach($especialidades as $especialidade)
                                        <option value="{{ $especialidade->id }}" @if (isset($user) && $user->getIdEspecialidade($user->id) == $especialidade->id || $especialidade->id == old('especialidade')) selected @endif>
                                            {{ $especialidade->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'especialidade'])
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
                        <input type="hidden" name="especialista_id" value="{{ isset($user) ? $user->getIdEspecialista($user->id) : '' }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>

    <script>
        //APLICAÇÃO DA MASCARA NO CELULAR
        document.getElementById('celular').addEventListener('input', function() {
            mascaraCelular(this)
        })
    </script>
@endsection
