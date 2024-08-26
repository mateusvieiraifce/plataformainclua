@extends('layouts.app', ['page' => __('Financeiro'), 'pageSlug' => 'financeiro', 'class' => 'financeiro'])
@section('title', 'Financeiro')
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="title d-inline">Histórico de Pagamentos</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-full-width table-responsive">
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
                                            <td style="max-width: 200px;">
                                                {{ \App\Helper::descryptNumberCard($pagamento->getCard->numero_cartao) }}
                                            </td>
                                            <td style="max-width: 200px;">
                                                R$ {{\App\Helper::padronizaMonetario($pagamento->valor)}}
                                            </td>
                                            <td style="max-width: 200px;">
                                                {{ isset($pagamento->data_pagamento) ? date('d/m/Y', strtotime($pagamento->data_pagamento)) : "-" }}
                                            </td>
                                            <td style="max-width: 200px;">
                                                {{ $pagamento->status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $pagamentos->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">                
                    <div class="card-header">
                        <h6 class="title d-inline">Assinatura</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-full-width table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Cartão</th>
                                        <th>Titular</th>
                                        <th>Data de Renovação</th>
                                        <th>Status</th>
                                        <th>Ativa</th>
                                        @if ($assinatura->motivo != null)
                                            <th>Motivo</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="height: 20px">
                                        <td style="max-width: 200px;">
                                            {{ \App\Helper::descryptNumberCard($assinatura->getCard->numero_cartao) }}
                                        </td>
                                        <td style="max-width: 200px;">
                                            {{ $assinatura->assinante }}
                                        </td>
                                        <td style="max-width: 200px;">
                                            {{ isset($assinatura->data_renovacao) ? date('d/m/Y', strtotime($assinatura->data_renovacao)) : "-" }}
                                        </td>
                                        <td style="max-width: 200px;">
                                            {{ $assinatura->status }}
                                        </td>
                                        <td style="max-width: 200px;">
                                            {{ $assinatura->situacao == "ATIVA" ? "Sim" : "Não" }}
                                        </td>
                                        @if ($assinatura->motivo != null)
                                            <td style="max-width: 200px;">
                                                {{ $assinatura->motivo }}
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="title d-inline">Cartões</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-full-width table-responsive">
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
                                            <td style="max-width: 200px;">
                                                {{ \App\Helper::descryptNumberCard($cartao->numero_cartao) }}
                                            </td>
                                            <td style="max-width: 200px;">
                                                {{ $cartao->instituicao }}
                                            </td>
                                            <td style="max-width: 200px;">
                                                {{ "$cartao->mes_validade/$cartao->ano_validade" }}
                                            </td>
                                            <td style="max-width: 200px;">
                                                {{ $cartao->nome_titular }}
                                            </td>
                                            <td style="max-width: 200px;">
                                                {{ $cartao->status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

