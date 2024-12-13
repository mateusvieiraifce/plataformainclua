@extends('layouts.app', ['page' => __('Financeiro'), 'exibirPesquisa' => false, 'pageSlug' => 'financeiro', 'class' => 'financeiro'])
@section('title', 'Financeiro')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">

                    <div class="col-lg-12 col-md-12">
                      <form action="{{route('clinica.financeiro')}}" method="get" id="pesquisar">
                         @csrf
                         <label style="font-size: 20px"></label>
                         <fieldset>
                            <div class="row">
                                  <div class="col-md-2 ">
                                     <div class="form-group">
                                        <label id="labelFormulario" style="color: white">&nbsp;Data início:</label>
                                        <input style="border-color: #C0C0C0" type="date" name="inicio_data" id="inicio_data" 
                                        class="form-control" value="{{old('inicio_data', $inicio_data) ?? date('Y-m-d')}}">
                                     </div>
                                  </div>
                                  <div class="col-md-2">
                                     <div class="form-group">
                                        <label id="labelFormulario" style="color: white">&nbsp;&nbsp;Data final:</label>
                                        <input style="border-color: #C0C0C0" type="date" name="final_data" id="final_data" class="form-control" value="{{ old('final_data', $final_data) ??  date('Y-m-d')}}">
                                     </div>
                                  </div>
                                  <div class="col-md-3 px-8">
                                     <div class="form-group">
                                        <label style="color: white">&nbsp; &nbsp; Descrição:</label>
                                        <input style="border-color: #C0C0C0" type="text" placeholder="Descrição da conta" name="descconta" id="descconta" class="form-control" value="{{ old('descconta') ?? $descconta}}">
                                     </div>
                                  </div>

                                  <div class="col-md-2 px-8">
                                    <div class="form-group">
                                        <label id="labelFormulario" style="color: white">Situação</label>
                                        <select name="status" id="status" class="form-control" style="border-color: white">
                                            <option style="color: #2d3748" value="todas" {{ old('status') == 'todas' ? 'selected' : ''
                                            }} @if ($status_selecionado == "todas")selected 
                                            @endif>Todas</option>
                                            <option style="color: #2d3748" value="pendente" {{ old('status') == 'pendente' ? 'selected' : '' }} @if ($status_selecionado == "pendente")selected 
                                            @endif>Pendente
                                            </option>
                                            <option style="color: #2d3748" value="pago" {{ old('status') == 'pago' ? 'selected' : '' }} @if ($status_selecionado == "pago")selected 
                                            @endif>Pago</option>
                                        </select>
                                    </div>
                                   </div>              

                                  <div class="col-md-1 ">                       
                                     <button style="max-height: 40px; max-width: 40px;margin-top: 25px" class="btn btn-primary">
                                     <i  class="tim-icons icon-zoom-split"></i></button>
                                  </div>
                            </div>
                         </fieldset>
                      </form>
                   </div>

                    <h6 class="title d-inline">Contas a pagar</h6>
                    <div class="dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                            <i class="tim-icons icon-settings-gear-63"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('clinica.financeiro.create') }}">Adicionar conta para pagar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            @if($contas_a_pagar->count() > 0)
                                <thead>
                                    <tr>
                                        <th>Descrição da conta</th>
                                        <th>Valor</th>
                                        <th>Situação</th>
                                        <th>Vencimento</th>
                                        <th>Editar</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($contas_a_pagar as $conta)
                                    @php
                                        $conta->vencimento = date('d/m/Y', strtotime($conta->vencimento));

                                        $conta->valor = 'R$ '.number_format($conta->valor, 2, ',', '.');
                                    @endphp
                                    <tr>
                                        <td>{{ $conta->descricao }}</td>
                                        <td>{{ $conta->valor }}</td>
                                        <td>{{ $conta->status }}</td>
                                        <td>{{ $conta->vencimento }}</td>
                                        <td>
                                            <a href="{{ route('clinica.financeiro.edit', $conta->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                        </td>
                                        <td>
                                            <a onclick="return confirm('Deseja realmente remover?') "
                                                href="{{ route('clinica.financeiro.destroy', $conta->id) }}">
                                                <button type="button" rel="tooltip" title=""
                                                    class="btn btn-link" data-original-title="Edit Task" style="color:white;">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </a>
                                        </td>
                                @endforeach
                            @else
                                 <h5>Nenhuma conta a pagar cadastrada</h5>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection