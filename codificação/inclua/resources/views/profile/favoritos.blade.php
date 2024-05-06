@extends('layouts.app', ['page' => __('Compras'), 'pageSlug' => 'favoritos','class'=>'favoritos'])
@section('content')
    <div class="row">
        <div class="col-lg-15 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Meus Favoritos</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="">
                            <thead class=" text-primary">
                            <tr>
                                <th>
                                    Nº Anúncio
                                </th>
                                <th>
                                    Decrição
                                </th>
                                <th>
                                    Valor
                                </th>
                                <th>
                                    Remover
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($fav))

                                @foreach($fav as $obj)
                                    <tr>
                                        <td>
                                            <a href="{{route('advertisement.detail',$obj->id_anuncio)}}"> {{$obj->id_anuncio}} </a>
                                        </td>
                                        <td>
                                            {{$obj->descricao}}
                                        </td>
                                        <td>
                                            @money($obj->preco)
                                        </td>
                                        <td>
                                         <a onClick="return confirm('Confirmar exclusão do favorito?');" href="{{route('advertisement.remfavorito',$obj->id)}}">Apagar</a>
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
