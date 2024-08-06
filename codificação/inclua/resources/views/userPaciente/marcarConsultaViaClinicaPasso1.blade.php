@extends('layouts.app', ['page' => __('Marcar Consulta'), 'exibirPesquisa' => false,'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')
<style>
   .progress {
      width: 100%;
      height: 30%;
      list-style: none;
      list-style-image: none;
      margin: 20px 0 10px 0;
      padding: 10;
   }

   .progress li {
      float: left;
      text-align: center;
      position: relative;
   }

   .progress .step {
      color: black;
      border: 3px solid silver;
      background-color: silver;
      border-radius: 20%;
      line-height: 1.2;
      width: 1.2em;
      height: 1.2em;
      display: inline-block;
      z-index: 0;
      padding: 0 0 0 50px;
      margin: 5px;
   }

   .progress .step span {
      opacity: 0.3;
   }

   .progress .step:before {
      content: "";
      display: block;
      background-color: silver;
      height: 0.4em;
      width: 50%;
      position: absolute;
      bottom: 0.6em;
      left: 0;
      z-index: -1;
   }

   .progress .step:after {
      content: "";
      display: block;
      background-color: silver;
      height: 0.4em;
      width: 50%;
      position: absolute;
      bottom: 0.6em;
      right: 0;
      z-index: -1;
   }

   .progress li:first-of-type .step:before {
      display: none;
   }

   .progress li:last-of-type .step:after {
      display: none;
   }

   .progress .done .step,
   .progress .done .step:before,
   .progress .done .step:after,
   .progress .active .step,
   .progress .active .step:before {
      background-color: yellowgreen;
   }

   .progress .done .step,
   .progress .active .step {
      border: 3px solid yellowgreen;
   }
</style>






<div class="row">
   <div class="col-lg-12 col-md-12">
      <div class="card card-tasks">
         <div class="card-header">
            <!-- barra de progresso
            <ol class="progress">        
               <li class="done">
                  <span class="step"><span></span></span>
               </li>
               <li>
                  <span class="step"><span></span></span>
               </li>
               <li>
                  <span class="step"><span></span></span>
               </li>
               <li>
                  <span class="step"><span></span></span>
               </li>
             
            </ol> -->

            <form action="{{route('paciente.pesquisarclinicamarcarconsulta')}}" method="get" id="pesquisar">
               @csrf
               <fieldset>
                  <div class="row">
                     <div class="col-sm-6 ">
                        <div class="form-group">
                           <h6 class="title d-inline">Escolha onde consultar </h6>                           
                           <input type="text" name="filtro" style="margin-left:10px;margin-top:5px;" id="filtro" placeholder="Pesquise por uma clínica digitando o nome dela aqui..." class="form-control" @if(isset($filtro)) value="{{$filtro}}" @endif>
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
                     <th> Clínica </th>
                     <th> </th>
                  </thead>
                  <tbody>
                     @if(sizeof($lista) > 0)
                     @foreach($lista as $ent)
                     <tr>
                        <td>{{$ent->nome}}</td>
                        <td>
                           <a style="max-height: 35px;" href="{{route('paciente.marcarConsultaViaClinicaPasso2',$ent->id)}}" class="btn btn-success">Próximo <i class="tim-icons icon-double-right"> </i> </a>
                        </td>
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
         <div class="col-2"> 
            <a href="{{route('paciente.marcarconsulta')}}" class="btn btn-primary"><i class="fa fa-reply"></i> Voltar</a>
            </div>
      </div>
   </div>
</div>

@endsection