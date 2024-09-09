@extends('layouts.app', ['page' => __('Marcar Consulta'), 'exibirPesquisa' => false,'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')

<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">
            <form action="{{route('clinica.pesquisarPacienteMarcarconsulta')}}" method="get" id="pesquisar">
               @csrf
               <fieldset>
                  <div class="row">
                     <div class="col-sm-6 ">
                        <div class="form-group">
                           <h6 class="title d-inline">Escolha o paciente </h6>                           
                           <input type="text" name="filtro" style="margin-left:10px;margin-top:5px;" id="filtro"
                            placeholder="Pesquise por um paciente digitando o nome aqui..." class="form-control" @if(isset($filtro)) value="{{$filtro}}" @endif>
                        </div>
                     </div>
                     <div class="col-sm-1">
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
                     <th> Nome </th>
                     <th> Data de Nascimento </th>
                     <th> </th>
                  </thead>
                  <tbody>
                     @if(sizeof($lista) > 0)
                     @foreach($lista as $ent)
                     <tr>
                        <td>{{$ent->nome}}</td>
                        <td>{{date( 'd/m/Y' , strtotime($ent->data_nascimento))}}
                        <td>
                           <a style="max-height: 35px;" href="{{route('clinica.marcarConsultaSelecionarEspecialidade',$ent->id)}}" class="btn btn-success">Próximo <i class="tim-icons icon-double-right"> </i> </a>
                        </td>
                        @endforeach
                        @endif
                  </tbody>
               </table>
               <div>
                  @if ($lista->lastPage() > 1)
                  @php
                  $paginator = $lista;
                  $paginator->url = route('clinica.marcarConsultaSelecionarPaciente');
                  @endphp
                  <ul class="pagination">
                     <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                        <a href="{{$paginator->url . "?page=1&filtro=" . $filtro }}">&nbsp;<< &nbsp;&nbsp; </a>
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