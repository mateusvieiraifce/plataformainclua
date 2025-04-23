@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro de Dados Bancários')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Cadastro de Dados Bancários</h2>
                </div>
                <div class="card-body">                    
                    <form class="form" method="post" action="{{ route('dados-bancarios.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="conta_bancaria">
                                Conta Bancária <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('conta_bancaria') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="conta_bancaria" class="form-control border-full {{ $errors->has('conta_bancaria') ? ' is-invalid' : '' }}"
                                    name="conta_bancaria" placeholder="Número da conta bancária" value="{{ (isset($especialista) && $especialista->conta_bancaria ? $especialista->conta_bancaria : null) ?? old('conta_bancaria') }}">
                                @include('alerts.feedback', ['field' => 'conta_bancaria'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="agencia">
                                Agência <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('agencia') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="agencia" class="form-control border-full {{ $errors->has('agencia') ? ' is-invalid' : '' }}"
                                    name="agencia" placeholder="Agência" value="{{ (isset($especialista) && $especialista->agencia ? $especialista->agencia : null) ?? old('agencia') }}">
                                @include('alerts.feedback', ['field' => 'agencia'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="banco">
                                Banco <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('banco') ? ' has-danger' : '' }}">
                                <input type="text" id="banco" class="form-control border-full {{ $errors->has('banco') ? 'is-invalid' : '' }}"
                                    name="banco" placeholder="Nome do banco" value="{{ (isset($especialista) && $especialista->banco ? $especialista->banco : null) ?? old('banco') }}">
                                @include('alerts.feedback', ['field' => 'banco'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="chave_pix">
                                Pix <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('chave_pix') ? ' has-danger' : '' }}">
                                <input type="text" id="chave_pix" class="form-control border-full {{ $errors->has('chave_pix') ? 'is-invalid' : '' }}"
                                    name="chave_pix" maxlength="15" placeholder="Chave pix" value="{{ (isset($especialista) && $especialista->chave_pix ? $especialista->chave_pix : null) ?? old('chave_pix') }}">
                                @include('alerts.feedback', ['field' => 'chave_pix'])
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Finalizar') }}</button>
                        </div>
                        <input type="hidden" name="usuario_id" value="{{ $usuario_id ?? $user->id }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
