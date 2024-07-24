@extends('layouts.app', ['page' => __('clinica'), 'rotaPesquisa' => 'clinica.search', 'pageSlug' => 'clinica', 'class' => 'clinica'])
@section('content')
@section('title', 'Clínica')
<div class="card">

   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks">
            <div class="card-header">
               <h6 class="title d-inline">Lista de clínicas </h6>
               <div class="dropdown">
                  <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                     <i class="tim-icons icon-settings-gear-63"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                     <a class="dropdown-item" href="{{route('clinica.new')}}">Adicionar</a>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <th>Nome Fantasia</th>
                        <th>Telefone </th>
                        <th>Celular </th>
                        <th>Usuário responsável </th>
                        <th>Especilistas</th>
                        <th>Especialidades</th>
                        <th>Situação</th>
                        <th>Editar</th>
                        <th>Desativar</th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                           @foreach($lista as $ent)
                              <tr>
                                 <td>
                                    {{ $ent->nome }}
                                 </td>
                                 <td>
                                    {{ $ent->getTelefone($ent->usuario_id) }}
                                 </td>
                                 <td>
                                    {{ $ent->getCelular($ent->usuario_id) }}
                                 </td>
                                 <td>
                                    {{ $ent->getUser->nome_completo }}
                                 </td>
                                 <td>
                                    <a href="{{route('especialidadeclinica.list', $ent->id)}}" rel="tooltip"
                                       title="Adicionar especialidades" class="btn btn-link" data-original-title="Remove">
                                       <i class="tim-icons icon-single-02">
                                          Especilistas
                                       </i>
                                    </a>
                                 </td>
                                 <td>
                                    <a href="{{route('especialidadeclinica.list', $ent->id)}}" rel="tooltip"
                                       title="Adicionar especialidades" class="btn btn-link" data-original-title="Remove">
                                       <i class="tim-icons icon-sound-wave">
                                          Especialidades
                                       </i>
                                    </a>
                                 </td>
                                 <td> 
                                    @if($ent->ativo)
                                       Ativado
                                    @else 
                                       Desativado
                                    @endif
                                 </td>
                                 <td>
                                    <a rel="tooltip" title="Editar" class="btn btn-link" data-original-title="Edit"
                                       href="{{route('clinica.edit', $ent->id)}}">
                                       <i class="tim-icons icon-pencil"></i>
                                    </a>
                                 </td>
                                 <td>
                                    <a href="{{route('clinica.delete', $ent->id)}}"
                                       onclick="return confirm('Deseja relamente desativar?')" rel="tooltip" title="Excluir"
                                       class="btn btn-link" data-original-title="Remove">
                                       <i class="tim-icons icon-simple-remove"></i>
                                    </a>
                                 </td>
                              </tr>
                           @endforeach 
                         @endif                     
                     </tbody>
                  </table>
                  <div>
                     @if ($lista->lastPage() > 1)
                                  @php
                            $paginator = $lista;
                            $paginator->url = route('clinica.list');
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
                                     @if($paginator->currentPage() == $i)
                               <a href="{{ $paginator->url . "?page=" . $i . "&filtro=" . $filtro }} "> <b>{{ $i }}</b> &nbsp; </a>
                            @else
                         <a href="{{ $paginator->url . "?page=" . $i . "&filtro=" . $filtro }} ">{{ $i }} &nbsp; </a>
                      @endif
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
   @endsection