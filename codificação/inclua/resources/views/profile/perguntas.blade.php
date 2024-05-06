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

                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($comentarios))


                                @foreach($comentarios as $comp)
                                    <tr>
                                        <td>
                                            <a href="{{route('advertisement.detail',$comp->anc)}}">  {{$comp->anc}} </a>
                                        </td>
                                        <td>
                                           @dataformatada($comp->created_at)
                                        </td>

                                        <td>
                                            {{$comp->descricao}}
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
