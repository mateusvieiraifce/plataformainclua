@extends('layouts.app', ['page' => __('Consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'listaAgenda', 'class' => 'agenda'])
@section('content')



<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">

               <div class="col-lg-12 col-md-12">
                  <form action="{{route('clinica.agendaConsultasPesquisar')}}" method="get" id="pesquisar">
                     @csrf
                     <label style="font-size: 20px"></label>
                     <fieldset>
                        <div class="row">
                              <div class="col-md-2 ">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">&nbsp;Data início:</label>
                                    <input style="border-color: #C0C0C0" type="date" name="inicio_data" id="inicio_data" 
                                    class="form-control"
                                             @if(isset($inicio_data))
                                                value="{{$inicio_data}}"
                                             @else
                                                value="{{date('Y-m-d')}}"
                                             @endif
                                          >
                                 </div>
                              </div>
                              <div class="col-md-2 ">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">&nbsp;&nbsp;  Data
                                          final:</label>
                                    <input style="border-color: #C0C0C0" type="date" name="final_data" id="final_data"
                                             class="form-control"
                                             @if(isset($final_data))
                                                value="{{$final_data}}"
                                             @else
                                                value="{{date('Y-m-d')}}"
                                             @endif
                                          >
                                 </div>
                              </div>
                              <div class="col-md-3 px-8">
                                 <div class="form-group">
                                    <label style="color: white">&nbsp; &nbsp; Paciente:</label>
                                    <input style="border-color: #C0C0C0" type="text"
                                             placeholder="Nome do paciente" name="nomepaciente" id="nomepaciente"
                                             class="form-control"
                                             @if(isset($nomepaciente))
                                                value="{{$nomepaciente}}"
                                             @else
                                                value=""
                                             @endif >
                                 </div>
                              </div>

                              <div class="col-md-2 px-8">
                                 <div class="form-group">
                                    <label style="color: white">&nbsp; &nbsp; CPF Paciente:</label>
                                    <input style="border-color: #C0C0C0" type="text"
                                             placeholder="CPF do paciente" name="cpf" id="cpf"
                                             class="form-control"
                                             @if(isset($cpf))
                                                value="{{$cpf}}"
                                             @else
                                                value=""
                                             @endif >
                                 </div>
                              </div>                             

                              <div class="col-md-2 px-8">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">Especialistas</label>
                                    <select name="especialista_id" id="especialista_id" class="form-control"
                                     style="border-color: white">
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
                                 <button style="max-height: 40px; max-width: 40px;margin-top: 25px" class="btn btn-primary" >
                                    <i  class="tim-icons icon-zoom-split" >
                                    </i></button>
                              </div>
                        </div>
                     </fieldset>
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
                     <td >{{$ent->status}}</td>
                    
                     <td>{{date( 'd/m/Y H:i' , strtotime($ent->horario_agendado))}}
                  </td>
                  <td>{{$ent->nome_paciente}} (CPF:{{$ent->cpf}})</td>
                  <td>{{$ent->nome_especialista}}</td>
                  <td> 
                      @if($ent->status != 'Sala de espera')
                         <a style="width:160px; height:30px; text-align: center;padding:7px;
                          margin: 2px; font-size: 12px; "
                         rel="tooltip" title=" Fazer Encaminhamento" 
                         href="#" target="_blank"
                         class="btn btn-primary" data-original-title="Fazer Encaminhamento"
                         data-target="#modalLocal{{$ent->id}}" data-toggle="modal"
                         data-whatever="@mdo">                        
                         Fazer Encaminhamento
                        </a>    
                        <br>
                        @else
                         <label>Encaminhamento realizado</label>
                         <br>
                        @endif
                        
                        @if(!$ent->isPago) 
                        <a style="width:160px; height:30px; text-align: center;padding:7px;
                          margin: 2px; font-size: 12px; "
                         rel="tooltip" title=" Fazer Encaminhamento" 
                         href="#" target="_blank"
                         class="btn btn-secudary" data-original-title="Fazer Encaminhamento"
                         data-target="#modalPagamento{{$ent->id}}" data-toggle="modal"
                         data-whatever="@mdo">  
                          Efetuar Pagamento
                        </a> 
                        <br> 
                        @else
                         <label>Consulta Paga</label>
                         <br>
                        @endif
                       
                        <a style="width:160px; height:30px; text-align: center;padding:7px;
                          margin: 2px;margin-bottom:10px; font-size: 12px; "
                          rel="tooltip" title="Cancelar" class="btn btn-warning" data-original-title="Edit"
                           href="#"
                           data-target="#modalCancelar{{$ent->id}}" data-toggle="modal"
                           data-whatever="@mdo"
                           onclick="mandaDadosFormPrincipalParaModal()">
                           Cancelar
                        </a>                                              
                   
                          
                      </td>
                     </tr>
                  <!-- Modal local consulta-->
                  <div class="modal" id="modalLocal{{$ent->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog"
                        style=" max-width: 80%;                                                                                                                                          width: 50%; height: 50%;top: -15%;"
                        role="document">
                        <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">
                                    <label style="color:black">Local da consulta com o especialista {{$ent->nome_especialista}}:</label>
                                 </h5>
                                 <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <div class="container">
                                    <!--aqui salva o local da consulta, valor padrao o ultimo local salvo -->
                                    <form method="post" action="{{route('consulta.encaminharPaciente')}}">
                                          @csrf                                         
                                          <div class="row">
                                             <div class="col-md-12 px-8">
                                                <div class="form-group">
                                                      <input style="color: #111111" type="text"
                                                         class="form-control" maxlength="150" name="local_consulta"
                                                         value="{{$ent->local_consulta}}" required>
                                                </div>
                                             </div>
                                             <input type="hidden" value="{{$ent->id}}" 
                                                name="consulta_id">

                                          </div>
                                             <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                      data-dismiss="modal"><i class="fa fa-reply"></i>
                                                      Voltar
                                                </button>
                                                <button type="submit"
                                                      class="btn btn-primary">Encaminhar</button>
                                             </div>
                                    </form>
                                 </div>
                              </div>
                        </div>
                     </div>
                  </div>

                  <!-- Modal efetuar pagamento -->
                  <div class="modal" id="modalPagamento{{$ent->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog"
                        style=" max-width: 80%;                                                                                                                                          width: 50%; height: 50%;top: -15%;"
                        role="document">
                        <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title">
                                    <label style="color:black">Efetuar pagamento</label>
                                 </h5>
                                 <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <div class="container">
                                    <!--aqui salva a forma de pagamento-->
                                    <form method="post" action="{{route('consulta.efetuarPagamentoUserClinica')}}">
                                          @csrf                                         
                                          <div class="row">
                                          @php                                           
                                             // Formate o número como valor monetário
                                             $precoConsulta = number_format($ent->preco, 2, ',', '.');
                                          @endphp
                                             <div class="col-md-12 px-8">
                                                <div class="form-group">
                                                   <label style="color: #111111;">Valor da consulta:</label>
                                                      <input style="color: #111111; background-color: #ffffff; text-align: right;" type="text"
                                                         class="form-control" maxlength="150" name="preco"
                                                         value="R$ {{ $precoConsulta}}" readonly>
                                                </div>
                                             </div>

                                             <div class="col-md-12 px-8">
                                                <div class="form-group">
                                                   <label style="color: #111111;">Forma de pagamento:</label>
                                                   <select class="form-control" style="color: #111111" required name="forma_pagamento">
                                                      <option value="">Selecionar a forma de pagamento</option>
                                                      <option value="Dinheiro">Dinheiro</option>
                                                      <option value="PIX">PIX</option>
                                                      <option value="Cartão de Crédito">Cartão de Crédito</option>
                                                      <option value="Cartão de Débito">Cartão de Débito</option>
                                                     
                                                </select>
                                                </div>
                                             </div>

                                             <input type="hidden" value="{{$ent->id}}" 
                                                name="consulta_id">

                                          </div>
                                             <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                      data-dismiss="modal"><i class="fa fa-reply"></i>
                                                      Voltar
                                                </button>
                                                <button type="submit"
                                                      class="btn btn-primary">Confirmar pagamento</button>
                                             </div>
                                    </form>
                                 </div>
                              </div>
                        </div>
                     </div>
                  </div>

                   <!-- Modal cancelar consulta -->
                   <div class="modal" id="modalCancelar{{$ent->id}}" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                     <div class="modal-dialog"
                        style=" max-width: 80%;                                                                                                                                          width: 50%; height: 50%;top: -15%;"
                        role="document">
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
                                                      <textarea id="motivocancelamento" name="motivocancelamento" 
                                                      rows="8" cols="80" style="width: 100%;" maxlength="200" 
                                                      placeholder="Digite o motivo do cancelamento aqui..." required></textarea>
                                                   </div>
                                             </div>
                                             <input type="hidden" value="{{$ent->id}}"  name="consulta_id">
                                             <!--dados para pesquisa-->
                                             <input type="hidden" id="inicio_dataM" name="inicio_dataM">
                                             <input type="hidden" id="final_dataM" name="final_dataM">
                                             <input type="hidden" id="nomepacienteM" name="nomepacienteM">
                                             <input type="hidden" id="cpfM" name="cpfM">
                                             <input type="hidden" id="especialista_idM" name="especialista_idM">
                                          </div>
                                          <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                                      class="fa fa-reply"></i> Voltar
                                             </button>
                                             <button type="submit" class="btn btn-primary">Cancelar consulta</button>
                                          </div>
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
                  <div>
                    
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<script>
  
    function mandaDadosFormPrincipalParaModal() {
    
        //pega valores para inviar para os modais e assim apos retorno do modal realizar a pesquisa
        var inicio_data = document.getElementById("inicio_data").value;
        var final_data = document.getElementById("final_data").value;
        var nomepaciente = document.getElementById("nomepaciente").value;
        var cpf = document.getElementById("cpf").value;
        var especialista_id = document.querySelector("#especialista_id").value;
             
        document.getElementById('inicio_dataM').value = inicio_data;
        document.getElementById('final_dataM').value = final_data;
        document.getElementById('nomepacienteM').value = nomepaciente;
        document.getElementById('cpfM').value = cpf;
        document.getElementById('especialista_idM').value = especialista_id;
    }
</script>

@endsection