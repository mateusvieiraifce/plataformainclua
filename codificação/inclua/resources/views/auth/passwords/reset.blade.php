@extends('layouts.app', ['class' => 'login-page', 'page' => __('Reset password'), 'contentClass' => 'login-page'])

<style>
    /* Estilos do Card e Responsividade */
    .card-header img {
        width: 50%;
        margin: 3rem 0 0 9.2rem;
        display: block;
    }

    .input-group {
        position: relative;
        top: 3rem;
    }
    .content{
        margin-left: -200px;
        margin-right: auto;
    }

    /* Responsividade: ajuste para que o card não ultrapasse a largura da tela */
    @media (max-width: 600px) {
        .card {
            overflow: hidden;
            width: 38.4rem;
            max-width: 100%;
            height: 29.7rem;
            margin: 0 auto;
        }
        .content{
            margin-left: auto;
            margin-right: auto;
        }

        .card-header img {
            width: 50%;
            margin: 5rem 0 0 6.2rem;
            display: block;
        }

    }
</style>
@section('content')
    <div class="col-lg-5 col-md-7 ml-auto mr-auto">
        <form class="form" method="post" action="{{route('update.password')}}">
            @csrf

            <div class="card card-login card-white">
                <div class="card-header">
                    <img src="/assets/img/logo-01.png" alt="">
                    <h1 class="card-title"></h1>
                </div>
                <div class="card-body">
                    @include('alerts.success')

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-email-85"></i>
                            </div>
                        </div>
                        <input type="email" name="email" value="{{$usuario->email}}" readonly class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}">
                        @include('alerts.feedback', ['field' => 'email'])
                        <input type="hidden" name="id" value="{{$usuario->id}}">
                    </div>
                    <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-lock-circle"></i>
                                </div>
                            </div>
                            <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Senha') }}">
                            @include('alerts.feedback', ['field' => 'password'])
                        </div>
                        <div class="input-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="tim-icons icon-lock-circle"></i>
                                </div>
                            </div>
                            <input type="password" name="password_confirmation" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" placeholder="{{ __('Confirmação da senha') }}">
                            @include('alerts.feedback', ['field' => 'password_confirmation'])
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">{{ __('Atualizar Senha') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection
