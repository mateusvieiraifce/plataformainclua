@extends('layouts.app', ['page' => __('Reputação'), 'exibirPesquisa' => false, 'pageSlug' => 'reputacao', 'class' => 'reputacao'])
@section('title', 'Reputação')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Reputação</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <h6>Média Geral: {{ number_format($mediaNotas, 2, ',') }}</h6>
                        @if(sizeof($avaliacoes) > 0)
                            <table class="table">
                                <thead>
                                    <th>Categoria</th>
                                    <th>Nota</th>
                                    <th>Comentário</th>
                                </thead>
                                <tbody>
                                    @foreach($avaliacoes as $avaliacao)
                                        <tr>
                                            <td>
                                                {{ $avaliacao->categoria }}
                                            </td>
                                            <td>
                                                <div class="star-rating">
                                                    @for ($i = 1; $i <= $avaliacao->nota; $i++)
                                                        <label class="star selected" >&#9733;</label>
                                                    @endfor
                                                </div>
                                            </td>
                                            <td>
                                                {{ $avaliacao->comentario }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                           {{ $avaliacoes->appends(request()->query())->links() }}
                        @else
                            <h5>Ainda não há nenhuma avaliação.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
