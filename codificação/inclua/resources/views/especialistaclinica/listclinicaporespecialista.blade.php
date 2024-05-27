@extends('layouts.app', ['page' => __('clinicas'), 'pageSlug' => 'clinicas', 'class' => 'especialistaclinica'])
@section('content')
<div class="card">

   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks">
            <div class="card-header">
               <h6 class="title d-inline">Lista de clínicas vinculadas </h6>              
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <th> Clínica </th>
                      
                        <th> </th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                         @foreach($lista as $ent)
                           <tr>
                           <td>{{$ent->nome}}</td>                        
                           <td>
                              <a href="#" rel="tooltip" title="Ver agenda" class="btn btn-link"
                              data-original-title="Remove">
                              <i class="tim-icons icon-calendar-60">
                                 Agenda</i>
                              </a>
                           </td>
                           <td>
                              <a rel="tooltip" title="Editar" class="btn btn-link" data-original-title="Edit"
                              href="{{route('especialistaclinica.edit', $ent->id)}}">
                              <i class="tim-icons icon-money-coins"> &nbsp Financeiro</i>
                              </a>
                           </td>
                           <td>
                              <a href="{{route('especialistaclinica.delete', $ent->id)}}"
                              onclick="return confirm('Deseja relamente cancelar vínculo?')" rel="tooltip" title="Cancelar vínculo"
                              class="btn btn-link" data-original-title="Remove">
                              <i class="tim-icons icon-simple-remove"> &nbsp Cancelar vínculo</i> 
                              </a>
                           </td>
                            @endforeach 
                     @endif                     
                   </tbody>
                  </table>
                  <div>
                     @if ($lista->lastPage() > 1)
                                 @php
                           $paginator = $lista;
                           $paginator->url = route('especialistaclinica.clinicas');
                        @endphp
                                 <ul class="pagination">
                                    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a href="{{$paginator->url . "?page=1&filtro=" . $filtro }}">&nbsp;<<&nbsp;&nbsp;  </a>
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
                                 <a href="{{ $paginator->url . "?page=" . $i . "&filtro=" . $filtro }} ">{{ $i}} &nbsp; </a>
                                 </li>
                              @endif
                           @endfor
                                    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                                    <a href="{{ $paginator->url . "?page=" . $paginator->lastPage() . "&filtro=" . $filtro }}"> >></a>
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