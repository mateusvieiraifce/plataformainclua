@extends('layouts.app', ['page' => __('Consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'listconsultaporespecialista', 'class' => 'agenda'])
@section('content')
@section('title', 'Consultas')
   <div class="card">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card card-tasks" style="height: auto; min-height: 500px;">
               <div class="card-header">
                  <div class="col-lg-12 col-md-12">
                     <form action="{{route('consulta.listConsultaPorEspecialistaPesquisar')}}" method="get" id="pesquisar">
                        @csrf
                        <label style="font-size: 20px"></label>
                        <fieldset>
                           <div class="row">
                              <div class="col-md-2 ">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">
                                       &nbsp;Data início:
                                    </label>
                                    <input style="border-color: #C0C0C0" type="date" name="inicio_data" id="inicio_data" 
                                       class="form-control" value="{{ (isset($inicio_data)) ? $inicio_data : date('Y-m-d') }}">
                                 </div>
                              </div>
                              <div class="col-md-2 ">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">
                                       &nbsp;&nbsp;
                                       Data final:
                                    </label>
                                    <input style="border-color: #C0C0C0" type="date" name="final_data" id="final_data"
                                       class="form-control" value="{{ (isset($final_data)) ? $final_data : date('Y-m-d') }}">
                                 </div>
                              </div>
                              <div class="col-md-3 px-8">
                                 <div class="form-group">
                                    <label style="color: white">
                                       &nbsp; &nbsp;
                                       Paciente:
                                    </label>
                                    <input style="border-color: #C0C0C0" type="text" placeholder="Nome do paciente" name="nomepaciente"
                                       id="nomepaciente" class="form-control" value="{{ isset($nomepaciente) ? $nomepaciente : null}}">
                                 </div>
                              </div>
                              <div class="col-md-2 px-8">
                                 <div class="form-group">
                                    <label style="color: white">
                                       &nbsp;
                                       Status da consulta:
                                    </label>
                                    <select style="border-color: #C0C0C0"  class="form-control" id="status" name="status" required>
                                       <option style="color: #111111" value="todos" @if($status == "Todos") selected @endif>Todos</option>
                                       <option style="color: #111111" value="Sala de espera" @if($status == "Sala de espera") selected @endif>Sala de espera</option>
                                       <option style="color: #111111" value="Aguardando atendimento" @if($status == "Aguardando atendimento") selected @endif>Aguardando atendimento</option>
                                       <option style="color: #111111"value="Cancelada" @if($status == "Cancelada") selected @endif>Cancelada</option>
                                       <option style="color: #111111"value="Em atendimento" @if($status == "Em atendimento") selected @endif>Em atendimento</option>
                                       <option style="color: #111111" value="Finalizada" @if($status == "Finalizada") selected @endif>Finalizada</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-2 px-8">
                                 <div class="form-group">
                                    <label id="labelFormulario">
                                       Clínica(s) vinculada(s)
                                    </label>
                                    <select name="clinica_id" id="clinica_id" class="form-control" style="border-color: white">
                                       @foreach($clinicas as $iten)
                                          <option style="color: #2d3748" value="{{old('especialidade_id', $iten->id)}}"
                                             @if($iten->id == $clinicaselecionada_id) <?php echo 'selected'; ?> @endif> {{$iten->nome}}
                                          </option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-1 ">                       
                                 <button style="max-height: 40px; max-width: 40px;margin-top: 25px" class="btn btn-primary">
                                    <i  class="tim-icons icon-zoom-split"></i>
                                 </button>
                              </div>
                           </div>
                        </fieldset>
                     </form>
                  </div>

                  <h6 class="title d-inline">Lista de consultas </h6>              
               </div>
               <div class="card-body">
                  <div class="table-responsive">                  
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
                           @if(sizeof($lista) > 0)
                              @foreach($lista as $ent)
                                 <tr>
                                    <td>
                                       {{ $ent->status }}
                                    </td>
                                    <td>
                                       {{ date( 'd/m/Y H:i' , strtotime($ent->horario_agendado)) }}
                                    </td>
                                    @if (auth()->user()->tipo_user == "R")
                                       <td>
                                          {{ $ent->nome_especialista }}
                                       </td>
                                    @endif
                                    <td>
                                       {{ $ent->nome_paciente }}
                                    </td>
                                    <td>
                                       {{ $ent->nome_clinica }}
                                    </td>
                                    <td>
                                       <a href="#" rel="tooltip" title="Iniciar atendimento" class="btn btn-primary" data-original-title="Edit" data-target="#modal-form" data-toggle="modal" onclick="setModal('{{ route('especialista.iniciarAtendimento', [$ent->id, 'prontuarioatual']) }}')">
                                          Iniciar atendimento
                                       </a>
                                       <a style="max-width:120px; text-align: left;padding:10px " rel="tooltip" title="Cancelar" class="btn btn-secondary" data-original-title="Edit" href="#">
                                          Prontuário
                                       </a>
                                       <a style="max-width:80px; text-align: left;padding:10px " rel="tooltip" title="Cancelar" class="btn btn-warning" data-original-title="Edit" href="#">
                                          Cancelar
                                       </a>
                                    </td>
                                 </tr>
                              @endforeach 
                           @endif
                        </tbody>
                     </table>
                  <div>
               </div>
            </div>
         </div>
      </div>
   </div>

   {{-- MODAL CANCELAR CONSULTA --}}
   @component('layouts.modal_form', ["title" => "Favor, informe o método de pagamento", "route" => '', "textButton" => "Prosseguir", 'method' => 'get'])
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
            <input type="radio" name="metodo_pagamento" id="maquininha" value="Máquinhinha" required>
            <label class="form-check-label" for="maquininha">
               Máquininha
            </label>
         </div>
      </div>
   @endcomponent

   <script>
      function setModal(route) {
         $('#form-modal').attr('action', route);
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
         });
      });
   </script>
@endsection