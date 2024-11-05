@extends('layouts.app', ['page' => __('Marcar Consulta'), 'exibirPesquisa' => false,'pageSlug' => 'marcar-consulta', 'class' => 'marcar-consulta'])
@section('title', 'Marcar Consulta')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title d-inline">Escolha o paciente</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($pacientes->count())
                            <table class="table">
                                <thead>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($pacientes as $paciente)
                                        <tr>
                                            <td>{{ $paciente->nome }}</td>
                                            <td>
                                                <a href="{{ route('paciente.marcarconsulta', $paciente->id) }}" class="btn btn-primary">
                                                    Próximo <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $pacientes->appends(request()->query())->links() }}
                        @else
                            <h5>Não há nenhum paciente cadastrado.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection