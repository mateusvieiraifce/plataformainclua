@extends('layouts.app', ['page' => __('Consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'listconsultaporespecialista', 'class' => 'agenda'])
@section('content')
@section('title', 'Consultas')
   @inject('helper', 'App\Helper')
   @include("layouts.modal_aviso")
   <div class="card">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="title">Lista de Consultas</h4>
                  <form action="{{route('consulta.listConsultaPorEspecialistaPesquisar')}}" method="post" id="pesquisar">
                     @csrf
                     <div class="row search">
                        <div class="col-md-2 px-8">
                           <div class="form-group">
                              <label for="inicio_data">
                                 Data início:
                              </label>
                              <input type="date" name="inicio_data" id="inicio_data"
                                 class="form-control" value="{{ (isset($inicio_data)) ? $inicio_data : date('Y-m-d') }}">
                           </div>
                        </div>
                        <div class="col-md-2 px-8">
                           <div class="form-group">
                              <label for="final_data">
                                 Data final:
                              </label>
                              <input type="date" name="final_data" id="final_data"
                                 class="form-control" value="{{ (isset($final_data)) ? $final_data : date('Y-m-d') }}">
                           </div>
                        </div>
                        <div class="col-md-3 px-8">
                           <div class="form-group">
                              <label for="nomepaciente">
                                 Paciente:
                              </label>
                              <input type="text" placeholder="Nome do paciente" name="nomepaciente"
                                 id="nomepaciente" class="form-control" value="{{ isset($nomepaciente) ? $nomepaciente : null}}">
                           </div>
                        </div>
                        <div class="col-md-2 px-8">
                           <div class="form-group">
                              <label for="status">
                                 Status da consulta:
                              </label>
                              <select class="form-control" id="status" name="status" required>
                                 <option value="todos" @if($status == "Todos") selected @endif>Todos</option>
                                 <option value="Sala de espera" @if($status == "Sala de espera") selected @endif>Sala de espera</option>
                                 <option value="Aguardando atendimento" @if($status == "Aguardando atendimento") selected @endif>Aguardando atendimento</option>
                                 <option alue="Cancelada" @if($status == "Cancelada") selected @endif>Cancelada</option>
                                 <option alue="Em atendimento" @if($status == "Em atendimento") selected @endif>Em atendimento</option>
                                 <option value="Finalizada" @if($status == "Finalizada") selected @endif>Finalizada</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-3 px-8">
                           <div class="form-group">
                              <label id="labelFormulario">
                                 Clínica(s) vinculada(s)
                              </label>
                              <div class="input-button-inline">
                                 <select name="clinica_id" id="clinica_id" class="form-control">
                                    @foreach($clinicas as $iten)
                                       <option value="{{old('especialidade_id', $iten->id)}}" @if($iten->id == $clinicaselecionada_id) selected @endif>
                                             {{$iten->nome}}
                                       </option>
                                    @endforeach
                                 </select>
                                 <button class="btn btn-primary">
                                    <i class="tim-icons icon-zoom-split"></i>
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
               <div class="card-body">
                  <div class="table-full-width table-responsive">
                     <table class="table">
                        <thead>
                           <th>Status</th>
                           <th>Horário agendado</th>
                           @if (auth()->user()->tipo_user == "R")
                              <th>Especialista </th>
                           @endif
                           <th>Paciente</th>
                           <th>Clínica</th>
                           <th>Ação</th>
                        </thead>
                        <tbody>
                           @if(sizeof($consultas) > 0)
                              @foreach($consultas as $consulta)
                                 <tr>
                                    <td>
                                       {{ $consulta->status }}
                                    </td>
                                    <td>
                                       {{ date( 'd/m/Y H:i' , strtotime($consulta->horario_agendado)) }}
                                    </td>
                                    @if (auth()->user()->tipo_user == "R")
                                       <td>
                                          {{ $consulta->nome_especialista }}
                                       </td>
                                    @endif
                                    <td>
                                       {{ $consulta->nome_paciente }}
                                    </td>
                                    <td>
                                       {{ $consulta->nome_clinica }}
                                    </td>
                                    <td>
                                       @if (!$consulta->id_usuario_cancelou)
                                          @if(!$consulta->isPago)
                                             <a href="#" rel="tooltip" title="Efetuar Pagamento" class="btn btn-default button-small-table" data-target="#modal-form-pagar-consulta"
                                                data-toggle="modal" onclick="setModalPagamentoConsulta('{{ $consulta->id }}', '{{ number_format($consulta->preco, 2, ',', '.') }}')">
                                                Efetuar pagamento
                                             </a>
                                          @else
                                             <button type="button" class="btn btn-success button-small-table consulta-paga">
                                                Consulta paga
                                             </button>
                                          @endif
                                       @endif


                                           <br>
                                       @if (!$consulta->id_usuario_cancelou && !($consulta->status == "Finalizada"))
                                          <a rel="tooltip" title="Iniciar atendimento" class="btn btn-primary button-small-table" data-original-title="Edit" href="{{route('especialista.iniciarAtendimento', [$consulta->id, "prontuarioatual"])}}">
                                             Iniciar atendimento
                                          </a>
                                       @else
                                          <a rel="tooltip" title="Consulta finalizada" class="btn btn-success button-small-table" data-original-title="Edit" href="#">
                                             Consulta finalizada
                                          </a>
                                       @endif

                                       <br>
                                       <a rel="tooltip" title="Cancelar" class="btn btn-default button-small-table" data-original-title="Edit" href="{{route('paciente.prontuario',['id_paciente'=>$consulta->paciente_id])}}">
                                          Prontuário
                                       </a>

                                           <br>
                                           <a rel="tooltip" title="Cancelar" class="btn btn-default button-small-table" data-original-title="Edit" href="{{route('paciente.prontuario',['id_paciente'=>$consulta->paciente_id])}}">
                                               Avaliar Paciente
                                           </a>

                                       <br>
                                        @if ($consulta->status!="Finalizada")
                                       @if (!$consulta->id_usuario_cancelou )
                                          <a rel="tooltip" title="Cancelar" class="btn btn-warning button-small-table" data-original-title="Edit" href="#" id="btnCanelarConsulta"
                                             data-target="#modal-form-cancelar-consulta" data-toggle="modal"  onclick="setModalCancelarConsulta({{ $consulta->id }}, {{ $helper::verificarPrazoCancelamentoGratuito($consulta->horario_agendado) }})">
                                             Cancelar
                                          </a>
                                       @else
                                          <button type="button" class="btn btn-warning button-small-table consulta-cancelada">
                                             Consulta cancelada
                                          </button>
                                       @endif
                                           @endif
                                    </td>
                                 </tr>
                              @endforeach
                           @endif
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   {{-- MODAL PAGAMENTO DE CONSULTA --}}
   @component('layouts.modal_form', ["title" => "Favor, informe o método de pagamento", "route" => route('consulta.pagamento'), "textButton" => "Prosseguir", "id" => "modal-form-pagar-consulta"])
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
            <input type="radio" name="metodo_pagamento" id="especie" value="Espécie" required>
            <label class="form-check-label" for="especie">
               <img src="{{ asset('assets/img/money.png')}}" class="img-icon" width="18px"> Espécie
            </label>
         </div>
      </div>
      <div class="input-group">
         <div class="custom-radio">
            <input type="radio" name="metodo_pagamento" id="cartao-dropdown" value="null">
            <label class="form-check-label" for="cartao-dropdown">
               <img src="{{ asset('assets/img/card.png')}}" class="img-icon" width="18px"> Cartão
            </label>
         </div>
      </div>
      <div class="input-group drop-down" id="drop-down">
         <div class="custom-radio">
            <input type="radio" name="metodo_pagamento" id="cartao" value="Cartão" required>
            <label class="form-check-label" for="cartao">
               Cartão Cadastrado
            </label>
         </div>
         <div class="custom-radio">
            <input type="radio" name="metodo_pagamento" id="maquininha" value="Maquininha" required>
            <label class="form-check-label" for="maquininha">
               Máquininha
            </label>
         </div>
         <div class="form-group drop-down">
            <label for="numero_autorizacao">
               Número de autorização <span class="required">*</span>
            </label>
            <div class="input-group">
               <input type="text" id="numero_autorizacao" class="form-control"
                  name="numero_autorizacao" placeholder="Número de autorização" >
            </div>
         </div>
      </div>
      <input type="hidden" id="consulta_id" name="consulta_id" value="">
   @endcomponent

   {{-- MODAL CANCELAR CONSULTA --}}
   @component('layouts.modal_form', ["title" => "Favor inserir o motivo do cancelamento!", "route" => route('paciente.consulta.cancelar'), "textButton" => "Cancelar consulta", "id" => "modal-form-cancelar-consulta"])
      <div class="form-group">
         <label id="subTitle" class="title td-inline">Ao cancelar a consulta será cobrado uma taxa de R$ {{ env('TAXA_CANCELAMENTO_CONSULTA') }}</label>
         <textarea id="motivoCancelamento" name="motivo_cancelamento" rows="5" cols="55" maxlength="500" placeholder="Digite o motivo do cancelamento aqui..." required></textarea>
      </div>
      <input type="hidden" id="consulta_id" name="consulta_id" value="">
   @endcomponent

   @push('js')
      <script>
         function setModalPagamentoConsulta(consulta_id, valorConsulta) {
            $("#modal-form-pagar-consulta #consulta_id").val(consulta_id);
            $('#subTitle').html('Valor da consulta: R$ ' + valorConsulta);
         }

         function setModalCancelarConsulta(consulta_id, cancelamentoGratuito) {
            $("#modal-form-cancelar-consulta #consulta_id").val(consulta_id);
            if (cancelamentoGratuito) {
               $("#subTitle").css("display", "none");
            } else {
               $("#subTitle").css("display", "block");
            }
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

            $('.consulta-cancelada').on('click', function () {
               $("#modal-aviso-title").text("Consulta Cancelada")
               $("#modal-aviso-message").text("Esta consulta foi cancelada, não é necessário realizar nenhuma ação.")
               $("#modal-aviso").modal()
            })
         });
      </script>
   @endpush
@endsection
