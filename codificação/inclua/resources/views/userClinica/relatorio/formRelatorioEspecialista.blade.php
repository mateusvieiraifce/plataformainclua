@extends('layouts.app', ['page' => __('Relatório Especialista'), 'exibirPesquisa' => false, 'pageSlug' => 'relEspecialista', 'class' => 'Relatório'])
@section('content')



<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">

               <div class="col-lg-12 col-md-12">
                  <form action="{{route('consulta.agendaConsultasPesquisar')}}" method="get" id="pesquisar">
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

               <h6 class="title d-inline">Lista de consultas finalizadas </h6>              
            </div>
            <div class="card-body">

               <div class="table-responsive">                  
                  <table class="table">
                     <thead>                                      
                        <th> Horário agendado </th>
                        <th> Paciente </th>
                        <th> Especialista </th> 
                        <th> Valor consulta </th>                        
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                        @foreach($lista as $ent)
                     <tr>                     
                    
                     <td>{{date( 'd/m/Y H:i' , strtotime($ent->horario_agendado))}}
                  </td>
                     <td>{{$ent->nome_paciente}} (CPF:{{$ent->cpf}})</td>
                     <td>{{$ent->nome_especialista}}</td>
                     <td>{{$ent->preco}}</td>
                  
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
   </div>
</div>


@endsection