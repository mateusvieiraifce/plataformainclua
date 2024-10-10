@extends('layouts.app', ['page' => __('Pacientes'), 'exibirPesquisa' => false, 'pageSlug' => 'pacientes', 'class' => 'pacientes'])
@section('title', 'Prontuário')
@section('content')
<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="title d-inline">Dados do paciente</h6>

                <div class="card-header">
                    <div class="row">
                        <div class="col-4 col-lg-2">
                            <div class="photo">
                                <img src="/assets/img/anime3.png" alt="{{ __('Profile Photo') }}"
                                    style="height: 100px; width: 100px;">
                            </div>
                        </div>
                        <div class="col-4 col-lg-3">
                            <h6 class="title d-inline">Paciente: {{$paciente->nome}}</h6>
                            <br>
                            <h6 id="idadePaciente" class="title d-inline">
                                {{date('d/m/Y', strtotime($usuarioPaciente->data_nascimento))}}
                            </h6>
                        </div>
                        <div class="col-4 col-lg-4">                           
                            <h6 class="title d-inline">Total de consultas realizadas: {{$qtdConsultasRealizadas}}</h6>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card-body">
                <div class="table-responsive">

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="title d-inline">Dados das consultas</h6>

                <div class="card-header">
                    <div class="row">

                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="title d-inline">Exames</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="title d-inline">Prescrições</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection