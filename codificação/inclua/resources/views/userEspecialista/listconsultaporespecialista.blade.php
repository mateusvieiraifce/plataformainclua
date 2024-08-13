@extends('layouts.app', ['page' => __('Consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'listconsultaporespecialista', 'class' => 'agenda'])
@section('content')



<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">

               <div class="col-lg-12 col-md-12">
                  <form action="#" method="get" id="pesquisar">
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
                                             placeholder="Nome do paciente" name="nomecliente" id="nomecliente"
                                             class="form-control"
                                             value="" >
                                 </div>
                              </div>

                              <div class="col-md-2 px-8">
                                 <div class="form-group">
                                    <label style="color: white">&nbsp;  Status da consulta:</label>                                    
                                    <select style="border-color: #C0C0C0"  class="form-control" id="status" name="status" required>
                                       <option style="color: #111111" value="" @if($status == "Todos") selected @endif>Todos</option>
                                        <option style="color: #111111" value="Aguardando atendimento" @if($status == "Aguardando atendimento") selected @endif>Aguardando atendimento</option>
                                        <option  style="color: #111111"value="Cancelada" @if($status == "Cancelada") selected @endif>Cancelada</option>
                                        <option  style="color: #111111"value="Em atendimento" @if($status == "Em atendimento") selected @endif>Em atendimento</option>
                                        <option style="color: #111111" value="Finalizada" @if($status == "Finalizada") selected @endif>Finalizada</option>
                                    </select>
                                 </div>
                              </div>

                              <div class="col-md-2 px-8">
                                 <div class="form-group">
                                    <label id="labelFormulario">Clínica(s) vinculada(s)</label>
                                    <select name="clinica_id" id="clinica_id" class="form-control"
                                     style="border-color: white">
                                     <option style="color: #111111" value="" @if($status == "Todas") selected @endif>Todas</option>
                                    @foreach($clinicas as $iten)
                                    <option style="color: #2d3748" value="{{old('especialidade_id', $iten->id)}}"
                                       @if($iten->id == $clinicaselecionada_id) <?php    echo 'selected'; ?> @endif> {{$iten->nome}}
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

               <h6 class="title d-inline">Lista de consultas </h6>              
            </div>
            <div class="card-body">

               <div class="table-responsive">                  
                  <table class="table">
                     <thead>
                        <th> Status </th>                       
                        <th> Horário agendado </th>
                        <th> Paciente </th>
                        <th> Clínica </th>
                        <th> Ação </th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                        @foreach($lista as $ent)
                     <tr>
                     <td >{{$ent->status}}</td>
                    
                     <td>{{date( 'd/m/Y H:i' , strtotime($ent->horario_agendado))}}
                  </td>
                  <td>{{$ent->nome_paciente}}</td>
                     <td>{{$ent->nome_clinica}}</td>
                     <td >
                        <a rel="tooltip" title="Iniciar atendimento" class="btn btn-primary" data-original-title="Edit"
                           href="{{route('especialista.iniciarAtendimento', $ent->id)}}">
                           Iniciar atendimento
                        </a>                    
                        <a style="max-width:120px; text-align: left;padding:10px " rel="tooltip" title="Cancelar" class="btn btn-secondary" data-original-title="Edit"
                           href="{{route('consulta.edit', $ent->id)}}">
                          Prontuário
                        </a>  
                        <a style="max-width:80px; text-align: left;padding:10px " rel="tooltip" title="Cancelar" class="btn btn-warning" data-original-title="Edit"
                           href="{{route('consulta.edit', $ent->id)}}">
                           Cancelar
                        </a>   
                                            
                    <!--
                        <a rel="tooltip" title="Editar" class="btn btn-link" data-original-title="Edit"
                           href="{{route('consulta.edit', $ent->id)}}">
                           <i class="tim-icons icon-pencil"></i>
                        </a>
-->
                        <a href="{{route('consulta.delete', $ent->id)}}"
                           onclick="return confirm('Deseja relamente excluir?')" rel="tooltip" title="Excluir"
                           class="btn btn-link" data-original-title="Remove">
                           <i class="tim-icons icon-simple-remove"></i>
                        </a>
                     </td>
                     </tr>
                  @endforeach 
                        @endif                       </tbody>
                  </table>
                  <div>
                     @if ($lista->lastPage() > 1)
                                 @php
                           $paginator = $lista;
                           $paginator->url = route('consulta.listconsultaporespecialista');
                        @endphp
                                 <ul class="pagination">
                                    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a href="{{$paginator->url . "?page=1&filtro=" . $filtro }}">&nbsp;<<&nbsp;&nbsp;</a>
                                    </li>
                                    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                                          <?php
                              $link_limit = 7;
                              $half_total_links = floor($link_limit / 2);
                              $from = $paginator->currentPage() - $half_total_links;
                              $to = $paginator->currentPage() + $half_total_links;
                              if ($paginator->currentPage() < $half_total_links) {
                                 $to += $half_total_links - $paginator->currentPage();
                              }
                              if ($paginator->lastPage() - $paginator->currentPage() < $half_total_links) {
                                 $from -= $half_total_links - ($paginator->lastPage() - $paginator->currentPage()) - 1;
                              }    ?>
                                          @if ($from < $i && $i < $to)
                                 <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                                 <a href="{{ $paginator->url . "?page=" . $i . "&filtro=" . $filtro }}">{{ $i}} &nbsp; </a>
                                 </li>
                              @endif
                           @endfor
                                    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                                    <a href="{{ $paginator->url . "?page=" . $paginator->lastPage() . "&filtro=" . $filtro }}">
                                       >></a>
                                    </li>
                                 </ul>
               @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection