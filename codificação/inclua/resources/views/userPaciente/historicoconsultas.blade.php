@extends('layouts.app', ['page' => __('Histórico de consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'historicoconsultas', 'class' => 'consulta'])
@section('content')
<style>
     .star-rating {
            display: flex;
            gap: 5px;
        }

        .star {
            font-size: 40px;
            cursor: pointer;
        }

        .star.selected {
            color: gold;
        }
</style>

 <!-- Modal avaliar consulta-->
 <div class="modal mais-baixo fade" id="meuModal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <label style="font-size:20px">Como foi a sua consulta?</label>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <!--aqui a rota de salvar as configuracoes -->
                        <form method="post" action="{{route('paciente.consulta.cancelar')}}">
                            @csrf
                            <div class="row">
                            <div class="star-rating" style="margin-left:50px">
                              <span class="star" style="margin:15px" id="s1" data-value="1">&#9733;</span>
                              <span class="star" style="margin:15px" id="s2" data-value="2">&#9733;</span>
                              <span class="star" style="margin:15px" id="s3" data-value="3">&#9733;</span>
                              <span class="star" style="margin:15px" id="s4" data-value="4">&#9733;</span>
                              <span class="star" style="margin:15px" id="s5" data-value="5">&#9733;</span>
                           </div>
                           <input type="hidden" value="" id="consulta_idM" name="consulta_idM">
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

<script>
 // Gerenciar a seleção das estrelas - para modal
 document.querySelectorAll('.star').forEach(function (star) {
            star.addEventListener('click', function () {
                document.querySelectorAll('.star').forEach(function (s) {
                      s.classList.remove('selected');
                });
                var qtd = star.getAttribute('data-value');
                for (var i = 0; i <= qtd; i++) {
                    var id = 's' + i;
                    var estrela = document.getElementById(id);
                    if (estrela) {
                       estrela.classList.add('selected');
                    }
                }
            });
        });

   
</script>
@endsection
