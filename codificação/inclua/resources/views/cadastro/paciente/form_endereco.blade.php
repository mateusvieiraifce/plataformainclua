@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro de Endereço')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Cadastro de endereço</h2>
                </div>
                <div class="card-body">                    
                    <form class="form" method="post" action="{{ route('paciente.endereco.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="cep">
                                CEP <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('cep') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="cep" class="form-control border-full {{ $errors->has('cep') ? ' is-invalid' : '' }}"
                                    name="cep" maxlength="9" placeholder="CEP" onblur="validarCep(this)" value="{{ (isset($user) ? $user->cep : null) ?? old('cep') }}">
                                @include('alerts.feedback', ['field' => 'cep'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cidade">
                                Cidade <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('cidade') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="cidade" class="form-control border-full {{ $errors->has('cidade') ? ' is-invalid' : '' }}"
                                    name="cidade" placeholder="Cidade" value="{{ (isset($user) ? $user->cidade : null) ?? old('cidade') }}" >
                                @include('alerts.feedback', ['field' => 'cidade'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="estado">
                                Estado <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('estado') ? ' has-danger' : '' }}">
                                <input id="estado" list="estados" name="estado" class="form-control border-full {{ $errors->has('estado') ? 'is-invalid' : '' }}"
                                    placeholder="Selecione o estado" value="{{ (isset($user) ? $user->estado : null) ?? old('estado') }}" required>
                                <datalist id="estados" name="estado">
                                    <option value="AC">Acre</option>
                                    <option value="AL">Alagoas</option>
                                    <option value="AP">Amapá</option>
                                    <option value="AM">Amazonas</option>
                                    <option value="BA">Bahia</option>
                                    <option value="CE">Ceará</option>
                                    <option value="DF">Distrito Federal</option>
                                    <option value="ES">Espírito Santo</option>
                                    <option value="GO">Goiás</option>
                                    <option value="MA">Maranhão</option>
                                    <option value="MT">Mato Grosso</option>
                                    <option value="MS">Mato Grosso do Sul</option>
                                    <option value="MG">Minas Gerais</option>
                                    <option value="PA">Pará</option>
                                    <option value="PB">Paraíba</option>
                                    <option value="PR">Paraná</option>
                                    <option value="PE">Pernambuco</option>
                                    <option value="PI">Piauí</option>
                                    <option value="RJ">Rio de Janeiro</option>
                                    <option value="RN">Rio Grande do Norte</option>
                                    <option value="RS">Rio Grande do Sul</option>
                                    <option value="RO">Rondônia</option>
                                    <option value="RR">Roraima</option>
                                    <option value="SC">Santa Catarina</option>
                                    <option value="SP">São Paulo</option>
                                    <option value="SE">Sergipe</option>
                                    <option value="TO">Tocantins</option>
                                </datalist>
                                @include('alerts.feedback', ['field' => 'estado'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="endereco">
                                Endereço <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('endereco') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="endereco" class="form-control border-full {{ $errors->has('endereco') ? ' is-invalid' : '' }}"
                                    name="endereco" placeholder="Endereço" value="{{ (isset($user) ? $user->endereco : null) ?? old('endereco') }}">
                                @include('alerts.feedback', ['field' => 'endereco'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="numero">
                                Número <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('numero') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="numero" class="form-control border-full only-numbers {{ $errors->has('numero') ? ' is-invalid' : '' }}"
                                    name="numero" placeholder="Número" value="{{ (isset($user) ? $user->numero : null) ?? old('numero') }}">
                                @include('alerts.feedback', ['field' => 'numero'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="bairro">
                                Bairro <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('bairro') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="bairro" class="form-control border-full {{ $errors->has('bairro') ? ' is-invalid' : '' }}"
                                    name="bairro" placeholder="Bairro" value="{{ (isset($user) ? $user->bairro : null) ?? old('bairro') }}">
                                @include('alerts.feedback', ['field' => 'bairro'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="complemento">
                                Complemento
                            </label>
                            <div class="input-group {{ $errors->has('complemento') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="complemento" class="form-control border-full {{ $errors->has('complemento') ? ' is-invalid' : '' }}"
                                    name="complemento" placeholder="Complemento" value="{{ (isset($user) ? $user->complemento : null) ?? old('complemento') }}">
                                @include('alerts.feedback', ['field' => 'complemento'])
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Próximo') }}</button>
                        </div>
                        <input type="hidden" name="usuario_id" value="{{ $usuario_id }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            //APLICAÇÃO DA MASCARA NO CEP
            document.getElementById('cep').addEventListener('input', function() {
                mascaraCep(this)
            })
        });
    </script>
@endsection
