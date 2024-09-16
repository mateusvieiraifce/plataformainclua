@extends('layouts.app', ['page' => __('Marcar Consulta'),'exibirPesquisa' => false, 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')
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
                <h4 class="title">Marcar consulta</h4>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="selectRota"  style="font-size: 15px;">Selecione a forma de escolha da consulta: </label>
                    <div class="form-group">
                        <div class="input-group">
                            <select id="selectRota" class="form-control" onchange="redirecionar()">
                                <option value="">Selecionar...</option>
                                <option value="{{route('paciente.marcarConsultaViaClinicaPasso1')}}">Escolher pela clínica</option>
                                <option value="{{route('paciente.marcarConsultaViaEspecialidadePasso1')}}">Escolher pela Especialidade</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'gravidez_programada'])
                        </div>
                    </div>
                </div>
                <!-- retorna para a tela dos pacientes, caso exista mais que 1-->
                <?php
                    $pacientes = App\Models\Paciente::where('usuario_id', '=', Auth::user()->id)->get();                    
                ?>  
                @if(sizeof($pacientes) > 1)
                    <a href="{{ route('paciente.marcarconsultaSelecionarPaciente') }}" class="btn btn-primary"><i class="fa fa-reply"></i> Voltar</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection