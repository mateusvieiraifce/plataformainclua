@extends('layouts.app', ['page' => __('Marcar Consulta - Modalidade'),'exibirPesquisa' => false, 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
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
                <h6 class="title d-inline">Selecione a Modalidade</h6>
            </div>
            <!-- retorna para a tela dos pacientes, caso exista mais que 1-->
            <?php
            $pacientes = session()->get('paciente_id');
             //   App\Models\Paciente::where('usuario_id', '=', Auth::user()->id)->first();

            ?>

            <div class="card-body">
                <div class="form-group">
                    <label for="selectRota"  style="font-size: 15px;">Selecione a forma de escolha da consulta: </label>
                    <div class="form-group">
                        <div class="input-group">
                            <select id="selectRota" class="form-control" onchange="redirecionar()">
                                <option value="">Selecionar...</option>
                                <option value="{{route('paciente.marcarconsulta.presencial', $pacientes)}}">Presencial</option>
                                <option value="#">Teleatendimento</option>
                            </select>
                            @include('alerts.feedback', ['field' => 'gravidez_programada'])
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
