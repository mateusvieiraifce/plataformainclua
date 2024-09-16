@extends('layouts.app', ['page' => __('Marcar Consulta'), 'exibirPesquisa' => false,'pageSlug' => 'marcarconsulta', 'class' => 'marcar-consulta'])
@section('title', 'Marcar Consulta')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Escolha a área de atuação</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($lista->count())
                            <table class="table">
                                <thead>
                                    <th>Especialidade</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($lista as $ent)
                                        <tr>
                                            <td>{{ $ent->descricao }}</td>
                                            <td>
                                                <a href="{{ route('paciente.marcarConsultaViaClinicaPasso3', [$clinica_id, $ent->id]) }}" class="btn btn-primary">
                                                    Próximo <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $lista->appends(request()->query())->links() }}
                        @else
                            <h5>Não há nenhuma especialidade cadastrada.</h5>
                        @endif
                    </div>
                    <a href="{{ route('paciente.marcarConsultaViaClinicaPasso1') }}" class="btn btn-primary"><i class="fa fa-reply"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
@endsection