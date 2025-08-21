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

<?php
$pacientes = session()->get('paciente_id');
//   App\Models\Paciente::where('usuario_id', '=', Auth::user()->id)->first();

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-header">

                <a href="{{route('paciente.marcarconsulta.presencial', $pacientes)}}" class="btn btn-secundary btn-round btn-lg header-links">
                    <i class="tim-icons icon-single-02"></i>
                    <br>
                    <label style="width: 150px"> Consulta Presencial</label>
                </a>
                <a href="{{ route('paciente.marcarConsultaTeleAtendimentoPasso1') }}" class="btn btn-secundary btn-round btn-lg header-links">
                    <i class="tim-icons icon-video-66"></i>
                    <br>
                    <label style=" width: 150px">Teleatendimento</label>
                </a>

            </div>
            <!-- retorna para a tela dos pacientes, caso exista mais que 1-->


            <div class="card-body">




            </div>
        </div>
    </div>
</div>
@endsection
