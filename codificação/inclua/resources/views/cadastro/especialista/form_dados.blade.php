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
                    <form class="form" method="post" action="{{ route('usuario.especialista.dados.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">
                                Imagem de perfil <span class="required">*</span>
                            </label>
                            <br>
                            <img class="img-avatar" src="{{ isset($user) ? asset($user->avatar) : asset('assets/img/default-avatar.png') }}" id="preview" alt="Avatar">
                            <div class="input-group input-medium{{ $errors->has('especialidade') ? ' has-danger' : '' }}">
                                <div class="custom-file">
                                    <input class="custom-file-input hidden" type="file" id="image" name="image" onchange="visualizarImagem(event)" accept="image/jpeg,image/jpg,image/png">
                                    <label class="btn custom-file-label input-medium {{ $errors->has('image') ? 'is-invalid' : '' }}" for="image"></label>
                                </div>
                                @include('alerts.feedback', ['field' => 'image'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="nome">
                                Nome <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('nome') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="nome" class="form-control border-full {{ $errors->has('nome') ? ' is-invalid' : '' }}"
                                    name="nome" placeholder="Nome Completo" value="{{ (isset($user) && $user->nome_completo ? $user->nome_completo : null) ?? old('nome') }}" required>
                                @include('alerts.feedback', ['field' => 'nome'])
                            </div>
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
                            <label for="celular">
                                Celular <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                <input type="text" id="celular" class="form-control border-full {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                    name="celular" maxlength="15" placeholder="(**) 9****-****"  oninput="mascaraCelular(this)"
                                    value="{{ (isset($user) && $user->celular ? $user->celular : null) ?? old('celular') }}" required>
                                @include('alerts.feedback', ['field' => 'celular'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="especialidade">
                                Especialidade <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('especialidade') ? ' has-danger' : '' }}">
                                <select name="especialidade" class="form-control border-full {{ $errors->has('especialidade') ? 'is-invalid' : '' }}" required>
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

                        <div class="form-group">
                            <label for="arquivo">
                                Certificado de Graduação/Especialização <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium column-gap-10{{ $errors->has('arquivo') ? ' has-danger' : '' }}">
                                <input class="form-control border-full disabled {{ $errors->has('arquivo') ? 'is-invalid' : '' }}" type="text" name="fileName" id="fileName" value="{{ isset($user) ? explode('/', $user->getCertificadoEspecialista())[2] : null }}" disabled required>
                                @if (isset($user) && $user->getCertificadoEspecialista())
                                    <a href="{{ asset($user->getCertificadoEspecialista()) }}" title="Baixar arquivo" download>
                                        <i class="zmdi zmdi-download zmdi-hc-3x"></i>
                                    </a>
                                @endif
                                @include('alerts.feedback', ['field' => 'arquivo'])
                            </div>
                            <div class="custom-file">
                                <input class="custom-file-input hidden" type="file" id="arquivo" name="arquivo" accept="application/pdf" onchange="showname('arquivo', 'fileName');" value="">
                                <label class="btn custom-file-label input-medium {{ $errors->has('arquivo') ? 'is-invalid' : '' }}" for="arquivo"></label>
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
