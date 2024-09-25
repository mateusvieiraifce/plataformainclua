@extends('layouts.app', ['page' => __('DASHBOARD'),'pageSlug' => 'dashboard','exibirPesquisa' => false,'class'=>'dashboard','rotaPesquisa'=>'advertisement.search'])

@section('content')

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
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Vendas</span>
                                    <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-cart "></i>
                                </span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple" id="1" onclick="geraGrafico(this)">
                                    <input type="radio" id="compra" class="d-none d-sm-none" name="options">
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Compras</span>
                                    <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-delivery-fast"></i>
                                </span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple" id="2" onclick="geraGrafico(this)">
                                    <input type="radio" id="lucro" class="d-none" name="options">
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Lucro</span>
                                    <span class="d-block d-sm-none">
                                    <i class="tim-icons icon-coins"></i>
                                </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <!--  <canvas id="chartBig1"></canvas>-->
                        <!-- montando grafico geral vendas-->
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
                                    [meses[{{$vendasMes->mes}} - 1], {{$vendasMes->total_vendas}}
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

                            function drawChartCompras() {
                                var data = google.visualization.arrayToDataTable([
                                    ['', 'Total no mês'
                                    ],
                                        @foreach($ComprasPorMes as $ent)
                                    [meses[{{$ent->mes}} - 1], {{$ent->total}}
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

                            function drawChartLucro() {
                                var data = google.visualization.arrayToDataTable([
                                    ['', 'Total no mês'
                                    ],
                                        @foreach($TodasVendasPorMes as $vendasMes)
                                    [meses[{{$vendasMes->mes}} - 1], {{$vendasMes->total_lucro}}
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
                        </script>

                        <script>
                            function geraGrafico(label) {
                                if (label.id == '0') {
                                    google.charts.load('current', {'packages': ['corechart']});
                                    google.charts.setOnLoadCallback(drawChart);

                                }
                                if (label.id == '1') {
                                    google.charts.load('current', {'packages': ['corechart']});
                                    google.charts.setOnLoadCallback(drawChartCompras);

                                }
                                if (label.id == '2') {
                                    google.charts.load('current', {'packages': ['corechart']});
                                    google.charts.setOnLoadCallback(drawChartLucro);

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

    <!-- graficos por vendedor -->
    <div class="row">

        @if(sizeof($lista)>0)
            @foreach($lista as $ent)
                    <?php
                    $totalVenda = 0;
                    ?>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    var meses = [
                        "Janeiro", "Fevereiro", "Março",
                        "Abril", "Maio", "Junho",
                        "Julho", "Agosto", "Setembro",
                        "Outubro", "Novembro", "Dezembro"
                    ];
                    google.charts.load('current', {'packages': ['corechart']});
                    google.charts.setOnLoadCallback(drawChartVendedor);

                    function drawChartVendedor() {
                        var data = google.visualization.arrayToDataTable([
                            ['', 'Total no mês'
                            ],
                            //aqui faz a busca no controle de acordo com o usuario que estou passando
                                @php
                                    $dataAtual = \Carbon\Carbon::now();
                                     $SeisMesesAntes =\Carbon\Carbon::now()->subMonths(6);
                                     $dataAtual = \Carbon\Carbon::now();
                                     $TodasVendasPorMesPorUsuario =  \App\Models\Vendas::
                                  //   whereBetween('data_venda', [$umAnoAntes, $dataAtual])->
                                           selectRaw('MONTH(data_venda) as mes, sum(total) as total_vendas, count(*) as quantidade, sum(lucro) as total_lucro')
                                            ->where('comprador_id', $ent->id)
                                            ->whereBetween('data_venda', [$SeisMesesAntes, $dataAtual])
                                            ->where('vendas.tipo', '=', 'venda')
                                            ->groupBy('mes','data_venda')
                                            ->orderBy('data_venda', 'asc')
                                            ->limit(6)
                                            ->get();
                                  //  @dd($TodasVendasPorMesPorUsuario)
                                @endphp

                                @if(sizeof($TodasVendasPorMesPorUsuario)>0)
                                @foreach($TodasVendasPorMesPorUsuario as $vendas)
                                    @php
                                       $totalVenda =$totalVenda+ $vendas->total_vendas
                                    @endphp
                           [meses[{{$vendas->mes}} - 1], {{$vendas->total_vendas}}
                           ],
                               @endforeach
                               @else
                           [0, 0],
                           @endif
                       ]);
                       var options = {
                           title: '',
                           curveType: 'function',
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
                               },
                               position: 'bottom'
                           },
                           pointSize: 5,
                           pointHoverBackgroundColor: '#d048b6',
                       };
                       var chart = new google.visualization.LineChart(document.getElementById('graficoPorUsuario{{$ent->id}}'));
                       chart.draw(data, options);
                   }

                   google.charts.load('current', {'packages': ['corechart']});
                   google.charts.setOnLoadCallback(drawChart);
               </script>

               <div class="col-lg-4">
                   <div class="card card-chart">
                       <div class="card-header">
                           <h4 class="card-title">{{$ent->name}}</h4>
                           <h7 id="label{{$ent->id}}" class="card-title"><i class="tim-icons icon-coins text-primary"></i>Vendas nos últimos 6 meses:
                               {{  number_format( $totalVenda, 2, ',', '.')  }}</h7>
                       </div>
                       <div class="card-body">
                           <div class="chart-area">


                               <div id="graficoPorUsuario{{$ent->id}}" style="width: 100%; height:100%"></div>
                               <br>

                               <!-- End counter -->


                           </div>
                       </div>
                   </div>
               </div>
           @endforeach
       @endif


   </div>
   <!--

<canvas id="chartLinePurple"></canvas>

           <div class="col-lg-4">
               <div class="card card-chart">
                   <div class="card-header">
                       <h5 class="card-category">Julina fulano de tal</h5>
                       <h4 class="card-title"><i class="tim-icons icon-coins text-primary"></i>Total vendas: 763,215</h4>
                   </div>
                   <div class="card-body">
                       <div class="chart-area">
                           <canvas id="chartLineGreen"></canvas>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-lg-4">
               <div class="card card-chart">
                   <div class="card-header">
                       <h5 class="card-category">Thalivia fulano de tal</h5>
                       <h4 class="card-title"><i class="tim-icons icon-coins text-primary"></i>Total vendas: 763,215</h4>
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
                   <h5 class="card-category">Completed Tasks</h5>
                   <h3 class="card-title"><i class="tim-icons icon-send text-success"></i> 12,100K</h3>
               </div>
               <div class="card-body">
                   <div class="chart-area">
                       <canvas id="chartLineGreen"></canvas>
                   </div>
               </div>
           </div>
       </div>


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

-->
@endsection

@push('js')
   <script src="/assets/js/plugins/chartjs.min.js"></script>
   <script>
       $(document).ready(function () {
           demo.initDashboardPageCharts();
       });
   </script>
@endpush
