@extends('layouts.app', ['page' => __('Marcar Consulta'), 'exibirPesquisa' => false,'pageSlug' => 'marcarconsulta', 'class' => 'marcar-consulta'])
@section('title', 'Marcar Consulta')
@section('content')
    @php
        $clinicas = Session::get('clinicas') ?? $clinicas;
    @endphp
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Escolha a clínica</h4>
                    <form action="{{ route('selecionar.especialista.search') }}" method="post" id="pesquisar">
                        @csrf
                        <div class="row search">
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="nome">
                                        Clínica
                                    </label>
                                    <div class="input-button-inline">
                                        <input type="text" name="nome" id="nome" class="form-control"
                                            placeholder="Nome da Clínica" value="{{ old('nome') }}">
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
                        @if($clinicas->count())
                            <table class="table">
                                <thead>
                                    <th>Clínica</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($clinicas as $clinica)
                                        <tr>
                                            <td>{{ $clinica->nome }}</td>
                                            <td>
                                                <a href="{{ route("$route", [$clinica->id]) }}" class="btn btn-primary">
                                                    Próximo <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $clinicas->appends(request()->query())->links() }}
                        @else
                            <h5>Não há nenhum especialista disponível.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection