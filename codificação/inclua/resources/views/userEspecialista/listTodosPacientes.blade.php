@extends('layouts.app', ['page' => __('Pacientes'), 'exibirPesquisa' => false, 'pageSlug' => 'pacientes', 'class' => 'agenda'])
@section('content')
@section('title', 'Pacientes')



<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">

            <div class="col-lg-12 col-md-12">
               <form action="{{route('especialista.listaPacientesPesquisar')}}" method="get" id="pesquisar">
               @csrf
               <fieldset>
                  <div class="row">
                     <div class="col-sm-6 ">
                        <div class="form-group">
                           <h6 class="title d-inline">Pesquise pelo nome ou cpf do paciente </h6>                           
                           <input type="text" name="filtro" style="margin-left:10px;margin-top:5px;" id="filtro"
                            placeholder="Pesquise pelo nome..." class="form-control" @if(isset($filtro)) value="{{$filtro}}" @endif>
                        </div>
                     </div>
                     <div class="col-sm-3 ">
                        <div class="form-group">
                           <h6 class="title d-inline"> </h6>                           
                           <input type="text" name="cpf" style="margin-left:10px;margin-top:5px;" id="cpf"
                            placeholder="Pesquise pelo cpf..." class="form-control" @if(isset($cpf)) value="{{$cpf}}" @endif>
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

               <h6 class="title d-inline">Lista de pacientes </h6>              
            </div>
            <div class="card-body">

               <div class="table-responsive">                  
               <table class="table">
                     <thead>                     
                        <th> Paciente </th>
                        <th> cpf </th>
                        <th> Data Nascimento </th>
                        <th> Total de consultas </th>
                        <th>  </th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                        @foreach($lista as $ent)
                     <tr>
                        <td>{{$ent->nome_paciente}}</td>
                        <td>{{$ent->cpf}}</td>
                        <td>{{date( 'd/m/Y' , strtotime($ent->data_nascimento))}}
                        <td>{{$ent->total_consultas}}</td> 
                        <td><a style="max-width:120px; text-align: left;padding:10px " rel="tooltip" 
                        title="Prontuário" class="btn btn-secondary" data-original-title="Edit"
                           href="{{route('paciente.prontuario', $ent->id)}}">
                          Prontuário
                        </a>   </td>                 
                     </tr>
                  @endforeach 
                        @endif                       </tbody>
                  </table>
                  <div>
                       {{$lista->appends(request()->query())->links()}}  
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection