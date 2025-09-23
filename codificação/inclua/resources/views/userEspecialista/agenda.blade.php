@extends('layouts.app', ['page' => __('Agenda'), 'exibirPesquisa' => false, 'pageSlug' => 'disponibilizar-consultas', 'class' => 'consulta'])
@section('content')
@section('title', 'Agenda')
@inject('helper', 'App\Helper')
@inject('carbon', 'Carbon\Carbon')
    <script>
        function validarCheckBoxes() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var peloMenosUmSelecionado = false;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    peloMenosUmSelecionado = true;
                }
            });

            if (!peloMenosUmSelecionado) {
                alert("Por favor, selecione pelo menos um dia da semana.");
                return false;
            }

            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            var precosConsultas =  JSON.parse('{!! $relacaoEspecialidadeClinica !!}');
                const clinicaSelecionada = document.getElementById('clinica_id');
                preco = document.getElementById("preco");
                clinicaSelecionada.addEventListener('change', function() {
                precosConsultas.some(function(item) {
                    if(item.clinica_id == clinicaSelecionada.value){
                        preco.value = item.valor;
                    }
                });
                });
                clinicaSelecionada.dispatchEvent(new Event('change'));
            });

    </script>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Disponibilizar consultas</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('consulta.saveagenda', $especialista->id)}}" onsubmit="return validarCheckBoxes()">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 px-8">
                                <div class="form-group">
                                    <label id="labelFormulario">Clínica(s) vinculada(s)</label>
                                    <select name="clinica_id" id="clinica_id" class="form-control" title="Por favor selecionar ...">
                                        @foreach($clinicas as $clinica)
                                            <option style="color: #2d3748" value="{{old('especialidade_id', $clinica->id)}}">
                                                {{ $clinica->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 px-8">
                                <div class="form-group">
                                    <label id="labelFormulario">Data início</label>
                                    <input type="date" class="form-control" name="data_inicio" value="{{date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-2 px-8">
                                <div class="form-group">
                                    <label id="labelFormulario">Data fim</label>
                                    <input type="date" class="form-control" name="data_fim" value="{{ $carbon::now()->addMonth()->format('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-2 px-8">
                                <div class="form-group">
                                    <label id="labelFormulario">Duração média (min)</label>
                                    <input type="number" min="1" step="1" class="form-control" name="duracao_media" value="" required>
                                </div>
                            </div>
                            <div class="col-md-2 px-8">
                                <div class="form-group">
                                    <label id="labelFormulario">Intervalo  consultas (min)</label>
                                    <input type="number" min="0" step="1" class="form-control" name="intervalo_consulta" value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 px-8">
                                <div class="form-group">
                                    <label id="labelFormulario">Horário do Início dos atendimentos</label>
                                    <input type="time" class="form-control" name="hora_inicio" value="" required>
                                </div>
                            </div>
                            <div class="col-md-3 px-8">
                                <div class="form-group">
                                    <label id="labelFormulario">Horário do Fim dos atendimentos</label>
                                    <input type="time" class="form-control" name="hora_fim" value="" required>
                                </div>
                            </div>
                            <div class="col-md-2 px-8">
                                <div class="form-group">
                                    <label id="labelFormulario">Preço em R$</label>
                                    <input type="number" step="0.01" class="form-control" name="preco" id="preco" value="" required>
                                </div>
                            </div>
                            <div class="col-md-7 px-8">
                                <div class="form-group">
                                    <label id="labelFormulario">
                                       Dias na semana de atendimento
                                    </label>
                                    <div class="input-group{{ $errors->has('atividade_fisicas') ? ' has-danger' : '' }}">
                                        <div class="form-check text-left">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="dia[]" value="1">
                                                <span class="form-check-sign"></span>
                                                Segunda
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="dia[]" value="2">
                                                <span class="form-check-sign"></span>
                                                Terça
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="dia[]" value="3">
                                                <span class="form-check-sign"></span>
                                                Quarta
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="dia[]" value="4">
                                                <span class="form-check-sign"></span>
                                                Quinta
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="dia[]" value="5">
                                                <span class="form-check-sign"></span>
                                                Sexta
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="dia[]" value="6">
                                                <span class="form-check-sign"></span>
                                                Sábado
                                            </label>
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="dia[]" value="0">
                                                <span class="form-check-sign"></span>
                                                Domingo
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{route('consulta.list', $especialista->id)}}" class="btn btn-primary">
                                    <i class="fa fa-reply"></i>
                                    Voltar
                                </a>
                                <button class="btn btn-primary" onclick="$('#send').click(); ">
                                    Salvar
                                    <i class="fa fa-save"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="especialista_id" value="{{$especialista->id}}">
                        <input type="text" class="hidden" name="porcetagem_repasse_plataforma" value="{{ $helper::converterMonetario(env('PORCENTAGEM_REPASSE_PLATAFORMA')) }}" >
                        <input type="text" class="hidden" name="porcetagem_repasse_clinica" value="{{ $helper::converterMonetario(env('PORCENTAGEM_REPASSE_CLINICA')) }}">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
