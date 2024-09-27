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
                    <form action="{{ route('paciente.pesquisarclinicamarcarconsulta') }}" method="post" id="pesquisar">
                        @csrf
                        <div class="row search">                        
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="estado">
                                        Estado
                                    </label>
                                    <input id="estado" list="estados" name="estado" class="form-control"
                                        placeholder="Selecione o estado" value="{{ old('estado') }}">
                                    <datalist id="estados" name="estado">
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </datalist>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3">
                                <div class="form-group">
                                    <label for="cidade">
                                        Cidade
                                    </label>
                                    <input type="text" name="cidade" id="cidade" class="form-control"
                                        placeholder="Cidade da clínica" value="{{ old('cidade') }}">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label for="nome">
                                        Clínica
                                    </label>
                                    <div class="input-button-inline">
                                    <input type="text" name="nome" id="nome" class="form-control"
                                        placeholder="Nome da clínica" value="{{ old('nome') }}">
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
                                                <a href="{{ route('paciente.marcarConsultaViaEspecialidadePasso3', [$especialidade_id, $ent->id]) }}" class="btn btn-primary">
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
                    <a href="{{ route('paciente.marcarConsultaViaEspecialidadePasso1') }}" class="btn btn-primary">
                        <i class="fa fa-reply"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection