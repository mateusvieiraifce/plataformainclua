@extends('layouts.app', ['page' => __('Pagamentos'), 'exibirPesquisa' => false, 'pageSlug' => 'historico-pagamentos-pacientes', 'class' => 'pagamentos'])
@section('title', 'Pagamentos')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Histórico de Pagamentos</h6>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        @if($pagamentos->count())
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Responsável</th>
                                        <th>Cartão</th>
                                        <th>Valor</th>
                                        <th>Data de Pagamento</th>
                                        <th>Status</th>
                                        <th>Servico</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pagamentos as $pagamento)
                                        <tr>
                                            <td>
                                                {{ $pagamento->getNomeResponsavel($pagamento->user_id) }}
                                            </td>
                                            <td>
                                                {{ \App\Helper::descryptNumberCard($pagamento->getCard->numero_cartao) }}
                                            </td>
                                            <td>
                                                R$ {{ \App\Helper::padronizaMonetario($pagamento->valor) }}
                                            </td>
                                            <td>
                                                {{ isset($pagamento->data_pagamento) ? date('d/m/Y', strtotime($pagamento->data_pagamento)) : "-" }}
                                            </td>
                                            <td>
                                                {{ $pagamento->status }}
                                            </td>
                                            <td>
                                                {{ $pagamento->servico }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $pagamentos->appends(request()->query())->links() }}
                        @else
                            <h5>Você ainda não realizou nenhum pagamento.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">                
                <div class="card-header">
                    <h6 class="title d-inline">Assinatura</h6>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        @if(isset($assinaturas))
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Responsável</th>
                                        <th>Cartão</th>
                                        <th>Titular</th>
                                        <th>Data de Renovação</th>
                                        <th>Status</th>
                                        <th>Ativa</th>
                                        @foreach($assinaturas as $assinatura)
                                            @if (isset($assinaturas) && $assinatura->motivo != null)
                                                <th>Motivo</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assinaturas as $assinatura)
                                        <tr>
                                            <td>
                                                {{ $assinatura->getNomeResponsavel($assinatura->user_id) }}
                                            </td>
                                            <td>
                                                {{ \App\Helper::descryptNumberCard($assinatura->getCard->numero_cartao) }}
                                            </td>
                                            <td>
                                                {{ $assinatura->assinante }}
                                            </td>
                                            <td>
                                                {{ isset($assinatura->data_renovacao) ? date('d/m/Y', strtotime($assinatura->data_renovacao)) : "-" }}
                                            </td>
                                            <td>
                                                {{ $assinatura->status }}
                                            </td>
                                            <td>
                                                {{ $assinatura->situacao == "Ativa" ? "Sim" : "Não" }}
                                            </td>
                                            <td>
                                                @if ($assinatura->motivo != null)
                                                    {{ $assinatura->motivo }}
                                                @endif
                                            </td>
                                            <td>
                                                @if($assinatura->status == "Renovação pendente" || $assinatura->status == "Negada" && auth()->user()->tipo_user == "P")
                                                    <a class="btn btn-primary" href="{{ route('pagamento.assinatura.cartoes') }}">
                                                        Renovar
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $assinaturas->appends(request()->query())->links() }}
                        @else
                            <h5>Você ainda não possui uma assinatura.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Cartões</h6>
                    @if(!isset($assinatura))
                        <div class="dropdown">
                            <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                                <i class="tim-icons icon-settings-gear-63"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="{{ route('cartao.create', ['usuario_id' => $user->id]) }}">Cadastrar cartão</a>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
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
    </div> --}}
@endsection