@extends('layouts.app', ['page' => __('minhas consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'minhasconsultas', 'class' => 'consulta'])
@section('title', 'Minhas consultas')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Lista de consultas agendadas</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if(sizeof($consultas) > 0)
                            <table class="table">
                                <thead>
                                    <th>Paciente</th>
                                    <th>Horário agendado</th>
                                    <th>Dia</th>
                                    <th>Médico</th>
                                    <th>Especialidade</th>
                                    <th>Clínica</th>
                                    <th>Cancelar</th>
                                </thead>
                                <tbody>
                                    @foreach($consultas as $consulta)
                                        <tr>
                                            <td>
                                                {{ $consulta->nome }}
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
                                            <td>
                                                <a href="#" target="_blank" rel="tooltip" title="Cancelar consulta" class="btn btn-link" data-original-title="Cancelar consulta"
                                                    href="#" data-target="#modal-form" data-toggle="modal" data-whatever="@mdo" onclick="setModal({{ $consulta->id }}, {{ \App\Helper::verificarPrazoCancelamentoGratuito($consulta->horario_agendado) }})">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $consultas->appends(request()->query())->links() }}
                        @else
                            <h5>Não há nenhuma consulta agendada.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL CANCELAR CONSULTA --}}
    @component('layouts.modal_form', ["title" => "Favor inserir o motivo do cancelamento!", "route" => route('paciente.consulta.cancelar'), "textButton" => "Cancelar consulta"])
        <div class="form-group">
            <label id="subTitle" class="title td-inline">Ao cancelar a consulta será cobrado uma taxa de R$ {{ env('TAXA_CANCELAMENTO_CONSULTA') }}</label>
            <textarea id="motivoCancelamento" name="motivo_cancelamento" rows="5" cols="50" maxlength="500" placeholder="Digite o motivo do cancelamento aqui..." required></textarea>
        </div>
        <input type="hidden" id="consulta_id" name="consulta_id" value="">
    @endcomponent

    <script>
        function setModal(consulta_id, cancelamentoGratuito) {
            $("#consulta_id").val(consulta_id);
            if (cancelamentoGratuito) {
                $("#subTitle").css("display", "none");
            } else {
                $("#subTitle").css("display", "block");
            }
        }
    </script>
@endsection
