@extends('layouts.app', ['page' => __('Especialistas'), 'exibirPesquisa' => false, 'pageSlug' => '', 'class' => ''])
@section('title', 'Especialistas')
@section('content')
    @php
        $especialistas = Session::get('especialistas') ?? $especialistas;
    @endphp
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Escolha o especialista</h4>
                    <form action="{{ route('selecionar.especialista.search') }}" method="get" id="pesquisar">
                        <div class="row search">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="nome">
                                        Especialista
                                    </label>
                                    <div class="input-button-inline">
                                        <input type="text" name="nome" id="nome" class="form-control"
                                            placeholder="Nome do especialista" value="{{ old('nome') }}">
                                        <button class="btn btn-primary">
                                            <i class="tim-icons icon-zoom-split"></i>
                                        </button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($especialistas->count())
                            <table class="table">
                                <thead>
                                    <th>Especialista</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($especialistas as $especialista)
                                        <tr>
                                            <td>{{ $especialista->nome }}</td>
                                            <td>
                                                <a href="{{ route("$route", [$especialista->id]) }}" class="btn btn-primary">
                                                    Próximo <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $especialistas->appends(request()->query())->links() }}
                        @else
                            <h5>Não há nenhum especialista disponível.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection