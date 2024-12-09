@extends('layouts.app', ['page' => __('Financeiro'), 'exibirPesquisa' => false, 'pageSlug' => 'financeiro', 'class' => 'financeiro'])
@section('title', 'Financeiro')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
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