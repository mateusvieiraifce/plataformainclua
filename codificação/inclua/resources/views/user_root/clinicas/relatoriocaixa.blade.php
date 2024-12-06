@extends('layouts.app', ['page' => __('Clínicas'), 'exibirPesquisa' => false, 'pageSlug' => '', 'class' => ''])
@section('title', 'Clínicas')
@section('content')
    @php
        
    @endphp
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Relatório de caixa</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Filtros</th>
                                        <th>Configurações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <form action="{{ route('user.relatorio.gerar') }}" method="POST" >
                                        @csrf
                                        <!-- Intervalo de Datas -->
                                        <tr>
                                            
                                            <td>
                                                <label for="data_inicio">Intervalo de Datas:</label>
                                            </td>
                                            <td>

                                                <div class="d-flex">
                                                    <div class="me-2">
                                                        

                                                        <label for="data_inicio">Data de Início:</label>
                                                        <input type="date" name="data_inicio" id="data_inicio" class="form-control" placeholder="Data de Início"
                                                            value="{{ old('data_inicio') }}">
                                                    </div>
                                                    <div>
                                                        <label for="data_fim">Data de Término:</label>
                                                        <input type="date" name="data_fim" id="data_fim" class="form-control" placeholder="Data de Término"
                                                            value="{{ old('data_fim') }}">
                                                    </div>
                                                    <!-- Botão Limpar ao lado da Data de Término -->
                                                    <button type="button" class="btn btn-danger ms-2" style="margin-left: 10px;" onclick="clearBothDates()">
                                                        Limpar
                                                    </button>
                                                </div>
                                            </td>
                                            @error('data_inicio')
                                                <p class="text-danger" style="font-size: 12px;">{{ $message }}</p>
                                            @enderror

                                            @error('data_fim')
                                                <p class="text-danger" style="font-size: 12px;">{{ $message }}</p>
                                            @enderror
                                        </tr>

                                        <!-- Filtro por especialista -->
                                        <tr>
                                            <td><label>Especialista:</label></td>
                                            <td>
                                                @if($especialistaSelecionado)
                                                    <input type="hidden" name="especialista_id" value="{{ $especialistaSelecionado->id }}">
                                                    <span style="display: inline-block; margin-right: 10px;">{{ $especialistaSelecionado->nome }}</span>
                                                    <a href="{{ route('user.relatorio.especialista') }}" class="btn btn-secondary" style="display: inline-block;">Alterar</a>
                                                    <!-- Remover filtro de especialista -->
                                                    <a href="{{ route('remover.filtro', ['tipo' => 'especialista']) }}" class="btn btn-danger" style="display: inline-block;">Remover</a>
                                                @else
                                                    <a href="{{ route('user.relatorio.especialista') }}" class="btn btn-primary" style="display: inline-block;">Selecionar</a>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Filtro por clínica -->
                                        <tr>
                                            <td><label>Clínica:</label></td>
                                            <td>
                                                @if($clinicaSelecionada)
                                                    <input type="hidden" name="clinica_id" value="{{ $clinicaSelecionada->id }}">
                                                    <span style="display: inline-block; margin-right: 10px;">{{ $clinicaSelecionada->nome }}</span>
                                                    <a href="{{ route('selecionar.clinica.relatorio') }}" class="btn btn-secondary" style="display: inline-block;">Alterar</a>
                                                    <!-- Remover filtro de clínica -->
                                                    <a href="{{ route('remover.filtro', ['tipo' => 'clinica']) }}" class="btn btn-danger" style="display: inline-block;">Remover</a>
                                                @else
                                                    <a href="{{ route('selecionar.clinica.relatorio') }}" class="btn btn-primary" style="display: inline-block;">Selecionar</a>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Botão de submissão -->
                                        <tr>
                                            <td>
                                                <button type="submit" class="btn btn-fill btn-primary">{{ __('Gerar Relatório') }}</button>
                                            </td>
                                        </tr>
                                    </form>
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function clearBothDates() {
            localStorage.removeItem('data_inicio');
            localStorage.removeItem('data_fim');
            document.getElementById('data_inicio').value = '';
            document.getElementById('data_fim').value = '';
        }
    </script>
    <script>
        // Salvar os dados no localStorage quando o usuário preencher o formulário
        document.getElementById('data_inicio').addEventListener('change', function () {
            localStorage.setItem('data_inicio', this.value);
        });

        document.getElementById('data_fim').addEventListener('change', function () {
            localStorage.setItem('data_fim', this.value);
        });

        // Preencher os campos de data com os valores salvos no localStorage
        window.addEventListener('load', function () {
            var dataInicio = localStorage.getItem('data_inicio');
            var dataFim = localStorage.getItem('data_fim');

            if (dataInicio) {
                document.getElementById('data_inicio').value = dataInicio;
            }

            if (dataFim) {
                document.getElementById('data_fim').value = dataFim;
            }
        });

    </script>
@endsection