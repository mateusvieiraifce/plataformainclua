@extends('layouts.app', ['page' => __('Cadastro de Especialidade'), 'exibirPesquisa' => false, 'pageSlug' => 'especialidades-clinica', 'class' => 'especialidadeclinica'])
@section('title', 'Cadastro de Especialidade')

@section('content')
<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks">
            <div class="card-header">
               <h6 class="title d-inline">Lista de especialidades da clínica</h6>
               <div class="dropdown">
                  <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                     <i class="tim-icons icon-settings-gear-63"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                     <a class="dropdown-item" href="{{route('especialidadeclinica.newUserClinica')}}">Adicionar</a>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <th> Especialidade </th>

                        <th> Valor </th>
                        <th> Editar </th>
                        <th> Vínculo </th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                     @foreach($lista as $ent)
                   <tr>
                     <td>{{$ent->descricao}}</td>

                     <td> R$ {{ number_format($ent->valor, 2, ',', '.') }}</td>

                     <td>
                     @if($ent->isVinculado)
                        <a rel="tooltip" title="Editar" class="btn btn-link" data-original-title="Edit"
                           href="{{route('especialidadeclinica.editUserClinica', [$ent->id, $clinica->id])}}">
                           <i class="tim-icons icon-pencil"></i>
                        </a>
                      @endif   
                     </td>
                     <td>
                        @if($ent->isVinculado)
                              <label class="title" style="font-color:write">Ativo
                              </label>                             
                        @else
                              <p class="title">Inativo                                
                              </p>                              
                        @endif                              
                        </td>
                     <td> 


                     <td> 
                              
                     @if($ent->isVinculado)
                     <a href="{{route('especialidadeclinica.alterarvinculo',$ent->id)}}" 
                     onclick="return confirm('Deseja relamente excluir o vínculo?')" rel="tooltip"
                           title="Excluir vínculo" class="btn btn-link" data-original-title="Remove">
                           <i class="tim-icons icon-simple-remove"></i>
                        </a>
                     @else
                     <a href="{{route('especialidadeclinica.alterarvinculo',$ent->id)}}" 
                     onclick="return confirm('Deseja retomar vínculo?')" rel="tooltip"
                           title="Vincular novamente" class="btn btn-link" data-original-title="Remove">
                           <i class="tim-icons icon-check-2"></i>
                           </a>
                     @endif  
                     </td>

                    

               @endforeach
                     @endif
                     </tbody>
                  </table>
                  <div>
                     @if ($lista->lastPage() > 1)
                                  @php
                            $paginator = $lista;
                            $paginator->url = route('especialidadeclinica.list');
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
   @endsection