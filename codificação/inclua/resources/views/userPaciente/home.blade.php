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
                    <a href="{{ route('paciente.pedido_exames.lista') }}" class="btn btn-secundary btn-round btn-lg header-links">
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
                                    <th>Especialista</th>
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
                                            @if (!$consulta->remota)
                                            <td>
                                                {{ $consulta->nome_clinica }}
                                            </td>
                                            @else
                                                <td>
                                                    TeleAtendimento
                                                </td>
                                            @endif

                                            <td>
                                                @if ($consulta->remota)
                                                <a href="{{ $consulta->linkmeet }}" title="Iniciar Consulta" class="btn btn-info" data-original-title="Iniciar Consulta" target="_blank" rel="noopener noreferrer" style="min-width: 150px"> Iniciar </a>
                                               <br/>
                                                @endif

                                                <a href="#" target="_blank" rel="tooltip" title="Cancelar consulta" class="btn btn-danger" data-original-title="Cancelar consulta"
                                                    href="#" data-target="#modal-form-cancelar-consulta" data-toggle="modal" data-whatever="@mdo" style="min-width: 150px" onclick="setModalCancelarConsulta({{ $consulta->id }}, {{ \App\Helper::verificarPrazoCancelamentoGratuito($consulta->horario_agendado) }})">
                                                    Cancelar
                                                </a>
                                                    <br/>
                                                    @if(!$consulta->isPago)
                                                        <a href="#" rel="tooltip" title="Efetuar pagamento" class="btn btn-info" data-target="#modal-form-pagar-consulta" style="width: 150px; margin-top: 4px"
                                                           data-toggle="modal" onclick="setModalPagamentoConsulta('{{ $consulta->id }}', '{{ number_format($consulta->preco, 2, ',', '.') }}')">
                                                            Pagar
                                                        </a>
                                                        <br>
                                                    @else
                                                        <a  href="#"  class="btn btn-success" style="max-width: 150px; margin-top: 4px">
                                                            <span style="margin-left: -20px">Consulta Paga</span>
                                                        </a>
                                                        <br>
                                                    @endif
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

    {{-- MODAL CANCELAR CONSULTA --}}
    @component('layouts.modal_form', ["title" => "Favor inserir o motivo do cancelamento!", "route" => route('paciente.consulta.cancelar'), "textButton" => "Cancelar consulta", "id" => "modal-form-cancelar-consulta"])
        <div class="form-group">
            <label id="subTitle" class="title td-inline">Ao cancelar a consulta será cobrado uma taxa de R$ {{ env('TAXA_CANCELAMENTO_CONSULTA') }}</label>
            <textarea id="motivoCancelamento" name="motivo_cancelamento" rows="5" cols="55" maxlength="500" placeholder="Digite o motivo do cancelamento aqui..." required></textarea>
        </div>
        <input type="hidden" id="consulta_id" name="consulta_id" value="">
    @endcomponent
    {{-- MODAL PAGAMENTO DE CONSULTA --}}
    @component('layouts.modal_form', ["title" => "Favor, informe o método de pagamento", "route" => route('consulta.pagamento.paciente'), "textButton" => "Prosseguir", "id" => "modal-form-pagar-consulta"])
        <div class="form-group">
            <label id="subTitle" class="title td-inline"></label>
        </div>
        <div class="input-group">
            <div class="custom-radio">
                <input type="radio" name="metodo_pagamento" id="pix" value="Pix" required checked>
                <label class="form-check-label" for="pix">
                    <img src="{{ asset('assets/img/pix.png')}}" class="img-icon" width="18px"> Pix
                </label>
            </div>
        </div>

        <div class="input-group">
            <div class="custom-radio">
                <input type="radio" name="metodo_pagamento" id="cartao-dropdown" value="cartao">
                <label class="form-check-label" for="cartao-dropdown">
                    <img src="{{ asset('assets/img/card.png')}}" class="img-icon" width="18px"> Cartão
                </label>
            </div>
        </div>

        <input type="hidden" id="consulta_id" name="consulta_id" value="">
    @endcomponent


    <script>
        function setModalCancelarConsulta(consulta_id, cancelamentoGratuito) {
            $("#modal-form-cancelar-consulta #consulta_id").val(consulta_id);
            if (cancelamentoGratuito) {
                $("#subTitle").css("display", "none");
            } else {
                $("#subTitle").css("display", "block");
            }
        }
    </script>

    @push('js')
        <script>
            function setModalPagamentoConsulta(consulta_id, valorConsulta) {
                $("#modal-form-pagar-consulta #consulta_id").val(consulta_id);
                $('#subTitle').html('Valor da consulta: R$ ' + valorConsulta);
            }

            $(document).ready(function () {
                $("input[name='metodo_pagamento']").change(function () {
                    if ($("#cartao-dropdown").is(":checked")) {
                        $('#drop-down').addClass("show")
                    } else if($("#pix").is(":checked")) {
                        $('#drop-down').removeClass("show")
                    } else if($("#especie").is(":checked")) {
                        $('#drop-down').removeClass("show")
                    }

                    if($("#maquininha").is(":checked")) {
                        $(".form-group").addClass("show")
                        $("#numero_autorizacao").prop('required', true);
                    } else {
                        $(".form-group").removeClass("show")
                        $("#numero_autorizacao").prop('required', false);
                    }
                });

                $('.consulta-paga').on('click', function () {
                    $("#modal-aviso-title").text("Consulta Paga")
                    $("#modal-aviso-message").text("Esta consulta já foi paga, não é necessário realizar nenhuma ação.")
                    $("#modal-aviso").modal()
                })

                $('.encaminhado').on('click', function () {
                    $("#modal-aviso-title").text("Encaminhamento Realizado")
                    $("#modal-aviso-message").text("O encaminhamento já foi realizado, não é necessário realizar nenhuma ação.")
                    $("#modal-aviso").modal()
                })
            });

            function mandaDadosFormPrincipalParaModal(consulta_id, tipoModal) {
                //pega valores para inviar para os modais e assim apos retorno do modal realizar a pesquisa
                var inicio_data = document.getElementById("inicio_data").value;
                var final_data = document.getElementById("final_data").value;
                var nomepaciente = document.getElementById("nomepaciente").value;
                var cpf = document.getElementById("cpf").value;
                var especialista_id = document.querySelector("#especialista_id").value;

                document.getElementById('inicio_dataM'+consulta_id+tipoModal).value = inicio_data;
                document.getElementById('final_dataM'+consulta_id+tipoModal).value = final_data;
                document.getElementById('nomepacienteM'+consulta_id+tipoModal).value = nomepaciente;
                document.getElementById('cpfM'+consulta_id+tipoModal).value = cpf;
                document.getElementById('especialista_idM'+consulta_id+tipoModal).value = especialista_id;
            }
        </script>
    @endpush
@endsection
