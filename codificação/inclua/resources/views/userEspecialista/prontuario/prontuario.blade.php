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
                                @if($paciente->avatar)
                                    {!!  Html::image(Storage::url('avatar-user/paciente/'.$paciente->avatar)) !!}
                                @else
                                    @if($usuarioPaciente->avatar)
                                        {!! Html::image($usuarioPaciente->avatar) !!}
                                     @else
                                    <img src="/assets/img/anime3.png" alt="{{ __('Profile Photo') }}"
                                         style="height: 100px; width: 100px;">
                                    @endif
                                @endif


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
                    <table class="table">
                        <thead>
                        <tr>
                            <th> Consultas </th>
                            <th> </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(sizeof($prontuarios) > 0)
                            @foreach($prontuarios as $prontuario)
                                <tr>
                                    <td> {{$prontuario->dados_consulta}} </td>
                                    <td>
                                        {{date( 'd/m/Y' , strtotime($prontuario->horario_agendado))}}

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    {{ $prontuarios->links() }}
                </div>
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-lg-8 col-md-12">
<div class="card">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="title d-inline">Exames solicitados</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table">
                                       <thead>
                                          <tr>
                                             <th> Exames </th>
                                             <th> </th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @if(sizeof($listaPedidosExames) > 0)
                                       @foreach($listaPedidosExames as $pedidoexame)
                                          <tr>
                                             <td> {{$pedidoexame->nome}} </td>
                                             <td>
                                             {{date( 'd/m/Y' , strtotime($pedidoexame->data_pedido))}}

                                             </td>
                                          </tr>
                                          @endforeach
                                          @endif
                                       </tbody>
                                    </table>
                                    {{ $listaPedidosExames->appends(request()->query())->links() }}
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="title d-inline">Prescrições</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                <table class="table">
                                       <thead>
                                          <tr>
                                             <th> Medicamentos </th>
                                             <th> </th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @if(sizeof($listaPedidosMedicamentos) > 0)
                                       @foreach($listaPedidosMedicamentos as $pedidoMedicamento)
                                          <tr>
                                             <td> {{$pedidoMedicamento->nome_comercial}} </td>
                                             <td>
                                             {{date( 'd/m/Y' , strtotime($pedidoMedicamento->data_pedido))}}
                                             </td>
                                          </tr>
                                          @endforeach
                                          @endif
                                       </tbody>
                                    </table>
                                    {{ $listaPedidosMedicamentos->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
