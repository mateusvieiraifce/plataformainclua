@extends('layouts.app', ['page' => __('Clínicas'), 'exibirPesquisa' => false, 'pageSlug' => '', 'class' => ''])
@section('title', 'Clínicas')
@section('content')
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
                                <form action="{{ route('user.relatorio.gerar') }}" method="POST" target="_blank">
                                    @csrf
                                    <!-- Intervalo de Datas -->
                                    <tr>
                                        <td>
                                            <label for="data_inicio">Intervalo de Datas:</label>
                                        </td>
                                        <td>
                                           <div class="d-flex">
                                                <div class="me-2" style="margin-right: 10px;">
                                                    <label for="data_inicio">Data de Início:</label>
                                                    <input type="date" name="data_inicio" id="data_inicio" class="form-control" placeholder="Data de Início"
                                                        value="{{ old('data_inicio', session('data_inicio', $data_inicio)) }}">
                                                </div>
                                                <div>
                                                    <label for="data_fim">Data de Término:</label>
                                                    <input type="date" name="data_fim" id="data_fim" class="form-control" placeholder="Data de Término"
                                                        value="{{ old('data_fim', session('data_fim', $data_fim)) }}">
                                                </div>
                                            </div>
                                        </td>
                                        @error('data_inicio')
                                            <p class="text-danger" style="font-size: 12px;">{{ $message }}</p>
                                        @enderror

                                        @error('data_fim')
                                            <p class="text-danger" style="font-size: 12px;">{{ $message }}</p>
                                        @enderror
                                    </tr>
                                    @if (Auth::user()->tipo_user == 'C' || Auth::user()->tipo_user == 'R')

                                        <!-- Filtro por especialista -->
                                        <tr>
                                            <td><label>Especialista:</label></td>
                                            <td>
                                                @if($especialistaSelecionado)
                                                    <input type="hidden" name="especialista_id" value="{{ $especialistaSelecionado->id }}">
                                                    @if (Auth::user()->tipo_user == 'C')
                                                        <input type="hidden" name="clinica_id" value="{{ Auth::user()->id }}">
                                                    @endif
                                                    <span id="especialistaNome" style="display: inline-block; margin-right: 10px;">
                                                        {{ $especialistaSelecionado->nome ?? '' }}
                                                    </span>

                                                    <a href="{{ route('user.relatorio.especialista') }}" class="btn btn-secondary" style="display: inline-block;">Alterar</a>
                                                @else
                                                    <a href="{{ route('user.relatorio.especialista') }}" class="btn btn-primary" style="display: inline-block;">Selecionar</a>
                                                    @if (Auth::user()->tipo_user == 'C')
                                                        <input type="hidden" name="clinica_id" value="{{ Auth::user()->id }}">
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endif

                                    @if (Auth::user()->tipo_user == 'E' || Auth::user()->tipo_user == 'R')
                                        <!-- Filtro por clínica -->
                                        <tr>
                                            <td><label>Clínica:</label></td>
                                            <td>
                                                @if($clinicaSelecionada)
                                                    <input type="hidden" name="clinica_id" value="{{ $clinicaSelecionada->id }}">
                                                    @if (Auth::user()->tipo_user == 'E')
                                                        <input type="hidden" name="especialista_id" value="{{ Auth::user()->id }}">
                                                    @endif
                                                    <span id="clinicaNome" style="display: inline-block; margin-right: 10px;">
                                                        {{ $clinicaSelecionada->nome ?? '' }}
                                                    </span>

                                                    <a href="{{ route('selecionar.clinica.relatorio') }}" class="btn btn-secondary" style="display: inline-block;">Alterar</a>
                                                @else
                                                    <a href="{{ route('selecionar.clinica.relatorio') }}" class="btn btn-primary" style="display: inline-block;">Selecionar</a>
                                                    @if (Auth::user()->tipo_user == 'E')
                                                        <input type="hidden" name="especialista_id" value="{{ Auth::user()->id }}">
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <div style="visibility: hidden">
                                            <td></td>
                                            <td>
                                                <div class="d-flex align-items-center" style="gap: 20px; visibility: hidden">
                                                    <div>
                                                        <input type="checkbox" name="pagamentos[]" value="Pix" id="pix">
                                                        <label for="pix">Pix</label>
                                                    </div>
                                                    <div>
                                                        <input type="checkbox" name="pagamentos[]" value="Dinheiro" id="dinheiro">
                                                        <label for="dinheiro">Dinheiro</label>
                                                    </div>
                                                    <div>
                                                        <input type="checkbox" name="pagamentos[]" value="Cartão de Crédito" id="cartao_credito">
                                                        <label for="cartao_credito">Cartão de Crédito</label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <!-- Botões de Submissão e Limpar -->
                                    <tr>
                                        <td>
                                            <button type="submit" class="btn btn-fill btn-primary">{{ __('Gerar') }}</button>
                                            <a href="{{route('user.relatorio')}}" id="limparFormulario" class="btn btn-danger ms-2">Limpar</a>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('limparFormulario').addEventListener('click', function() {
                // Limpar os campos de data
                localStorage.removeItem('data_inicio');
                localStorage.removeItem('data_fim');

                // Definir a data de início como a data de hoje
                let dataHoje = new Date();
                let dataInicio = dataHoje.toISOString().split('T')[0]; // Formata como yyyy-mm-dd
                document.getElementById('data_inicio').value = dataInicio;

                // Definir a data de término como 1 mês após a data de hoje
                dataHoje.setMonth(dataHoje.getMonth() + 1);
                let dataTermino = dataHoje.toISOString().split('T')[0]; // Formata como yyyy-mm-dd
                document.getElementById('data_fim').value = dataTermino;

                // Limpar especialista
                let especialistaInput = document.querySelector('input[name="especialista_id"]');
                if (especialistaInput) {
                    especialistaInput.value = '';
                }

                let especialistaSpan = document.querySelector('span[id="especialistaNome"]');
                if (especialistaSpan) {
                    especialistaSpan.textContent = ''; // Limpar o nome do especialista
                }

                // Limpar clínica
                let clinicaInput = document.querySelector('input[name="clinica_id"]');
                if (clinicaInput) {
                    clinicaInput.value = '';
                }

                let clinicaSpan = document.querySelector('span[id="clinicaNome"]');
                if (clinicaSpan) {
                    clinicaSpan.textContent = ''; // Limpar o nome da clínica
                }

                // Atualizar os botões de "Alterar" para "Selecionar"
                let alterarButtons = document.querySelectorAll('.btn-secondary');
                alterarButtons.forEach(button => {
                    button.classList.remove('btn-secondary');
                    button.classList.add('btn-primary');
                    button.textContent = 'Selecionar';
                });

                // Enviar uma solicitação para limpar os dados da sessão
                fetch('{{ route('user.relatorio.limpar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        especialista_id: true,
                        clinica_id: true,
                        data_inicio: true,
                        data_fim: true
                    })
                })
                .then(response => response.json())
                .then(data => {
                    //console.log('Sessão limpa', data);
                })
                .catch(error => {
                    //console.error('Erro ao limpar sessão:', error);
                });
            });
        });

    </script>


@endsection
