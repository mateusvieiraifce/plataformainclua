@extends('layouts.app', ['page' => __('Marcar Consulta'), 'exibirPesquisa' => false,'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')
    @php
        $lista = Session::get('lista') ?? $lista;
    @endphp
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card">
            <div class="card-header">
               <h4 class="title">Escolha o paciente</h4>
               <form action="{{route('clinica.pesquisarPacienteMarcarconsulta')}}" method="get" id="pesquisar">
                  <div class="row search">
                     <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                           <label for="filtro">
                                 Nome
                           </label>
                           <input type="text" name="filtro" id="filtro" class="form-control"
                              placeholder="Pesquise pelo nome..." value="{{ old('filtro') ?? $filtro }}">
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                           <label for="cpf">
                                 CPF
                           </label>
                           <div class="input-button-inline">
                              <input type="text" name="cpf" id="cpf" class="form-control"
                                 placeholder="Pesquise pelo cpf..." value="{{ old('cpf') ?? $cpf }}">
                              <button class="btn btn-primary">
                                 <i class="tim-icons icon-zoom-split"></i>
                              </button> 
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Data de Nascimento</th>
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
                                    {{ $ent->cpf }}
                                 </td>
                                 <td>
                                    {{ date( 'd/m/Y' , strtotime($ent->data_nascimento)) }}
                                 </td>
                                 <td>
                                    <a href="{{route('clinica.marcarConsultaSelecionarEspecialidade', [$ent->id, $clinica_id])}}" class="btn btn-primary">
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
            </div>
         </div>
      </div>
   </div>
@endsection