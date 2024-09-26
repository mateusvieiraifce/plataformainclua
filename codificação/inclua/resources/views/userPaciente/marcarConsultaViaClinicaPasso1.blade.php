@extends('layouts.app', ['page' => __('Marcar Consulta'), 'exibirPesquisa' => false,'pageSlug' => 'marcarconsulta', 'class' => 'marcar-consulta'])
@section('title', 'Marcar Consulta')
@section('content')
    @php
        $lista = Session::get('lista') ?? $lista;
    @endphp
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Escolha onde consultar</h4>
                    <form action="{{ route('paciente.pesquisarclinicamarcarconsulta') }}" method="get" id="pesquisar">
                        @csrf
                        <div class="row search">
                            <div class="col-sm-6">
                                <div class="form-group">
                                <input type="text" name="filtro" id="filtro" class="form-control"
                                    placeholder="Pesquise por uma clínica digitando o nome dela aqui..." @if(isset($filtro)) value="{{ $filtro }}" @endif>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <button class="btn btn-primary">
                                        <i class="tim-icons icon-zoom-split"></i>
                                    </button> 
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($lista->count())
                            <table class="table">
                                <thead>
                                    <th>Clínica</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($lista as $ent)
                                        <tr>
                                            <td>{{ $ent->nome }}</td>
                                            <td>
                                                <a href="{{ route('paciente.marcarConsultaViaClinicaPasso2', $ent->id) }}" class="btn btn-primary">
                                                    Próximo <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $lista->appends(request()->query())->links() }}
                        @else
                            <h5>Não há nenhuma clínica cadastrada.</h5>
                        @endif
                    </div>
                    <a href="{{ route('paciente.marcarconsulta') }}" class="btn btn-primary">
                        <i class="fa fa-reply"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection