@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro Endereço')
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
                    <form class="form" method="post" action="{{ route('endereco.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="cep">
                                CEP <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('cep') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="cep" class="form-control border-full {{ $errors->has('cep') ? ' is-invalid' : '' }}"
                                    name="cep" maxlength="9" placeholder="CEP" onkeydown="" onblur="mascaraCep(this); validarCep(this.value)" value="{{ old('cep') }}" >
                                @include('alerts.feedback', ['field' => 'cep'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cidade">
                                Cidade <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('cidade') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="cidade" class="form-control border-full {{ $errors->has('cidade') ? ' is-invalid' : '' }}"
                                    name="cidade" placeholder="Cidade" value="{{ old('cidade') }}" >
                                @include('alerts.feedback', ['field' => 'cidade'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="estado">
                                Estado <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('estado') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="estado" class="form-control border-full {{ $errors->has('estado') ? ' is-invalid' : '' }}"
                                    name="estado" placeholder="Estado" value="{{ old('estado') }}">
                                @include('alerts.feedback', ['field' => 'estado'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="endereco">
                                Endereço <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('endereco') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="endereco" class="form-control border-full {{ $errors->has('endereco') ? ' is-invalid' : '' }}"
                                    name="endereco" placeholder="Endereço" value="{{ old('endereco') }}">
                                @include('alerts.feedback', ['field' => 'endereco'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="numero">
                                Número <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('numero') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="numero" class="form-control border-full only-numbers {{ $errors->has('numero') ? ' is-invalid' : '' }}"
                                    name="numero" placeholder="Número" value="{{ old('numero') }}">
                                @include('alerts.feedback', ['field' => 'numero'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="complemento">
                                Complemento
                            </label>
                            <div class="input-group {{ $errors->has('complemento') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="complemento" class="form-control border-full only-numbers {{ $errors->has('complemento') ? ' is-invalid' : '' }}"
                                    name="complemento" placeholder="Complemento" value="{{ old('complemento') }}">
                                @include('alerts.feedback', ['field' => 'complemento'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="bairro">
                                Bairro <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('bairro') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="bairro" class="form-control border-full only-numbers {{ $errors->has('bairro') ? ' is-invalid' : '' }}"
                                    name="bairro" placeholder="Bairro" value="{{ old('bairro') }}">
                                @include('alerts.feedback', ['field' => 'bairro'])
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Próximo') }}</button>
                        </div>
                        <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>
    @include("layouts.modal_aviso")
@endsection
