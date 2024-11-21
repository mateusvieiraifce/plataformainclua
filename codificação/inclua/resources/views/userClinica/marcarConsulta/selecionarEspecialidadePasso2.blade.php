@extends('layouts.app', ['page' => __('Marcar Consulta'), 'exibirPesquisa' => false,'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card">
            <div class="card-header">
               <h6 class="title d-inline">Escolha a área de atuação </h6>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <th>Especialidade</th>
                        <th></th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                           @foreach($lista as $ent)
                              <tr>
                                 <td>
                                    {{ $ent->descricao }}
                                 </td>
                                 <td>
                                    <a href="{{route('clinica.marcarConsultaSelecionarEspecialista', [$paciente_id, $ent->id, $clinica->id])}}" class="btn btn-primary">
                                       Próximo <i class="fa fa-arrow-right"></i>
                                    </a>
                                 </td>
                              </tr>
                            @endforeach 
                        @endif
                     </tbody>
                  </table>
                  {{ $lista->appends(request()->query())->links() }}
               </div>
               <a href="{{route('clinica.marcarConsultaSelecionarPaciente', $clinica->id)}}" class="btn btn-primary">
                  <i class="fa fa-reply"></i> Voltar
               </a>
            </div>
         </div>
      </div>
   </div>
@endsection