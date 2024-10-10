@extends('layouts.app', ['page' => __('Renovar assinatura'), 'exibirPesquisa' => false, 'pageSlug' => 'financeiro', 'class' => 'assinatura'])
@section('title', 'Renovar assinatura')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title d-inline">Selecione o cartão para renovar a assinatura</h4>
                    <div class="dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                            <i class="tim-icons icon-settings-gear-63"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('cartao.create', ['usuario_id' => $user->id]) }}">Cadastrar cartão</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if ($cartoes->count())
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Número</th>
                                        <th>Instituição</th>
                                        <th>Vencimento</th>
                                        <th>Titular</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartoes as $cartao)
                                        <tr>
                                            <td>
                                                {{ \App\Helper::descryptNumberCard($cartao->numero_cartao) }}
                                            </td>
                                            <td>
                                                {{ $cartao->instituicao }}
                                            </td>
                                            <td>
                                                {{ "$cartao->mes_validade/$cartao->ano_validade" }}
                                            </td>
                                            <td>
                                                {{ $cartao->nome_titular }}
                                            </td>
                                            <td>
                                                {{ $cartao->status }}
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('pagamento.assinatura.renovar', $cartao->id) }}">
                                                    Selecionar
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $cartoes->appends(request()->query())->links() }}
                        @else
                            <h5>Você ainda não possui um cartão cadastrado.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection