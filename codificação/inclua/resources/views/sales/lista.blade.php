@extends('layouts.app', ['page' => __('Anúncios'), 'pageSlug' => 'advertisement','class'=>'advertisement'])
@section('content')
    <div class="card">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card card-tasks">
                    <div class="card-header ">
                        <h6 class="title d-inline">Vendas</h6>


                    </div>
                    <div class="card-body ">
                        <div class="table-full-width table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Id</td>
                                    <td>Título</td>
                                    <td>Qtd</td>
                                    <td>Tamanho</td>
                                    <td style="text-align: right">Preço de Venda(R$) </td>
                                    <td style="text-align: right">Valor a receber (R$) </td>
                                    <td>Situção</td>
                                    <td>Enviar</td>
                                </tr>

                                @foreach($anuncios as $ende)
                                    <tr style="height: 20px">

                                        <td style="max-width: 200px;">
                                            <p class="title">{{$ende->id_venda}}</p>
                                        </td>
                                        <td style="max-width: 200px;">
                                            <p class="title">{{$ende->titulo}}</p>
                                        </td>

                                        <td>
                                            <p class="title">{{\App\Helper::padronizaMonetario($ende->quantidade)}}</p>
                                        </td>
                                        <td style="max-width: 200px;">
                                            <p class="title">{{$ende->descricao}}</p>
                                        </td>

                                        <td style="text-align: right">
                                            <p class="title">{{\App\Helper::padronizaMonetario($ende->preco_item)}}</p>
                                        </td>
                                        <?php
                                        $comissao = env('COMISSAO_NORMAL');
                                        if ($ende->destaque){
                                            $comissao = env('COMISSAO_DESTAQUE');
                                        }
                                        $valor = $ende->preco_item * $comissao;

                                        ?>
                                        <td style="text-align: right">
                                            <p class="title">{{\App\Helper::padronizaMonetario($valor)}}</p>
                                        </td>

                                        <td style="max-width: 200px;">
                                            @if($ende->data_pagamento)
                                                <p class="title">Pago</p>
                                            @else
                                                <p class="title">Aguardando pagamento</p>
                                            @endif

                                                @if($ende->data_envio)
                                                    <p class="title">Enviado </p>
                                                @else
                                                    <p class="title">Não Enviado</p>
                                                @endif

                                        </td>


                                        <td class="td-actions text-left">
                                            @if($ende->data_pagamento && !$ende->data_envio)
                                            <a href="{{route('sales.send',$ende->id)}}">
                                                <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                                    <i class="tim-icons icon-send"></i>
                                                </button>
                                            </a>
                                            @else
                                                <a href="#">
                                                    <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                                        <i class="tim-icons icon-send"></i>
                                                    </button>
                                                </a>
                                            @endif
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

