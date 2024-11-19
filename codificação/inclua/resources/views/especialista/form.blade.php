@extends('layouts.app', ['page' => __('especialista'), 'rotaPesquisa' => 'especialista.search', 'pageSlug' => 'especialista', 'class' => 'especialista'])
@section('title', 'Especialista')
@section('content')
    <form method="post" action="{{ route('especialista.save') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Dados do especialista</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nome_completo">
                                Nome
                            </label>
                            <div class="input-group{{ $errors->has('nome_completo') ? ' has-danger' : '' }}">
                                <input type="text" id="nome_completo" class="form-control {{ $errors->has('nome_completo') ? 'is-invalid' : '' }}"
                                    name="nome_completo" placeholder="Nome" value="{{ old('nome_completo') ?? (isset($especialista) ? $especialista->nome : null) }}">
                                @include('alerts.feedback', ['field' => 'nome_completo'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telefone">
                                Telefone
                            </label>
                            <div class="input-group{{ $errors->has('telefone') ? ' has-danger' : '' }}">
                                <input type="text" id="telefone" class="form-control {{ $errors->has('telefone') ? 'is-invalid' : '' }}"
                                    name="telefone" maxlength="14" placeholder="(**) ****-****" oninput="mascaraTelefone(this)"
                                    value="{{  old('telefone') ?? (isset($especialista) ? $especialista->getTelefone($especialista->usuario_id) : null) }}">
                                @include('alerts.feedback', ['field' => 'telefone'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="celular">
                                Celular
                            </label>
                            <div class="input-group{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                <input type="text" id="celular" class="form-control {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                    name="celular" maxlength="15" placeholder="(**) 9****-****" oninput="mascaraCelular(this)"
                                    value="{{ old('celular') ?? (isset($especialista) ? $especialista->getCelular($especialista->usuario_id) : null) }}">
                                @include('alerts.feedback', ['field' => 'celular'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="especialidade_id">
                                Especialidade
                            </label>
                            <div class="input-group{{ $errors->has('especialidade_id') ? ' has-danger' : '' }}">
                                <select name="especialidade_id" class="form-control {{ $errors->has('especialidade_id') ? 'is-invalid' : '' }}">
                                    @foreach($especialidades as $especialidade)
                                        <option value="{{ $especialidade->id }}" @if ($especialidade->id == old('especialidade_id')) selected @endif>
                                            {{ $especialidade->descricao }}
                                        </option>
                                    @endforeach
                                </select>
                                @include('alerts.feedback', ['field' => 'especialidade_id'])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Dados bancários</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="conta_bancaria">
                                Conta Bancária
                            </label>
                            <div class="input-group {{ $errors->has('conta_bancaria') ? ' has-danger' : '' }}">
                                <input type="text" id="conta_bancaria" class="form-control {{ $errors->has('conta_bancaria') ? ' is-invalid' : '' }}"
                                    name="conta_bancaria" placeholder="Número da conta bancária" value="{{ (isset($especialista) && $especialista->conta_bancaria ? $especialista->conta_bancaria : null) ?? old('conta_bancaria') }}">
                                @include('alerts.feedback', ['field' => 'conta_bancaria'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="agencia">
                                Agência
                            </label>
                            <div class="input-group {{ $errors->has('agencia') ? ' has-danger' : '' }}">
                                <input type="text" id="agencia" class="form-control {{ $errors->has('agencia') ? ' is-invalid' : '' }}"
                                    name="agencia" placeholder="Agência" value="{{ (isset($especialista) && $especialista->agencia ? $especialista->agencia : null) ?? old('agencia') }}">
                                @include('alerts.feedback', ['field' => 'agencia'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="banco">
                                Banco
                            </label>
                            <div class="input-group{{ $errors->has('banco') ? ' has-danger' : '' }}">
                                <input type="text" id="banco" class="form-control {{ $errors->has('banco') ? 'is-invalid' : '' }}"
                                    name="banco" placeholder="Nome do banco" value="{{ (isset($especialista) && $especialista->banco ? $especialista->banco : null) ?? old('banco') }}">
                                @include('alerts.feedback', ['field' => 'banco'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="chave_pix">
                                Pix
                            </label>
                            <div class="input-group{{ $errors->has('chave_pix') ? ' has-danger' : '' }}">
                                <input type="text" id="chave_pix" class="form-control {{ $errors->has('chave_pix') ? 'is-invalid' : '' }}"
                                    name="chave_pix" maxlength="15" placeholder="Chave pix" value="{{ (isset($especialista) && $especialista->chave_pix ? $especialista->chave_pix : null) ?? old('chave_pix') }}">
                                @include('alerts.feedback', ['field' => 'chave_pix'])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Dados do usuário</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="email">
                                E-mail para login
                            </label>
                            <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input type="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    name="email" placeholder="E-mail" value="{{ old('email') ?? (isset($usuario) ? $usuario->email : null) }}">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">
                                Senha
                            </label>
                            <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <input type="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    name="password" placeholder="Senha" @if(!isset($especialista)) required @endif 
                                    value="" minlength="8" maxlength="15">
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">
                                Confirmar senha
                            </label>
                            <div class="input-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                <input type="password" id="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                    name="password_confirmation" placeholder="Confirmar senha" @if(!isset($especialista)) required @endif 
                                    value="" minlength="8" maxlength="15">
                                @include('alerts.feedback', ['field' => 'password_confirmation'])
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{route('especialista.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i> Voltar</a>
                            <button class="btn btn-primary" onclick="$('#send').click();"><i class="fa fa-save"></i> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-user">
                    <div class="card-body">
                        <p class="card-text">
                            <div class="author">
                                <div class="block block-one"></div>
                                <div class="block block-two"></div>
                                <div class="block block-three"></div>
                                <h3 class="title">Avatar</h3>
                                <a href="#">
                                    @if((isset($usuario) && $usuario->avatar) || (!isset($usuario) && auth()->user()->avatar))
                                        <img class="avatar" id="preview" src="{{ isset($usuario) ? $usuario->avatar : auth()->user()->avatar }}">
                                    @else
                                        <img class="avatar" id="preview" src={{ asset("assets/img/anime3.png") }} alt="IMG-LOGO">
                                    @endif
                                </a>
                            </div>
                        </p>
                        <div class="custom-file justify-content-center">
                            <input class="custom-file-input hidden" type="file" id="image" name="image" onchange="visualizarImagem(event)" accept="image/jpeg,image/jpg,image/png">
                            <label class="btn custom-file-label {{ $errors->has('image') ? 'is-invalid' : '' }}" for="image">Alterar imagem</label>
                        </div>
                        @include('alerts.feedback', ['field' => 'image'])
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="especialista_id" value="{{ isset($especialista) ? $especialista->id : null}}">
        <input type="hidden" name="usuario_id" value="{{ isset($usuario) ? $usuario->id : null}}">
    </form>
    <script>
        function visualizarImagem(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var preview = document.getElementById('preview');
                preview.src = reader.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection