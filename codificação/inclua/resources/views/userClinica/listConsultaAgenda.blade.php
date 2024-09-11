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
                        <a style="width:160px; height:30px; text-align: center;padding:7px;
                          margin: 2px; font-size: 12px; "
                         rel="tooltip" title="Cancelar" class="btn btn-secondary" data-original-title="Edit"
                           href="{{route('consulta.edit', $ent->id)}}">
                          Efetuar Pagamento
                        </a>    <br> 
                        <a style="width:160px; height:30px; text-align: center;padding:7px;
                          margin: 2px;margin-bottom:10px; font-size: 12px; "
                          rel="tooltip" title="Cancelar" class="btn btn-warning" data-original-title="Edit"
                           href="{{route('consulta.edit', $ent->id)}}">
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
@endsection