@extends('layouts.app', ['page' => __('Pacientes'), 'exibirPesquisa' => false, 'pageSlug' => 'pacientes', 'class' => 'agenda'])
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
                              <div class="col-md-6 px-8">
                                 <div class="form-group">
                                    <label style="color: white">&nbsp; &nbsp; Paciente:</label>
                                    <input style="border-color: #C0C0C0" type="text"
                                             placeholder="Nome do paciente" name="nomecliente" id="nomecliente"
                                             class="form-control"
                                             value="" >
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

               <h6 class="title d-inline">Lista de pacientes </h6>              
            </div>
            <div class="card-body">

               <div class="table-responsive">                  
                  <table class="table">
                     <thead>                     
                        <th> Paciente </th>
                        <th> Total de consultas </th>
                        <th>  </th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                        @foreach($lista as $ent)
                     <tr>
                    
                    
                  <td>{{$ent->nome_paciente}}</td>
                  <td>{{$ent->total_consultas}}</td>
                     <td >
                                         
                        <a style="max-width:120px; text-align: left;padding:10px " rel="tooltip" title="Cancelar" class="btn btn-secondary" data-original-title="Edit"
                           href="{{route('consulta.edit', $ent->id)}}">
                          Prontuário
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