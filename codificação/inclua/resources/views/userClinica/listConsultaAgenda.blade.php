@extends('layouts.app', ['page' => __('Consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'listaAgenda', 'class' => 'agenda'])
@section('content')
@section('title', 'Agenda')
   @include("layouts.modal_aviso")
   @php
      $lista = Session::get('lista') ?? $lista;
   @endphp
   <div class="card">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card card-tasks" style="height: auto; min-height: 500px;">
               <div class="card-header">
                  <div class="col-lg-12 col-md-12">
                     <form action="{{route('consulta.agendaConsultasPesquisar')}}" method="post" id="pesquisar">
                        @csrf
                        <label style="font-size: 20px"></label>
                        <fieldset>
                           <div class="row">
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">
                                       Data início:
                                    </label>
                                    <input style="border-color: #C0C0C0" type="date" name="inicio_data" id="inicio_data" 
                                       class="form-control" value="{{ (isset($inicio_data)) ? $inicio_data : date('Y-m-d') }}">
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">
                                       Data final:
                                    </label>
                                    <input style="border-color: #C0C0C0" type="date" name="final_data" id="final_data"
                                       class="form-control"  value="{{ (isset($final_data)) ? $final_data : date('Y-m-d') }}">
                                 </div>
                              </div>
                              <div class="col-md-3 px-8">
                                 <div class="form-group">
                                    <label style="color: white">
                                       Paciente:
                                    </label>
                                    <input style="border-color: #C0C0C0" type="text" class="form-control" id="nomepaciente"
                                       placeholder="Nome do paciente" name="nomepaciente" value="{{ (isset($nomepaciente)) ? $nomepaciente : "" }}">
                                 </div>
                              </div>
                              <div class="col-md-2 px-8">
                                 <div class="form-group">
                                    <label style="color: white">
                                       CPF Paciente:
                                    </label>
                                    <input style="border-color: #C0C0C0" type="text" class="form-control"
                                       placeholder="CPF do paciente" name="cpf" id="cpf" value="{{ (isset($cpf)) ? $cpf : "" }}">
                                 </div>
                              </div>
                              <div class="col-md-2 px-8">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">
                                       Especialistas
                                    </label>
                                    <select name="especialista_id" id="especialista_id" class="form-control" style="border-color: white">
                                       <option style="color: #2d3748" value="todos" @if($especialistaSelecionado_id == "Todos") selected @endif>Todos</option>
                                       @foreach($especialistas as $iten)
                                          <option style="color: #2d3748" value="{{old('especialidade_id', $iten->id)}}"
                                             @if($iten->id == $especialistaSelecionado_id) <?php    echo 'selected'; ?> @endif> {{$iten->nome}}
                                          </option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-1 ">                       
                                 <button type="submit" style="max-height: 40px; max-width: 40px;margin-top: 25px" class="btn btn-primary" >
                                    <i class="tim-icons icon-zoom-split"></i>
                                 </button>
                              </div>
                           </div>
                        </fieldset>
                        <input type="hidden" name="clinica_id" value="{{ $clinica->id }}">
                     </form>
                  </div>

                  <h6 class="title d-inline">Lista de consultas agendadas </h6>              
               </div>
               <div class="card-body">
                  <div class="table-responsive">                  
                     <table class="table">
                        <thead>
                           <th> Status </th>                       
                           <th> Horário agendado </th>
                           <th> Paciente </th>
                           <th> Especialista </th>
                           <th> Ação </th>
                        </thead>
                        <tbody>
                           @if(sizeof($lista) > 0)
                              @foreach($lista as $ent)
                                 <tr>
                                    <td>
                                       {{ $ent->status }}
                                    </td>
                                    <td>
                                       {{ date( 'd/m/Y H:i' , strtotime($ent->horario_agendado)) }}
                                    </td>
                                    <td>
                                       {{ $ent->nome_paciente}} (CPF: {{ $ent->cpf }})
                                    </td>
                                    <td>
                                       {{ $ent->nome_especialista }}
                                    </td>
                                    <td>
                                       @if($ent->status != 'Sala de espera' && $ent->status != 'Em Atendimento')
                                          <a href="#" target="_blank" class="btn btn-primary button-small-table" data-original-title="Fazer Encaminhamento" title="Fazer Encaminhamento"
                                             data-target="#modalLocal{{$ent->id}}" data-toggle="modal" onclick="mandaDadosFormPrincipalParaModal({{$ent->id}},'l')" >                        
                                             Fazer Encaminhamento
                                          </a>    
                                          <br>
                                       @else
                                          <button id="encaminhado" type="button" class="btn btn-info button-small-table">
                                             Encaminhamento
                                             <br>
                                             realizado
                                          </button>
                                          <br>
                                       @endif   
                                       @if(!$ent->isPago)
                                          <a href="#" rel="tooltip" title="Iniciar atendimento" class="btn btn-secundary button-small-table" data-target="#modal-form-pagar-consulta"
                                             data-toggle="modal" onclick="setModalPagamentoConsulta('{{ $ent->id }}', '{{ number_format($ent->preco, 2, ',', '.') }}')">
                                             Efetuar Pagamento
                                          </a>
                                          <br>
                                       @else
                                          <button id="consulta-paga" type="button" class="btn btn-success button-small-table">
                                             Consulta paga
                                          </button>
                                          <br>
                                       @endif
                                       <a rel="tooltip" title="Cancelar" class="btn btn-warning button-small-table" data-original-title="Edit" href="#" id="btnCanelarConsulta"
                                          data-target="#modalCancelar{{$ent->id}}" data-toggle="modal" onclick="mandaDadosFormPrincipalParaModal({{$ent->id}},'c')">
                                          Cancelar
                                       </a>
                                    </td>
                                 </tr>
                                 <!-- Modal local consulta-->
                                 <div class="modal" id="modalLocal{{$ent->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" style="max-width: 80%; width: 50%; height: 50%;top: -15%;" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h5 class="modal-title">
                                                <label style="color:black">Local da consulta com o especialista {{$ent->nome_especialista}}:</label>
                                             </h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <div class="container">
                                                <!--aqui salva o local da consulta, valor padrao o ultimo local salvo -->
                                                <form method="post" action="{{route('consulta.encaminharPaciente')}}">
                                                   @csrf
                                                   <div class="row">
                                                      <div class="col-md-8 px-8">
                                                         <div class="form-group">
                                                            <label style="color: #111111;">Local:</label>
                                                                  <input style="color: #111111" type="text"
                                                                     class="form-control" maxlength="150" name="local_consulta"
                                                                     value="{{$ent->local_consulta}}" required>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-4 px-8">
                                                            <div class="form-group">
                                                            <label style="color: #111111;">Tipo de atendimento:</label>
                                                            <select  class="form-control" id="tipo_fila" name="tipo_fila" style="color: #111111">
                                                               <option value="Normal">Normal</option>
                                                               <option value="Prioritário">Prioritário</option>
                                                            </select>
                                                         </div>
                                                      </div>
                                                      <input type="hidden" value="{{$ent->id}}" name="consulta_id">
                                                      <!--dados para pesquisa modal tipo L-->
                                                      <input type="hidden" id="inicio_dataM{{$ent->id}}l" name="inicio_dataM">
                                                      <input type="hidden" id="final_dataM{{$ent->id}}l" name="final_dataM">
                                                      <input type="hidden" id="nomepacienteM{{$ent->id}}l" name="nomepacienteM">
                                                      <input type="hidden" id="cpfM{{$ent->id}}l" name="cpfM">
                                                      <input type="hidden" id="especialista_idM{{$ent->id}}l" name="especialista_idM">
                                                   </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                         <i class="fa fa-reply"></i>
                                                         Voltar
                                                      </button>
                                                      <button type="submit" class="btn btn-primary">
                                                         Encaminhar
                                                      </button>
                                                   </div>
                                                   <input type="hidden" name="clinica_id" value="{{ $clinica->id }}">
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                                 <!-- Modal cancelar consulta -->
                                 <div class="modal" id="modalCancelar{{$ent->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" style=" max-width: 80%; width: 50%; height: 50%;top: -15%;" role="document">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h2 class="modal-title">
                                                <label style="color:black; font-size:15px">Favor inserir o motivo do cancelamento!</label>
                                             </h2>
                                             <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <div class="container">
                                                <!--aqui salva o cancelamento da consulta-->
                                                <form method="post" action="{{route('clinica.canelarconsultaViaClinica')}}">
                                                   @csrf
                                                   <div class="row">
                                                      <div class="col-md-12 px-8">
                                                         <div class="form-group">
                                                            <textarea id="motivocancelamento" name="motivocancelamento" rows="8"
                                                               cols="80" style="width: 100%;" maxlength="200" 
                                                               placeholder="Digite o motivo do cancelamento aqui..." required>
                                                            </textarea>
                                                         </div>
                                                      </div>
                                                      <input type="hidden" value="{{$ent->id}}"  name="consulta_id">
                                                      <!--dados para pesquisa modal tipo C-->
                                                      <input type="hidden" id="inicio_dataM{{$ent->id}}c" name="inicio_dataM">
                                                      <input type="hidden" id="final_dataM{{$ent->id}}c" name="final_dataM">
                                                      <input type="hidden" id="nomepacienteM{{$ent->id}}c" name="nomepacienteM">
                                                      <input type="hidden" id="cpfM{{$ent->id}}c" name="cpfM">
                                                      <input type="hidden" id="especialista_idM{{$ent->id}}c" name="especialista_idM">
                                                   </div>
                                                   <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                         <i class="fa fa-reply"></i> Voltar
                                                      </button>
                                                      <button type="submit" class="btn btn-primary">
                                                         Cancelar consulta
                                                      </button>
                                                   </div>
                                                   <input type="hidden" name="clinica_id" value="{{ $clinica->id }}">
                                                </form>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
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
            <input type="radio" name="metodo_pagamento" id="pix" value="Pix" required>
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
                  name="numero_autorizacao" placeholder="Número de autorização" value="">
            </div>
         </div>
      </div>
      <input type="hidden" id="consulta_id" name="consulta_id" value="">
   @endcomponent

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

            $('#consulta-paga').on('click', function () {
               $("#modal-aviso-title").text("Consulta Paga")
               $("#modal-aviso-message").text("Esta consulta já foi paga, não é necessário realizar nenhuma ação.")
               $("#modal-aviso").modal()
            })

            $('#encaminhado').on('click', function () {
               $("#modal-aviso-title").text("Encaminhamento Realizado")
               $("#modal-aviso-message").text("O encaminhamento já foi realizado, não é necessário realizar nenhuma ação.")
               $("#modal-aviso").modal()
            })
               
            $('#consulta-paga').on('click', function () {
               $("#modal-aviso-title").text("Consulta Paga")
               $("#modal-aviso-message").text("Esta consulta já foi paga, não é necessário realizar nenhuma ação.")
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