@extends('layouts.app', ['page' => __('especialidade'), 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')
<style>
    .card-custom {
        background-color: #17a2b8;
        /* Cor de fundo azul */
        color: #fff;
        /* Cor do texto branco */
        border-color: #17a2b8;
        /* Cor da borda igual à cor de fundo */
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Marcar consulta </h5>
            </div>
            <div class="card-body">

                <div class="container">
                    <div class="card card-custom">
                        <div class="card-body">
                            <h5 class="card-title">Escolha pela clínica</h5>
                            <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i> Próximo</button>
                        </div>
                    </div>
                    <div class="card card-custom">
                        <div class="card-body">
                            <h5 class="card-title">Escolha pela especialidade</h5>
                            <button class="btn btn-success" onclick="$('#send').click(); "><i class="tim-icons icon-minimal-right"></i> Próximo</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection