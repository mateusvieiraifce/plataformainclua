@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Verificar Telefone')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Verificar telefone</h2>
                </div>
                <div class="card-body">                    
                    <form class="form" method="post" action="{{ route('usuario.validar_telefone') }}">
                        @csrf
                        <div class="form-group">
                            <label for="codigo">
                                Digite o código recebido por SMS <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('codigo') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="codigo" class="form-control border-full only-numbers {{ $errors->has('codigo') ? ' is-invalid' : '' }}"
                                    name="codigo" placeholder="Código" value="{{ old('codigo') }}" >
                                @include('alerts.feedback', ['field' => 'codigo'])
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Verificar') }}</button>
                        </div>
                        <input type="hidden" name="id_usuario" value="{{ $id_usuario }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>
@endsection
