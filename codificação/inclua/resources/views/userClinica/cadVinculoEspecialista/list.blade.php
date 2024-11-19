@extends('layouts.app',['page' => __('especialistas'), 'pageSlug' => 'especialistaclinica','exibirPesquisa' => false,'class'=>'especialistaclinica'])
@section('content')
<div class="card">

   <div class="row">

      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks">
            <div class="card-header">
               <h6 class="title d-inline">Lista de especialistas vinculados </h6>
               <div class="dropdown">
                  <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                     <i class="tim-icons icon-settings-gear-63"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                     <a class="dropdown-item" href="{{route('especialistaclinica.new', $clinica->id)}}">Adicionar novo especialista</a>
                  </div>
               </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <th>Nome</th>                      
                        <th>Especialidade</th>
                        <th>Agenda</th>
                        <th>Novas Consultas</th>
                        <th>Vínculo</th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista)>0)
                           @foreach($lista as $ent)
                           <tr>
                              <td>{{$ent->nome}}</td>                          
                              <td>{{$ent->especialidade}}</td>
                              <td>
                                 <a href="{{route('especialistaclinica.agendaEspecialista', [$ent->id, $clinica->id])}}" rel="tooltip"
                                    title="Ver agenda">
                                    <i class="tim-icons icon-calendar-60">
                                       Ver Agenda
                                    </i>
                                 </a>
                              </td>
                              <td>
                                 @if($ent->isVinculado)
                                 <a href="{{route('consulta.novaConsultasUserClinica', [$ent->id, $clinica->id])}}" rel="tooltip"
                                       title="Novas consultas">
                                       <i class="tim-icons icon-notes">
                                          Criar novas consultas
                                       </i>
                                    </a>
                                 @endif                            
                              </td>
                              <td>
                                 @if($ent->isVinculado)
                                    Ativo
                                 @else
                                    Inativo
                                 @endif
                              </td>
                              <td>
                                 @if($ent->isVinculado)
                                 <a href="{{route('especialistaclinica.delete', [$ent->id, $clinica->id])}}" 
                                    onclick="return confirm('Deseja relamente excluir o vínculo?')" rel="tooltip"
                                    title="Excluir vínculo" class="btn btn-link" data-original-title="Remove">
                                    <i class="tim-icons icon-simple-remove"></i>
                                 </a>
                                 @else
                                    <a href="{{route('especialistaclinica.delete', [$ent->id, $clinica->id])}}" 
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
                  {{ $lista->appends(request()->query())->links() }}
               </div>
            </div>
         </div>
      </div>
   </div>
   @endsection