@extends('layouts.app', ['page' => __('Consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'historico-consultas-clinica', 'class' => 'agenda'])
@section('title', 'Histórico de consultas')
@section('content')
    @php
        $lista = Session::get('lista') ?? $lista;
    @endphp
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">
               <div class="col-lg-12 col-md-12">
                  <form action="{{route('consulta.listConsultaporClinicaPesquisar')}}" method="post" id="pesquisar">
                     @csrf
                     <label style="font-size: 20px"></label>
                     <fieldset>
                        <div class="row">
                           <div class="col-md-2 ">
                              <div class="form-group">
                                 <label id="labelFormulario" style="color: white">
                                    &nbsp;
                                    Data início:
                                 </label>
                                 <input style="border-color: #C0C0C0" type="date" name="inicio_data" id="inicio_data"
                                    class="form-control" value="{{ old('inicio_data') ?? $inicio_data }}">
                              </div>
                           </div>
                           <div class="col-md-2 ">
                              <div class="form-group">
                                 <label id="labelFormulario" style="color: white">
                                    &nbsp;&nbsp;
                                    Data final:
                                 </label>
                                 <input style="border-color: #C0C0C0" type="date" name="final_data" id="final_data"
                                    class="form-control" value="{{ old('final_data') ?? $final_data }}">
                              </div>
                           </div>
                           <div class="col-md-3 px-8">
                              <div class="form-group">
                                 <label style="color: white">
                                    &nbsp; &nbsp;
                                    Paciente:
                                 </label>
                                 <input style="border-color: #C0C0C0" type="text" placeholder="Nome do paciente" name="nomepaciente"
                                    id="nomepaciente" class="form-control" value="{{ old('nomepaciente') ?? $nomepaciente }}">
                              </div>
                           </div>

                           <div class="col-md-2 px-8">
                              <div class="form-group">
                                 <label style="color: white">
                                    &nbsp;
                                    Status da consulta:
                                 </label>
                                 <select style="border-color: #C0C0C0"  class="form-control" id="status" name="status" required>
                                    <option style="color: #111111" value="todos" @if(old('status') == "Todos" || $status == "Todos") selected @endif>Todos</option>
                                    <option style="color: #111111" value="Aguardando atendimento" @if(old('status') == "Aguardando atendimento" || $status == "Aguardando atendimento") selected @endif>Aguardando atendimento</option>
                                    <option style="color: #111111"value="Cancelada" @if(old('status') == "Cancelada" || $status == "Cancelada") selected @endif>Cancelada</option>
                                    <option style="color: #111111"value="Em atendimento" @if(old('status') == "Em atendimento" || $status == "Em atendimento") selected @endif>Em atendimento</option>
                                    <option style="color: #111111" value="Finalizada" @if(old('status') == "Finalizada" || $status == "Finalizada") selected @endif>Finalizada</option>
                                 </select>
                              </div>
                           </div>

                           <div class="col-md-2 px-8">
                              <div class="form-group">
                                 <label id="labelFormulario" style="color: white">
                                    Especialistas
                                 </label>
                                 <select name="especialista_id" id="especialista_id" class="form-control" style="border-color: white">
                                    <option style="color: #2d3748" value="todos">Todos</option>
                                    @foreach($especialistas as $iten)
                                       <option style="color: #2d3748" value="{{ $iten->id}}" @if($iten->id == $especialistaSelecionado_id) <?php echo 'selected'; ?> @endif>
                                          {{$iten->nome}}
                                       </option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-1 ">
                              <button style="max-height: 40px; max-width: 40px;margin-top: 25px" class="btn btn-primary">
                                 <i class="tim-icons icon-zoom-split"></i>
                              </button>
                           </div>
                        </div>
                     </fieldset>
                  </form>
               </div>

               <h6 class="title d-inline">Lista de consultas </h6>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <th>Status</th>
                        <th>Horário agendado</th>
                        @if (auth()->user()->tipo_user == "R")
                           <th>Clínica</th>
                        @endif
                        <th>Paciente</th>
                        <th>Especialista</th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                           @foreach($lista as $ent)
                              <tr>
                                 <td>
                                    {{ $ent->status }}
                                 </td>
                                 <td>
                                    {{ date( 'd/m/Y H:i' , strtotime($ent->horario_agendado)) }}
                                 </td>
                                 @if (auth()->user()->tipo_user == "R")
                                    <td>
                                       {{ $ent->nome_clinica }}
                                    </td>
                                 @endif
                                 <td>
                                    {{ $ent->nome_paciente }}
                                 </td>
                                 <td>
                                    {{ $ent->nome_especialista }}
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
