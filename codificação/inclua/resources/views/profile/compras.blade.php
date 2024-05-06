@extends('layouts.app', ['page' => __('Compras'), 'pageSlug' => 'compras','class'=>'compras'])
@section('content')
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
                                            @money($comp->total)
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
