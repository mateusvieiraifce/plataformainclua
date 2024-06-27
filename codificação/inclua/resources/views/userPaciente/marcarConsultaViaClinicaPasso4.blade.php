@extends('layouts.app', ['page' => __('Marcar Consulta'),'exibirPesquisa' => false, 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')
<div class="row">
   <div class="col-lg-12 col-md-12">
      <div class="card card-tasks">
         <div class="card-header">
            <h6 class="title d-inline">Escolha o dia e horário </h6>
            <form action="#" method="get" id="pesquisar">
        @csrf
        <label style="font-size: 20px"></label>
        <fieldset>
            <div class="row">
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label id="labelFormulario" style="color: white">&nbsp; &nbsp; Data início:</label>
                        <input type="date" name="inicio_data" id="inicio_data" class="form-control"
                               @if(isset($inicio_data))
                                   value="{{$inicio_data}}"
                            @endif>
                    </div>
                </div>
                <div class="col-md-4 ">
                    <div class="form-group">
                        <label id="labelFormulario" style="color: white">&nbsp; &nbsp; Data
                            final:</label>
                        <input type="date" name="final_data" id="final_data"
                               class="form-control"
                               @if(isset($final_data))
                                   value="{{$final_data}}"
                            @endif>
                    </div>
                </div>


                <div class="col-md-1 ">

                    <button style="max-height: 40px; max-width: 40px;margin-top: 25px" class="btn btn-primary">
                        <i class="tim-icons icon-zoom-split">
                        </i></button>
                </div>
            </div>

        </fieldset>
    </form>


         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <th> Hora </th>
                     <th> </th>
                  </thead>
                  <tbody>
                     @if(sizeof($lista) > 0)
                     @foreach($lista as $ent)
                     <tr>
                        <td>{{date( 'd/m/Y H:i' , strtotime($ent->horario_agendado))}}
                        <td>
                           <a style="max-height: 35px;" href="#" target="_blank" rel="tooltip" title="Finalizar Consulta" data-original-title="Alterar quantidade" href="#" data-target="#modalFinalizarConsulta{{$ent->id}}" data-toggle="modal" data-whatever="@mdo" class="btn btn-success">Finalizar
                           </a>
                        </td>
                        <!-- Modal altera quanditade-->
                        <div class="modal" id="modalFinalizarConsulta{{$ent->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h3 class="modal-title">
                                       <label style="color:black; font-size: 20px;">Revise sua consulta</label>
                                    </h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body">
                                    <div class="container">
                                       <!--aqui a rota de salvar a alteracao de quantidade -->
                                       <form method="post" action="{{route('paciente.marcarConsultaViaClinicaFinalizar')}}">
                                          @csrf
                                          <div class="row">
                                             <div class="col-md-12">
                                                <div class="form-group" style=" border-bottom: 1px solid black; ">
                                                   <label style="color:black; font-size: 15px;"><strong>Paciente:</strong> {{$paciente->nome}}</label>
                                                </div>
                                             </div>
                                             <div class="col-md-12 px-8">
                                                <div class="form-group" style="border-bottom: 1px solid black; ">
                                                   <label style="color:black; font-size: 15px; "><strong>Data:</strong></label>
                                                   <label style="color:black; font-size: 15px;">{{date( 'd/m/Y' , strtotime($ent->horario_agendado))}}</label>
                                                </div>
                                             </div>
                                             <div class="col-md-12 px-8">
                                                <div class="form-group" style=" border-bottom: 1px solid black; ">
                                                   <label style="color:black; font-size: 15px;"><strong>Hora:</strong> {{date( 'H:i' , strtotime($ent->horario_agendado))}}</label>
                                                </div>
                                             </div>
                                             <div class="col-md-12 px-8">
                                                <div class="form-group" style="border-bottom: 1px solid black;">
                                                   <label style="color:black; font-size: 15px;"><strong>Área de atuação:</strong> {{$especialidade->descricao}}</label>
                                                </div>
                                             </div>
                                             <div class="col-md-12 px-8">
                                                <div class="form-group"  style=" border-bottom: 1px solid black;">
                                                   <label style="color:black; font-size: 15px;"><strong>Especialista:</strong> {{$especialista->nome}}</label>
                                                </div>
                                             </div>
                                             <div class="col-md-12 px-8">
                                                <div class="form-group"  style=" border-bottom: 1px solid black; ">
                                                   <label style="color:black; font-size: 15px;"><strong>Clínica:</strong> {{$clinica->nome}}</label>
                                                </div>
                                             </div>
                                          </div>
                                          <input type="hidden" value="{{$ent->id}}" id="consulta_id" name="consulta_id">

                                    </div>

                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-reply"></i>
                                          Voltar
                                       </button>
                                       <button type="submit" class="btn btn-success">Confirmar consulta</button>
                                    </div>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
            </div>
            @endforeach
            @endif </tbody>
            </table>
            <div>
               @if ($lista->lastPage() > 1)
               @php
               $filtro="";
               $paginator = $lista;
               $paginator->url = route('clinica.list');
               @endphp
               <ul class="pagination">
                  <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                     <a href="{{$paginator->url . "?page=1&filtro=" . $filtro }}">&nbsp;<<&nbsp;&nbsp; </a>
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
                     @if ($from < $i && $i < $to) <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
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

       
      </div>
      <div class="col-2">  
      <a href="{{route('paciente.marcarConsultaViaClinicaPasso3',[$clinica->id,$especialidade->id])}}" class="btn btn-primary"><i class="fa fa-reply"></i>
      Voltar</a>
      </div>
   </div>
</div>
</div>

@endsection