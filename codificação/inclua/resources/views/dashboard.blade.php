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
                                <h5 class="card-category" id="titulo_grafico">Pacientes</h5>
                                <h2 class="card-title" id="subtitulo_grafico">Total de pacientes - <span>{{ $totalUsers }} </span></h2>
                            </div>
                            <div class="col-sm-6">
                                <div class="btn-group btn-group-toggle float-right" style="pointer-events: auto;" data-toggle="buttons">
                                    <label class="btn btn-sm btn-primary btn-simple active" data-id="0" id="0">
                                        <input type="radio" name="options" checked>
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Pacientes</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-single-02"></i>
                                        </span>
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple" data-id="1" id="1">
                                        <input type="radio" name="options">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Especialistas</span>
                                        <span class="d-block d-sm-none">
                                            <i class="tim-icons icon-gift-2"></i>
                                        </span>
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple" data-id="2" id="2">
                                        <input type="radio" name="options">
                                        <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Clínicas</span>
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
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> Total - R$ {{ number_format($totalSale, 2, ',', '.') }} </h3>
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
                        <h3 class="card-title"><i class="tim-icons icon-send text-success"></i>Total - {{ $totalCancellations }} </h3>
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
@endsection

@push('js')
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Listener para o clique nos botões
            document.querySelector('.btn-group').addEventListener('click', function (event) {
                const target = event.target.closest('.btn'); // Encontra o botão clicado
                if (target) {
                    const id = target.getAttribute('data-id'); // Obtém o data-id
                    const tituloGrafico = document.getElementById('titulo_grafico');
                    const subtituloGrafico = document.getElementById('subtitulo_grafico');
                    
                    // Atualiza o título do gráfico com base no botão clicado
                    switch (id) {
                        case '0':
                            tituloGrafico.textContent = 'Pacientes';
                            subtituloGrafico.textContent = 'Total de Pacientes - ' + {{ $totalUsers }};
                            break;
                        case '1':
                            tituloGrafico.textContent = 'Especialistas';
                            subtituloGrafico.textContent = 'Total de Especialistas - ' + {{ $totalEspecialistas }};
                            break;
                        case '2':
                            tituloGrafico.textContent = 'Clínicas';
                            subtituloGrafico.textContent = 'Total de Clínicas - ' + {{ $totalClinicas }};
                            break;
                        default:
                            tituloGrafico.textContent = 'Selecione uma opção';
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Passando os dados do PHP (transformados em JSON) para o JavaScript
            var chart_data = @json(array_values($monthlyCountsUsers));

            var chart_data2 = @json(array_values($monthlyCountsQueries));

            var chart_data3 = @json(array_values($monthlyCountsQueriesSale));

            var chart_data4 = @json(array_values($monthlyCountsCancellations));

            var chart_data5 = @json(array_values($monthlyCountsEspecialistas));

            var chart_data6 = @json(array_values($monthlyCountsClinicas));

            // Inicializa o gráfico
            demo.initDashboardPageCharts(chart_data, chart_data2, chart_data3, chart_data4, chart_data5, chart_data6);
        });
    </script>
@endpush
