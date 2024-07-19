@extends('layouts.app', ['page' => __('Marcar Consulta'),'exibirPesquisa' => false, 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
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

<script>
    function redirecionar() {
        var selectBox = document.getElementById("selectRota");
        var rotaSelecionada = selectBox.value;
        window.location.href = rotaSelecionada; // Redireciona para a rota selecionada
    }
</script>


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="title">Marcar consulta </h5>
            </div>
            <div class="card-body">
                <div class="container">
                <div class="card-body">
                    <div class="col-md-12 px-8">
                        <div class="form-group">
                            <label for="selectRota"  style="font-size: 15px;">Selecione a forma de escolha da consulta: </label>
                            <select id="selectRota" onchange="redirecionar()">
                                <option value="">Selecionar...</option>
                                <option value="{{route('paciente.marcarConsultaViaClinicaPasso1')}}">Escolher pela clínica</option>
                                <option value="{{route('paciente.marcarConsultaViaEspecialidadePasso1')}}">Escolher pela Especialidade</option>
                            </select>
                        </div>
                    </div>
                    </div>                 
                </div>

            </div>
        </div>
    </div>
</div>

@endsection