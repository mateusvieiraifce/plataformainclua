@extends('layouts.app', ['pageSlug' => 'dashboard', 'class' => 'dashboard'])
@section('title', 'Dashboard')
@section('content')
    @if(\Illuminate\Support\Facades\Auth::user()->tipo_user ==='R')
        <div class="row">
            <div class="col-12">
                <div class="card card-chart">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <h5 class="card-category">Usuários</h5>
                                <h2 class="card-title">Total de usuários - {{ $totalUsers }} </h2>
                            </div>
                            <div class="col-sm-6">
                                <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                    <label class="btn btn-sm btn-primary btn-simple active" id="0">
                                        <input type="radio" name="options" checked>
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Accounts</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-single-02"></i>
                                        </span>
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple" id="1">
                                        <input type="radio" class="d-none d-sm-none" name="options">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Purchases</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-gift-2"></i>
                                        </span>
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple" id="2">
                                        <input type="radio" class="d-none" name="options">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Sessions</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-tap-02"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="chartBig1"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Consultas</h5>
                        <h3 class="card-title"><i class="tim-icons icon-bell-55 text-primary"></i> Total de consultas - {{ $totalQueries }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="chartLinePurple"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Consultas em reais</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> Total das consultas em reais - {{$totalSale}} </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="CountryChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <h5 class="card-category">Cancelamentos de consultas</h5>
                        <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> Total de cancelamentos - {{ $totalCancellations }} </h3>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="chartLineGreen"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-15 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Meus Pedidos</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="">
                            <thead class=" text-primary">
                                <tr>
                                    <th>
                                        Nº Pedido
                                    </th>
                                    <th>
                                        Data
                                    </th>
                                    <th>
                                        Valor
                                    </th>
                                    <th>
                                        Situação
                                    </th>
                                    <th>
                                        Forma de Pagamento
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                              @if(isset($compras))


                              @foreach($compras as $comp)
                                <tr>
                                    <td>
                                        {{$comp->id_venda}}
                                    </td>
                                    <td>
                                      @dataformatada($comp->created_at)
                                    </td>
                                    <td>
                                      @money($comp->valor)
                                    </td>
                                    <td>
                                      {{$comp->txt_status_pagseguro}}
                                    </td>
                                    <td>
                                        {{$comp->txt_status_metodo}}
                                    </td>
                                </tr>
                              @endforeach
                              @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Passando os dados do PHP (transformados em JSON) para o JavaScript
            var chart_data = @json(array_values($monthlyCountsUsers));

            var chart_data2 = @json(array_values($monthlyCountsQueries));

            var chart_data3 = @json(array_values($monthlyCountsQueriesSale));

            var chart_data4 = @json(array_values($monthlyCountsCancellations));

            // Inicializa o gráfico
            demo.initDashboardPageCharts(chart_data, chart_data2, chart_data3, chart_data4);
        });
    </script>
@endpush
