@extends('layouts.app', ['page' => __('especialista'), 'rotaPesquisa' => 'especialista.search', 'pageSlug' => 'especialista', 'class' => 'especialista'])
@section('title', 'Especialista')
@section('content')
   <div class="card">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card card-tasks">
               <div class="card-header">
                  <h6 class="title d-inline">Lista de especialista </h6>
                  <div class="dropdown">
                     <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                        <i class="tim-icons icon-settings-gear-63"></i>
                     </button>
                     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{route('especialista.new')}}">Adicionar</a>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <th>Nome</th>
                           <th>Telefone</th>
                           <th>Especialidade</th>
                           <th></th>
                        </thead>
                        <tbody>
                           @if(sizeof($lista) > 0)
                              @foreach($lista as $ent)
                                 <tr>
                                    <td>
                                       {{ $ent->nome }}
                                    </td>
                                    <td>
                                       {{ $ent->telefone }}
                                    </td>
                                    <td>
                                       {{ $ent->especialidade }}
                                    </td>
                                    <td>
                                       <a href="{{ route('consulta.list', $ent->id)}}" rel="tooltip" title="Ver agenda"
                                          data-original-title="Remove">
                                          <i class="tim-icons icon-calendar-60">
                                             Agenda
                                          </i>
                                       </a>
                                    </td>
                                    <td>
                                       <a rel="tooltip" title="Editar" data-original-title="Edit"
                                          href="{{route('especialista.edit', $ent->id)}}">
                                          <i class="tim-icons icon-pencil"></i>
                                       </a>
                                    </td>
                                    <td>
                                       <a href="{{route('especialista.delete', $ent->id)}}"
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
                     {{ $lista->appends(request()->query())->links() }}
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
@endsection