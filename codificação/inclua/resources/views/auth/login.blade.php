@extends('layouts.app2', ['class' => 'login-page', 'page' => __(''), 'contentClass' => 'login-page'])
@section('title', 'Login')
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
            background-color: #eee;
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
    {{-- <div class='cookie-banner' style=''>
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
    </script> --}}
   <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="post" action="{{ route('login.do') }}">
                    @csrf
                    <div class="image-inclua" style="text-align: left; position: relative;">
                        <img src="images/logo-01.png" style="position: relative; top: -7.5rem; width: 100px;">
                    </div>
                    <span class="login100-form-title p-b-43" style="color: #3b57d2; font-size: 2.77rem; font-family: 'Dosis', sans-serif;">
                        Bem-vindo(a) de volta!
                    </span>
                    <span class="sub-title">
                        Entre com seu usuário e senha
                    </span>
                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz" style="">
                        <input class="input100" type="email" name="email" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">
                            Email
                            <i class="fas fa-user" style="margin-left: 5px;"></i> <!-- Ícone de pessoa -->
                        </span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="password" required>
                        <span class="focus-input100"></span>
                        <span class="label-input100">
                            Senha
                            <i class="fas fa-lock" style="margin-left: 5px;"></i> <!-- Ícone de cadeado -->
                        </span>
                    </div>
                    <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div class="text-right"> <!-- Adicione esta classe para garantir que o conteúdo esteja alinhado à direita -->
                            <a href="{{route('recover')}}" class="txt1">
                                Esqueci minha senha 
                            </a>
                        </div>
                    </div>
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn" >
                            Login
                        </button>
                    </div>
                    <div class="container-login100-form-btn-google" style="margin-top: 4px;">
                        <a href="{{ route('google.redirect') }}" class="login100-form-btn-google" style="text-decoration: none;">
                            <i class="fab fa-google google-icon"></i> <!-- Ícone do Google -->
                            Entrar com o Google
                        </a>
                    </div>
                    <div class="text-center p-t-46 p-b-20" style="font-size : 10px; font-weight: 80px;">
                        <span class="txt2">
                            Ainda não tem uma conta? <a href="{{ route('usuario.create') }}">Cadastre-se!</a>
                        </span>
                    </div>
                </form>
                <div class="login100-more" style="background-image: url('images/pikaso_embed.png');">
                </div>
            </div>
        </div>
    </div>
    
        
    


@endsection
