@extends('layouts.app', ['page' => __('DASHBOARD'),  'exibirPesquisa' => false, 'pageSlug' => 'DASHBOARD', 'class' => 'clinica'])
@section('content')
@section('title', 'DASHBOARD')

    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-header ">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <h5 class="card-category">Controle de movimentações (1 ano)</h5>
                            <h2 class="card-title">Totais por mês </h2>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                <label class="btn btn-sm btn-primary btn-simple active" id="0"
                                       onclick="geraGrafico(this)">
                                    <input type="radio" id="venda" name="options" checked>
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Valores</span>
                                    <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-cart "></i>
                                </span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple" id="1" onclick="geraGrafico(this)">
                                    <input type="radio" id="compra" class="d-none d-sm-none" name="options">
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Quantidades</span>
                                    <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-delivery-fast"></i>
                                </span>
                                </label>                              
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <!--  <canvas id="chartBig1"></canvas>-->
                        <!-- montando grafico geral -->
                        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                        <script type="text/javascript">
                            var meses = [
                                "Janeiro", "Fevereiro", "Março",
                                "Abril", "Maio", "Junho",
                                "Julho", "Agosto", "Setembro",
                                "Outubro", "Novembro", "Dezembro"
                            ];
                            google.charts.load('current', {'packages': ['corechart']});
                            google.charts.setOnLoadCallback(drawChart);


                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['', 'Total no mês'
                                    ],
                                        @foreach($TodasVendasPorMes as $vendasMes)
                                    [meses[{{$vendasMes->mes}} - 1], {{$vendasMes->preco_total}}
                                    ],
                                    @endforeach
                                ]);
                                var options = {
                                    title: '',
                                    curveType: 'function',
                                    legend: {position: 'bottom'},
                                    colors: ['#80b6f4'],
                                    backgroundColor: 'transparent',
                                    hAxis: {
                                        textStyle: {
                                            color: '#ffffff' // Cor do texto do eixo horizontal
                                        }
                                    },
                                    vAxis: {
                                        titleTextStyle: {
                                            color: '#ffffff'
                                        },
                                        textStyle: {
                                            color: '#ffffff' // Cor do texto do eixo vertical
                                        }
                                    },
                                    legend: {
                                        textStyle: {
                                            color: '#ffffff' // Cor do texto da legenda
                                        }
                                    },
                                    pointSize: 5,
                                    pointHoverBackgroundColor: '#d048b6',
                                };
                                var chart = new google.visualization.LineChart(document.getElementById('graficoVendasGeral'));
                                chart.draw(data, options);
                            }

                            //aqui grafico com totais de consultas
                            //basta mudar a varialvel total para quantidade
                            
                          
                        </script>

                        <script>
                            function geraGrafico(label) {
                                if (label.id == '0') {
                                    google.charts.load('current', {'packages': ['corechart']});
                                    google.charts.setOnLoadCallback(drawChart);

                                }
                                if (label.id == '1') {
                                    google.charts.load('current', {'packages': ['corechart']});
                                    google.charts.setOnLoadCallback(drawChart);

                                }
                                if (label.id == '2') {
                                    google.charts.load('current', {'packages': ['corechart']});
                                    google.charts.setOnLoadCallback(drawChart);

                                }

                            }
                        </script>


                        <div class="col-lg-12 col-md-2 col-xs-12">
                            <div class="counter-box wow fadeInUp" data-wow-delay="0.3s">
                                <div id="graficoVendasGeral" style="width: 100%; height: 100%"></div>
                                <br>
                            </div>
                            <br>
                        </div>

                        <!-- End counter -->


                    </div>
                </div>
            </div>
        </div>
    </div>

   

@endsection

@push('js')
   <script src="/assets/js/plugins/chartjs.min.js"></script>
   <script>
       $(document).ready(function () {
           demo.initDashboardPageCharts();
       });
   </script>
@endpush
