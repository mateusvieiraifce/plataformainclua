@extends('layouts.app', ['class' => 'login-page', 'page' => __(''), 'contentClass' => 'login-page'])
@section('title', 'Plataforma Inclua')



@section('content')
    <!-- breadcrumb -->

    <div class="container" style="height: 70%;">

        <p style="margin-top: 100px">
            {{$msg_compra}}
        </p>

    </div>

@endsection
