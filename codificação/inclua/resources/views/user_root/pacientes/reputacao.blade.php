@extends('layouts.app', ['page' => __('Reputação'), 'exibirPesquisa' => false, 'pageSlug' => 'reputacao-pacientes', 'class' => 'reputacao'])
@section('title', 'Reputação')
@section('content')
    @inject('helper', 'App\Helper')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Reputação</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if(sizeof($pacientes) > 0)
                            <table class="table">
                                <thead>
                                    <th>Paciente</th>
                                    <th>CPF</th>
                                    <th>Responsável</th>
                                    <th>Medias</th>
                                </thead>
                                <tbody>
                                    @php
                                       $contador = 0;
                                    @endphp
                                    @foreach($pacientes as $item)
                                        @foreach ($item as $paciente)
                                            @if($contador % 2 == 0)
                                                <tr>
                                                    <td>
                                                        {{ $paciente->nome }}
                                                    </td>
                                                    <td>
                                                        {{ $helper::mascaraCPF($paciente->cpf) }}
                                                    <td>
                                                        {{ $paciente->responsavel }}
                                                    </td>
                                                    </td>{{-- 
                                                    <td>
                                                        {{ $paciente->comentario }}
                                                    </td> --}}
                                                    <td>
                                            @endif
                                                        @foreach ($paciente->avaliacoes as $avaliacao)
                                                            @php
                                                                $contador = $contador + 1;
                                                            @endphp
                                                            <div class="star-rating">
                                                                <label>{{ $avaliacao->categoria }}</label>
                                                                @for ($i = 1; $i <= $avaliacao->media; $i++)
                                                                    <label class="star selected" >&#9733;</label>
                                                                @endfor
                                                            </div>
                                                        @endforeach
                                            @if($contador % 2 == 0)                                       
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h5>Ainda não há nenhuma avaliação.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>{{-- 
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Reputação</h6>
                </div>
                <div class="card-body">
                    <h6>Média Geral: {{ number_format($mediaNotas, 2, ',') }}</h6>
                    <div class="table-responsive">
                        @if(sizeof($avaliacoes) > 0)
                            <table class="table">
                                <thead>
                                    <th>Categoria</th>
                                    <th>Nota</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            Pontualidade
                                        </td>
                                        <td>
                                            {{ number_format($mediaNotasCategoriaPontualidade, 2, ',') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Assiduidade
                                        </td>
                                        <td>
                                            {{ number_format($mediaNotasCategoriaAssiduidade, 2, ',') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                           {{ $avaliacoes->appends(request()->query())->links() }}
                        @else
                            <h5>Ainda não há nenhuma avaliação.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
