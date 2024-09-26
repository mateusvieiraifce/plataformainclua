@extends('layouts.app', ['page' => __('home'), 'exibirPesquisa' => false, 'pageSlug' => 'home', 'class' => 'home'])
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <!-- caso o paciente nao possua dependete abrir loga a tela de selecionar clinica/especialista-->
                    <?php
                        $pacientes = App\Models\Paciente::where('usuario_id', '=', Auth::user()->id)->get();                    
                    ?>  
                    @if(sizeof($pacientes) > 1)
                        <a href="{{ route('paciente.marcarconsultaSelecionarPaciente') }}"
                            class="btn btn-secundary btn-round btn-lg header-links">
                    @else                       
                        <a href="{{ route('paciente.marcarconsulta') }}"
                            class="btn btn-secundary btn-round btn-lg header-links">
                    @endif                 
                            <i class="tim-icons icon-calendar-60 "></i>
                            <br>
                            Marcar consulta
                    </a>
                    <a href="{{ route('paciente.minhasconsultas') }}" class="btn btn-secundary btn-round btn-lg header-links">
                        <i class="tim-icons icon-notes"></i>
                        <br>
                        Minhas consultas
                    </a>
                    <a href="#" class="btn btn-secundary btn-round btn-lg header-links">
                        <i class="tim-icons icon-components"></i>
                        <br>
                        Exames
                    </a>
                    <a href="{{ route('paciente.financeiro') }}" class="btn btn-secundary btn-round btn-lg header-links">
                        <i class="tim-icons icon-money-coins"></i>
                        <br>
                        Financeiro
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        <h4>Suas próximas consultas</h4>
                        @if(sizeof($consultas) > 0)
                            <table class="table">
                                <thead>
                                    <th>Paciente</th>
                                    <th>Horário</th>
                                    <th>Dia</th>
                                    <th>Médico</th>
                                    <th>Especialidade</th>
                                    <th>Clínica</th>
                                </thead>
                                <tbody>
                                    @foreach($consultas as $consulta)
                                        <tr>
                                            <td>
                                                {{ $consulta->nome_paciente }}
                                            </td>                                    
                                            <td>
                                                {{ date( 'H:i' , strtotime($consulta->horario_agendado)) }}
                                            </td>
                                            <td>
                                                {{ date( 'd/m/Y' , strtotime($consulta->horario_agendado)) }}
                                            </td>
                                            <td>
                                                {{ $consulta->nome_especialista }}
                                            </td>
                                            <td>
                                                {{ $consulta->descricao_especialidade }}
                                            </td>
                                            <td>
                                                {{ $consulta->nome_clinica }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $consultas->appends(request()->query())->links() }}
                        @else
                            <h5>Você ainda não tem consulta agendada.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection