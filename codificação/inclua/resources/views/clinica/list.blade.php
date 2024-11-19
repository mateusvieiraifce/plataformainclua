@extends('layouts.app', ['page' => __('clinica'), 'rotaPesquisa' => 'clinica.search', 'pageSlug' => 'clinica', 'class' => 'clinica'])
@section('content')
@section('title', 'Clínica')
   <div class="card">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card card-tasks">
               <div class="card-header">
                  <h6 class="title d-inline">Lista de clínicas </h6>
                  <div class="dropdown">
                     <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                        <i class="tim-icons icon-settings-gear-63"></i>
                     </button>
                     <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="{{route('clinica.new')}}">Adicionar</a>
                     </div>
                  </div>
               </div>
               <div class="card-body">
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <th>Nome Fantasia</th>
                           <th>Telefone</th>
                           <th>Celular</th>
                           <th>Usuário responsável</th>
                           <th>Especialistas</th>
                           <th>Especialidades</th>
                           <th>Situação</th>
                           <th>Editar</th>
                           <th>Desativar</th>
                        </thead>
                        <tbody>
                           @if(sizeof($lista) > 0)
                              @foreach($lista as $ent)
                                 <tr>
                                    <td>
                                       {{ $ent->nome }}
                                    </td>
                                    <td>
                                       {{ $ent->getTelefone($ent->usuario_id) }}
                                    </td>
                                    <td>
                                       {{ $ent->getCelular($ent->usuario_id) }}
                                    </td>
                                    <td>
                                       {{ $ent->getUser->nome_completo }}
                                    </td>
                                    <td>
                                       <a href="{{route('especialistaclinica.list', $ent->id)}}" rel="tooltip"
                                          title="Adicionar especialidades">
                                          <i class="tim-icons icon-single-02">
                                             Especialistas
                                          </i>
                                       </a>
                                    </td>
                                    <td>
                                       <a href="{{route('especialidadeclinica.list', $ent->id)}}" rel="tooltip"
                                          title="Adicionar especialidades">
                                          <i class="tim-icons icon-sound-wave">
                                             Especialidades
                                          </i>
                                       </a>
                                    </td>
                                    <td> 
                                       @if($ent->ativo)
                                          Ativado
                                       @else 
                                          Desativado
                                       @endif
                                    </td>
                                    <td>
                                       <a rel="tooltip" title="Editar" class="btn btn-link" data-original-title="Edit"
                                          href="{{route('clinica.edit', $ent->id)}}">
                                          <i class="tim-icons icon-pencil"></i>
                                       </a>
                                    </td>
                                    <td>
                                       @if($ent->ativo)
                                          <a href="{{route('clinica.delete', $ent->id)}}"
                                             onclick="return confirm('Deseja relamente desativar?')" rel="tooltip" title="Excluir"
                                             class="btn btn-link" data-original-title="Remove">
                                             <i class="tim-icons icon-simple-remove"></i>
                                          </a>
                                       @else
                                          <a href="{{route('clinica.delete', $ent->id)}}"
                                             onclick="return confirm('Deseja ativar novamente?')" rel="tooltip"
                                             title="Vincular novamente" class="btn btn-link" data-original-title="Remove">
                                             <i class="tim-icons icon-check-2"></i>
                                          </a>
                                       @endif  
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
@endsection