@extends('layouts.app', ['page' => __('Financeiro'), 'exibirPesquisa' => false, 'pageSlug' => 'financeiro', 'class' => 'financeiro'])
@section('title', 'Financeiro')
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
                                        <th>Cartão</th>
                                        <th>Valor</th>
                                        <th>Data de Pagamento</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pagamentos as $pagamento)
                                        <tr>
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
                        @if(isset($assinatura))
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cartão</th>
                                        <th>Titular</th>
                                        <th>Data de Renovação</th>
                                        <th>Status</th>
                                        <th>Ativa</th>
                                        @if (isset($assinatura) && $assinatura->motivo != null)
                                            <th>Motivo</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
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
                                            {{ $assinatura->situacao == "ATIVA" ? "Sim" : "Não" }}
                                        </td>
                                        @if ($assinatura->motivo != null)
                                            <td>
                                                {{ $assinatura->motivo }}
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <h5>Você ainda não possui uma assinatura.</h5>
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
                    <h6 class="title d-inline">Cartões</h6>
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
                        @else
                            <h5>Você ainda não possui um cartão cadastrado.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection