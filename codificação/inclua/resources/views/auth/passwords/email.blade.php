@extends('layouts.app', ['class' => 'login-page', 'page' => __('Reset password'), 'contentClass' => 'login-page'])

@section('content')
    @inject('configuracao', 'App\Models\Configuracao')

<style>
    /* Estilos do Card e Responsividade */
    .card-header img {
        width: 50%;
        margin: 7rem 0 0 9.2rem;
        display: block;
    }

    .input-group {
        position: relative;
        top: 13rem;
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
            margin: 10rem 0 0 6.2rem;
            display: block;
        }

    }
</style>

<div class="col-lg-5 col-md-7 ml-auto mr-auto" style="margin-top: 7.5rem; margin-left: auto; margin-right: auto">
    <form class="form" method="post" action="{{ route('recover.do') }}">
        @csrf
        <div class="card card-login card-white" style="width: 38.4rem; height: 29.7rem;">
            <div class="card-header text-center">
                <img src="{{ !empty($configuracao->getLogo()) ? asset($configuracao->getLogo()) : asset('assets/img/logo-01.png') }}" alt="Logo Plataforma Inclua">
            </div>

            <div class="card-body">
                @include('alerts.success')

                <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="tim-icons icon-email-85"></i>
                        </div>
                    </div>
                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" required>
                    @include('alerts.feedback', ['field' => 'email'])
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">{{ __('Enviar link de reset da senha') }}</button>
            </div>
        </div>
    </form>
</div>

@endsection
