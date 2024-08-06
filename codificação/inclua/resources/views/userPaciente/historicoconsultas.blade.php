@extends('layouts.app', ['page' => __('Histórico de consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'historicoconsultas', 'class' => 'consulta'])
@section('content')

 <!-- Modal avaliar consulta-->
 <div class="modal mais-baixo fade" id="meuModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <label>O que você deseja avaliar?</label>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <!--aqui a rota de salvar as configuracoes -->
                        <form method="post" action="{{route('consulta.cancelarviapaciente')}}">
                            @csrf
                            <div class="row">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-reply"></i> Especilista
                                </button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-reply"></i> Clínica
                                </button>                             
 <!-- #region -->                                <input type="hidden" value="" id="consulta_idM" name="consulta_idM">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                        class="fa fa-reply"></i> Voltar
                                </button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                        <th> Status </th>
                        <th>  </th>
                      
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                        @foreach($lista as $ent)
                     <tr>
                     <td>{{date( 'H:i' , strtotime($ent->horario_agendado))}}</td>                     
                     <td>{{date( 'd/m/Y' , strtotime($ent->horario_agendado))}}</td>
                     <td  style="padding: 12px;">{{$ent->nome_especialista}}</td>
                     <td  style="padding: 12px;">{{$ent->descricao_especialidade}}</td>
                     <td  style="padding: 12px;">{{$ent->nome_clinica}}</td>  
                     <td  style="padding: 12px;">{{$ent->status}}</td>  
                     @if($ent->status != "Cancelada")
                       <td>
                       <a href="#"
                           target="_blank" rel="tooltip"
                           title="Avaliar consulta"
                           class="btn btn-link"
                           data-original-title="Avaliar consulta" href="#"
                           data-target="#meuModal"
                           data-toggle="modal" data-whatever="@mdo"
                           onclick="setModal({{$ent->id}})">                         
                          Avaliar
                        </a>
                       </td> 
                       
                       
                     @else
                       <td></td>  
                     @endif    
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

<script>

function setModal(consulta_id) {
    // alert(consulta_id);
    $("#consulta_idM").val(consulta_id);   
}
</script>
@endsection
