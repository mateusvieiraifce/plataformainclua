@extends('layouts.app', ['page' => __('Histórico de consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'historicoconsultas', 'class' => 'consulta'])
@section('content')
<section class="bg0 p-t-104 p-b-116">
<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks">
            <div class="card-header">
               <h6 class="title d-inline">Lista de consultas realizadas </h6>              
            </div>
            <div class="card-body">
               <div class="table-responsive">                  
                  <table class="table">
                     <thead>
                        <th> Horário</th>
                        <th> Dia </th>
                        <th> Médico </th>
                        <th> Especialidade </th>
                        <th> Clínica </th>
                      
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                        @foreach($lista as $ent)
                     <tr>
                     <td style="padding: 12px;">{{date( 'H:i' , strtotime($ent->horario_agendado))}}</td>                     
                     <td  style="padding: 12px;">{{date( 'd/m/Y' , strtotime($ent->horario_agendado))}}</td>
                     <td  style="padding: 12px;">{{$ent->nome_especialista}}</td>
                     <td  style="padding: 12px;">{{$ent->descricao_especialidade}}</td>
                     <td  style="padding: 12px;">{{$ent->nome_clinica}}</td>  
                              
                     </tr>
                  @endforeach 
                        @endif                       </tbody>
                  </table>
                  <div>
                     @if ($lista->lastPage() > 1)
                                 @php
                           $paginator = $lista;
                           $paginator->url = route('paciente.historicoconsultas');
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
