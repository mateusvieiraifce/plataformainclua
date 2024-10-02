@extends('layouts.app', ['page' => __('Histórico de consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'historicoconsultas', 'class' => 'consulta'])
@section('title', 'Minhas consultas')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Lista de consultas realizadas</h6>              
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if(sizeof($consultas) > 0)
                            <table class="table">
                                <thead>
                                    <th>Paciente</th>
                                    <th>Horário</th>
                                    <th>Dia</th>
                                    <th>Médico</th>
                                    <th>Especialidade</th>
                                    <th>Clínica</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    @foreach($consultas as $consulta)
                                        <tr>
                                            <td>
                                                {{ explode(' ', $consulta->nome_paciente)[0] . " " . explode(' ', $consulta->nome_paciente)[1] }}
                                            </td>
                                            <td>
                                                {{ date( 'H:i', strtotime($consulta->horario_agendado)) }}
                                            </td>
                                            <td>
                                                {{ date( 'd/m/Y', strtotime($consulta->horario_agendado)) }}
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
                                                {{ $consulta->status }}
                                            </td>
                                            <td class="avaliar-{{ $consulta->id }}">
                                                @if($consulta->status != "Cancelada" && $consulta->noHasAvaliacao())
                                                    <a href="#" target="_blank" rel="tooltip" title="Avaliar consulta" data-original-title="Avaliar consulta"
                                                        data-target="#modal-form" data-toggle="modal" data-whatever="@mdo" onclick="setModal({{ $consulta->id }})">
                                                        <i class="fa fa-star"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                           {{ $consultas->appends(request()->query())->links() }}
                        @else
                            <h5>Não há nenhuma consulta realizada.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DE AVALIAÇÃO --}}
    @component('layouts.modal_form', ["title" => "Como foi a sua consulta?", "route" => route('paciente.avaliacao.store'), "textButton" => "Salvar"])
        <h4>Avalie o especialista</h4>
        <div class="form-group multiple-inputs-inline">
            <div>
                <label>
                    Atendimento
                </label>
                <div class="star-rating avaliacao">
                    <label class="star selected" id="especialista-atendimento-1" data-value="1">&#9733;</label>
                    <label class="star selected" id="especialista-atendimento-2" data-value="2">&#9733;</label>
                    <label class="star selected" id="especialista-atendimento-3" data-value="3">&#9733;</label>
                    <label class="star selected" id="especialista-atendimento-4" data-value="4">&#9733;</label>
                    <label class="star selected" id="especialista-atendimento-5" data-value="5">&#9733;</label>
                </div>
                <input id="especialista-atendimento" type="hidden" name="especialista_atendimento" value="5">
            </div>
            <div>
                <label>
                    Tempo de espera
                </label>
                <div class="star-rating avaliacao">
                    <label class="star selected" id="especialista-espera-1" data-value="1">&#9733;</label>
                    <label class="star selected" id="especialista-espera-2" data-value="2">&#9733;</label>
                    <label class="star selected" id="especialista-espera-3" data-value="3">&#9733;</label>
                    <label class="star selected" id="especialista-espera-4" data-value="4">&#9733;</label>
                    <label class="star selected" id="especialista-espera-5" data-value="5">&#9733;</label>
                </div>
                <input id="especialista-espera" type="hidden" name="especialista_espera" value="5">
            </div>
        </div>
        <div class="form-group">
            <textarea id="comentario-especialista" name="comentario_especialista" rows="2" cols="50" maxlength="200" placeholder="Deixe algum comentário para o especialista (opcional)..."></textarea>
        </div>
        
        <h4>Avalie a clínica</h4>
        <div class="form-group multiple-inputs-inline">
            <div>
                <label>
                    Localização
                </label>
                <div class="star-rating avaliacao">
                    <label class="star selected" id="clinica-localizacao-1" data-value="1">&#9733;</label>
                    <label class="star selected" id="clinica-localizacao-2" data-value="2">&#9733;</label>
                    <label class="star selected" id="clinica-localizacao-3" data-value="3">&#9733;</label>
                    <label class="star selected" id="clinica-localizacao-4" data-value="4">&#9733;</label>
                    <label class="star selected" id="clinica-localizacao-5" data-value="5">&#9733;</label>
                </div>
                <input id="clinica-localizacao" type="hidden" name="clinica_localizacao" value="5">
            </div>
            <div>
                <label>
                    Limpeza
                </label>
                <div class="star-rating avaliacao">
                    <label class="star selected" id="clinica-limpeza-1" data-value="1">&#9733;</label>
                    <label class="star selected" id="clinica-limpeza-2" data-value="2">&#9733;</label>
                    <label class="star selected" id="clinica-limpeza-3" data-value="3">&#9733;</label>
                    <label class="star selected" id="clinica-limpeza-4" data-value="4">&#9733;</label>
                    <label class="star selected" id="clinica-limpeza-5" data-value="5">&#9733;</label>
                </div>
                <input id="clinica-limpeza" type="hidden" name="clinica_limpeza" value="5">
            </div>
        </div>
        <div class="form-group multiple-inputs-inline">
            <div>
                <label>
                    Organização
                </label>
                <div class="star-rating avaliacao">
                    <label class="star selected" id="clinica-organizacao-1" data-value="1">&#9733;</label>
                    <label class="star selected" id="clinica-organizacao-2" data-value="2">&#9733;</label>
                    <label class="star selected" id="clinica-organizacao-3" data-value="3">&#9733;</label>
                    <label class="star selected" id="clinica-organizacao-4" data-value="4">&#9733;</label>
                    <label class="star selected" id="clinica-organizacao-5" data-value="5">&#9733;</label>
                </div>
                <input id="clinica-organizacao" type="hidden" name="clinica_organizacao" value="5">
            </div>
            <div>
                <label>
                    Tempo de espera
                </label>
                <div class="star-rating avaliacao">
                    <label class="star selected" id="clinica-espera-1" data-value="1">&#9733;</label>
                    <label class="star selected" id="clinica-espera-2" data-value="2">&#9733;</label>
                    <label class="star selected" id="clinica-espera-3" data-value="3">&#9733;</label>
                    <label class="star selected" id="clinica-espera-4" data-value="4">&#9733;</label>
                    <label class="star selected" id="clinica-espera-5" data-value="5">&#9733;</label>
                </div>
                <input id="clinica-espera" type="hidden" name="clinica_espera" value="5">
            </div>
        </div>
        <div class="form-group">
            <textarea id="comentario-clinica" name="comentario_clinica" rows="2" cols="50" maxlength="200" placeholder="Deixe algum comentário para a clínica (opcional)..."></textarea>
        </div>
        <input type="hidden" id="consulta_id" name="consulta_id" value="">
    @endcomponent

    <script>
        function setModal(consulta_id) {
            $("#consulta_id").val(consulta_id);
        }
        
        // Gerenciar a seleção das estrelas - para modal
        document.querySelectorAll('.star').forEach(function (star) {
            star.addEventListener('click', function () {
                var qtd = star.getAttribute('data-value');
                console.log(qtd)

                for (var i = 0; i <= 5; i++) {
                    var id = star.id.split("-")
                    id = id[0] + "-" + id[1] + "-" + i;
                    var estrela = document.getElementById(id);
                    if (estrela) {
                        estrela.classList.remove('selected');
                    }
                }

                for (var i = 0; i <= qtd; i++) {
                    var namesId = star.id.split("-")
                    id = namesId[0] + "-" + namesId[1] + "-" + i;
                    var estrela = document.getElementById(id);
                    if (estrela) {
                        estrela.classList.add('selected');
                        $('#'+ namesId[0] + "-" + namesId[1]).val(qtd)
                    }
                }
            });
        });

        $('#form-modal').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'GET',
                url: '{{ route("paciente.avaliacao.store") }}',
                data: {
                    consulta_id: $('#consulta_id').val(),
                    especialista_atendimento: $('#especialista-atendimento').val(),
                    especialista_espera: $('#especialista-espera').val(),
                    comentario_especialista: $('#comentario-especialista').val(),
                    clinica_localizacao: $('#clinica-localizacao').val(),
                    clinica_limpeza: $('#clinica-limpeza').val(),
                    clinica_organizacao: $('#clinica-organizacao').val(),
                    clinica_espera: $('#clinica-espera').val(),
                    comentario_clinica: $('#comentario-clinica').val(),
                },
                success: function(response) {
                    nowuiDashboard.showNotification('top', 'right', 'A avaliaçao da consulta foi salva com sucesso!', 'success');
                },
                error: function(error) {
                    nowuiDashboard.showNotification('top', 'right', 'Houve um erro ao salvar a avaliação da consulta, tente novamente.', 'danger');
                }
            });

            $('#modal-form').modal('toggle');            
            $('.avaliar-' + $('#consulta_id').val() + ' > a').remove()
        })

    </script>
@endsection
