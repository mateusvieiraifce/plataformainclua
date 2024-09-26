@extends('layouts.app', ['page' => __('agenda'), 'exibirPesquisa' => false, 'pageSlug' => 'agendaespecialista', 'class' => 'agenda'])
@section('content')
@section('title', 'Agenda')
<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">
            <div class="col-lg-12 col-md-12">
                  <form action="{{route('consulta.search')}}" method="get" id="pesquisar">
                     @csrf
                     <label style="font-size: 20px"></label>
                     <fieldset>
                        <div class="row">
                              <div class="col-md-3 ">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">&nbsp;Data início:</label>
                                    <input style="border-color: #C0C0C0" type="date" name="inicio_data" id="inicio_data" 
                                    class="form-control"
                                             @if(isset($inicio_data))
                                                value="{{$inicio_data}}"
                                             @else
                                                value="{{date('Y-m-d')}}"
                                             @endif
                                          >
                                 </div>
                              </div>
                              <div class="col-md-3 ">
                                 <div class="form-group">
                                    <label id="labelFormulario" style="color: white">&nbsp;&nbsp;  Data
                                          final:</label>
                                    <input style="border-color: #C0C0C0" type="date" name="final_data" id="final_data"
                                             class="form-control"
                                             @if(isset($final_data))
                                                value="{{$final_data}}"
                                             @else
                                                value="{{date('Y-m-d')}}"
                                             @endif
                                          >
                                 </div>
                              </div>

                              <div class="col-md-4 px-8">
                                 <div class="form-group">
                                    <label id="labelFormulario">Clínica(s) vinculada(s)</label>
                                    <select name="clinica_id" id="clinica_id" class="form-control"
                                     style="border-color: white">                                   
                                    @foreach($clinicas as $iten)
                                    <option style="color: #2d3748" value="{{old('especialidade_id', $iten->id)}}"
                                       @if($iten->id == $clinicaselecionada_id) <?php    echo 'selected'; ?> @endif> {{$iten->nome}}
                                    </option>
                                    @endforeach
                                    </select>
                                 </div>
                              </div>

                              <div class="col-md-1 ">                       
                                 <button style="max-height: 40px; max-width: 40px;margin-top: 25px" class="btn btn-primary" >
                                    <i  class="tim-icons icon-zoom-split" >
                                    </i></button>
                              </div>
                        </div>
                     </fieldset>
                  </form>
               </div>


               <h6 class="title d-inline">Lista de consultas disponíveis </h6>
               <div class="dropdown">
                  <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                     <i class="tim-icons icon-settings-gear-63"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                     <!--   <a class="dropdown-item" href="{{route('consulta.new', $especialista->id)}}">Adicionar</a>-->
                     <a class="dropdown-item" href="{{route('consulta.agenda')}}">Disponibilizar consultas</a>
                  </div>
               </div>
            </div>
            <div class="card-body">

               <div class="table-responsive">                  
                  <table class="table">
                     <thead>
                        <th> Status </th>
                        <th> Horário agendado </th>
                        <th> Clínica </th>
                        <th> </th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                        @foreach($lista as $ent)
                     <tr>
                     <td>{{$ent->status}}</td>
                     <td>{{date( 'd/m/Y H:i' , strtotime($ent->horario_agendado))}}
                  </td>
                     <td>{{$ent->nome_clinica}}</td>
                     
                     <td>
                        <a href="{{route('consulta.delete', $ent->id)}}"
                           onclick="return confirm('Deseja relamente excluir?')" rel="tooltip" title="Excluir"
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
                            {{$lista->appends(request()->query())->links()}}                               
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection