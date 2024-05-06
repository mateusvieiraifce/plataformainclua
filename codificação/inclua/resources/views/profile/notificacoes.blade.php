@extends('layouts.app', ['page' => __('Cometários'), 'pageSlug' => 'comentarios','class'=>'comentarios'])
@section('content')
    <div class="row">
        <div class="col-lg-15 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Meus Comentários</h4>
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
                                    Data
                                </th>
                                <th>
                                    Descrição
                                </th>
                                <th>
                                    Situação
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($comentarios))


                                @foreach($comentarios as $comp)
                                    <tr>
                                        <td >
                                            <a href="{{route('advertisement.detail',$comp->id_anuncio)}}">  {{$comp->anc}} </a>
                                        </td>
                                        <td>
                                           @dataformatada($comp->created_at)
                                        </td>

                                        <td>
                                            {{$comp->descricao}}
                                        </td>

                                        @if($comp->data_leitura)
                                        <td>
                                            <a href="#">Lida</a>
                                        </td>
                                            @else
                                            <td>
                                            <a href="{{route('user.notificacoes.ler',$comp->id)}}">Não lida</a>
                                            </td>
                                        @endif

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
