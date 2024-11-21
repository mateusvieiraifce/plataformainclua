@extends('layouts.app', ['page' => __('Reputação'), 'exibirPesquisa' => false, 'pageSlug' => 'reputacao-especialista', 'class' => 'reputacao'])
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
                        @if($especialistas->count())
                            <table class="table">
                                <thead>
                                    <th>Especialista</th>
                                    <th>CNPJ</th>
                                    <th>Medias</th>
                                </thead>
                                <tbody>
                                    @php
                                       $contador = 0;
                                    @endphp
                                    @foreach($especialistas as $especialista)
                                        @if($contador % 2 == 0)
                                            <tr>
                                                <td>
                                                    {{ $especialista->nome }}
                                                </td>
                                                <td>
                                                    {{ $helper::mascaraCNPJ($especialista->documento) }}
                                                </td>
                                                <td>
                                        @endif
                                                    @foreach ($especialista->avaliacoes as $avaliacao)
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
                                </tbody>
                            </table>
                            {{ $especialistas->appends(request()->query())->links() }}
                        @else
                            <h5>Ainda não há nenhuma avaliação.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
