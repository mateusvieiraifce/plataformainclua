@extends('layouts.app', ['class' => 'login-page', 'page' => __(''), 'contentClass' => 'login-page'])

@section('content')

    <style>
        .cookie-banner {
            position: fixed;
            top: 10%;
            left: 10%;
            right: 10%;
            width: 80%;
            padding: 5px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
           // background-color: #eee;
            border-radius: 5px;
            box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
        }
        .close {
            height: 20px;
            background-color: #777;
            border: none;
            color: white;
            border-radius: 2px;
            cursor: pointer;
        }
    </style>
    <div class='cookie-banner' style=''>
        <p>
            Para usar nossa plataforma, você aceita nossa
            <a href='/docs/privacidade.pdf'>Política de privacidade</a>
        </p>
        <button class='close' onclick="$('.cookie-banner').fadeOut();">&times;</button>
    </div>
    <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
    <script>
        if (localStorage.getItem('cookieSeen') != 'shown') {
            $('.cookie-banner').delay(2000).fadeIn();
            localStorage.setItem('cookieSeen','shown')
        };
    </script>

    <div class="col-md-10 text-center ml-auto mr-auto">
        <h3 class="mb-5"></h3>
    </div>
    <div class="col-lg-4 col-md-6 ml-auto mr-auto">
        <form class="form" method="post" action="{{ route('login') }}">
            @csrf

            <div class="card card-login card-white">
                <div class="card-header">
                    <img src="/assets/img/logo-01.png" alt="">
                    <h2 class="card-title"></h2>
                </div>
                <div class="card-body">
                    <p class="text-dark mb-2">Entre com seu usuário e senha</p>
                    <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-email-85"></i>
                            </div>
                        </div>
                        <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}">
                        @include('alerts.feedback', ['field' => 'email'])
                    </div>
                    <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="tim-icons icon-lock-circle"></i>
                            </div>
                        </div>
                        <input type="password" placeholder="{{ __('Password') }}" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}">
                        @include('alerts.feedback', ['field' => 'password'])
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" href="" class="btn btn-primary btn-lg btn-block mb-3">{{ __('Entrar') }}</button>
                    <div class="pull-left">
                        <h6>
                            <a href="{{route('registre')}}" class="link footer-link">{{ __('Criar uma conta') }}</a>
                        </h6>
                        <h6>
                            <a href="{{route('google.redi')}}" class="link footer-link">{{ __('Entrar com google') }}</a>
                        </h6>
                    </div>
                    <div class="pull-right">
                        <h6>
                            <a href="{{route('recover')}}" class="link footer-link">{{ __('Esqueceu a senha?') }}</a>
                        </h6>
                    </div>
                </div>
            </div>
        </form>
    </div>


@endsection
