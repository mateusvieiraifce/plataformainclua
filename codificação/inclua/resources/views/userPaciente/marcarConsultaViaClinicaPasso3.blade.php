@extends('layouts.app', ['page' => __('Marcar Consulta'),'exibirPesquisa' => false, 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')


<div class="row">
   <div class="col-lg-12 col-md-12">
      <div class="card card-tasks">
         <div class="card-header">
            <h6 class="title d-inline">Escolha o profissional que vai te atender</h6>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <th> Especialista </th>
                     <th> </th>
                  </thead>
                  <tbody>
                     @if(sizeof($lista) > 0)
                   @foreach($lista as $ent)
                  <tr>
                   <td>{{$ent->nome}}</td>
                   <td>
                     <a style="max-height: 35px;"
                       href="{{route('paciente.marcarConsultaViaClinicaPasso4',[$clinica_id, $ent->id])}}"
                       class="btn btn-success">Próximo <i class="tim-icons icon-double-right"> </i> </a>
                   </td>
             @endforeach 
               @endif                    </tbody>
               </table>
               <div>
                  @if ($lista->lastPage() > 1)
                             @php
                          $paginator = $lista;
                          $paginator->url = route('clinica.list');
                      @endphp
                             <ul class="pagination">
                               <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                                 <a href="{{$paginator->url . "?page=1&filtro=" . $filtro }}">&nbsp;<<&nbsp;&nbsp;< /a>
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
                             @if($paginator->currentPage() == $i)
                         <a href="{{ $paginator->url . "?page=" . $i . "&filtro=" . $filtro }} "> <b>{{ $i }}</b> &nbsp;
                         </a>
                      @else
                   <a href="{{ $paginator->url . "?page=" . $i . "&filtro=" . $filtro }} ">{{ $i }} &nbsp; </a>
                @endif
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

            <a href="{{route('paciente.marcarConsultaViaClinicaPasso2',$clinica_id)}}" class="btn btn-primary"><i class="fa fa-reply"></i>
               Voltar</a>
         </div>
      </div>
   </div>
</div>

@endsection