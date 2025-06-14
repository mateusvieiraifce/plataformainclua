@extends('layouts.app', ['class' => 'login-page', 'page' => __(''), 'contentClass' => 'login-page'])
@section('title', 'Login')
@section('content')
    @inject('configuracao', 'App\Models\Configuracao')

<div class="container">
    <div class="alert alert-danger">
        <h1>Erro {{ $error_code }}: {{ $error_message }}</h1>
        <p>Desculpe pelo inconveniente. Por favor, tente novamente mais tarde.</p>
        <a href="{{ route("home") }}" class="btn btn-primary">Voltar à página inicial</a>
    </div>
</div>
@endsection
