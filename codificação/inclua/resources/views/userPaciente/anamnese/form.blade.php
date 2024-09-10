@extends('layouts.app', ['page' => __('Marcar Consulta'),'exibirPesquisa' => false, 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Anamnese')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="title" id="title"></h2>
                <h4 class="title" id="subTitle"></h4>
            </div>
            <div class="card-body">
                <form id="formAnamnese" method="post" action="{{ route("anamnese.store")}}">
                    @csrf
                    <section id="form">
                        {{-- HISTÓRICO (ANTECEDENTE E ATUAL) --}}
                        {{-- PERÍODO PRÉ-NATAL (CONCEPÇÃO E GESTAÇÃO) --}}
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gravidez_programada">
                                            Foi gravidez programada?
                                        </label>
                                        <div class="input-group {{ $errors->has('gravidez_programada') ? 'has-danger' : '' }}">
                                            <select name="gravidez_programada" class="form-control {{ $errors->has('gravidez_programada') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('gravidez_programada') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('gravidez_programada') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'gravidez_programada'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="idade_mae_geracao">
                                            Qual a idade da mãe quando foi gerado(a)?
                                        </label>
                                        <div class="input-group {{ $errors->has('idade_mae_geracao') ? 'has-danger' : '' }}">
                                            <input id="idade_mae_geracao" type="text" class="form-control only-numbers" name="idade_mae_geracao"
                                                value="{{ old('idade_mae_geracao') }}">
                                            @include('alerts.feedback', ['field' => 'idade_mae_geracao'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="idade_pai_geracao">
                                            Qual a idade do pai quando foi gerado(a)?
                                        </label>
                                        <div class="input-group {{ $errors->has('idade_pai_geracao') ? 'has-danger' : '' }}">
                                            <input id="idade_pai_geracao" type="text" class="form-control only-numbers" name="idade_pai_geracao"
                                                value="{{ old('idade_pai_geracao') }}">
                                            @include('alerts.feedback', ['field' => 'idade_pai_geracao'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pre_natal">
                                            Fez pré natal?
                                        </label>
                                        <div class="input-group {{ $errors->has('pre_natal') ? 'has-danger' : '' }}">
                                            <select name="pre_natal" class="form-control {{ $errors->has('pre_natal') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('pre_natal') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('pre_natal') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'pre_natal'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="posicao_ordem_gestacao">
                                            Qual a posição da criança na ordem de gestação?
                                        </label>
                                        <div class="input-group {{ $errors->has('posicao_ordem_gestacao') ? 'has-danger' : '' }}">
                                            <input id="posicao_ordem_gestacao" type="text" class="form-control" name="posicao_ordem_gestacao"
                                                value="{{ old('posicao_ordem_gestacao') }}">
                                            @include('alerts.feedback', ['field' => 'posicao_ordem_gestacao'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tentativa_aborto">
                                            Houve tentativa ou ameaça de aborto?
                                        </label>
                                        <div class="input-group {{ $errors->has('tentativa_aborto') ? 'has-danger' : '' }}">
                                            <select name="tentativa_aborto" class="form-control {{ $errors->has('tentativa_aborto') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('tentativa_aborto') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('tentativa_aborto') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'tentativa_aborto'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exposicao_raios">
                                            Houve exposição a raios X ou semelhantes?
                                        </label>
                                        <div class="input-group {{ $errors->has('exposicao_raios') ? 'has-danger' : '' }}">
                                            <select name="exposicao_raios" class="form-control {{ $errors->has('exposicao_raios') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('exposicao_raios') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('exposicao_raios') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'exposicao_raios'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fatos_ocorridos">
                                            Fatos ocorridos durante a gestação (hemorragias, acidentes, condições de alimentação,
                                            condições emocionais, vícios, tomou algum medicamento sem orientação médica, etc)
                                        </label>
                                        <div class="input-group {{ $errors->has('fatos_ocorridos') ? 'has-danger' : '' }}">
                                            <input id="fatos_ocorridos" type="text" class="form-control" name="fatos_ocorridos" value="{{ old('fatos_ocorridos') }}">
                                            @include('alerts.feedback', ['field' => 'fatos_ocorridos'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- PERÍODO PERINATAL (PARTO) --}}
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>
                                            O parto foi realizado:
                                        </label>
                                        <div class="input-group without-margin{{ $errors->has('local_parto') ? ' has-danger' : '' }}">
                                            <div class="custom-radio">
                                                <input type="radio" name="local_parto" id="hospital" value="No hospital" @if (old("local_parto") == "No hospital") checked @endif>
                                                <label class="form-check-label" for="hospital">No hospital</label>
                                            </div>
                                            <div class="custom-radio">
                                                <input type="radio" name="local_parto" id="casa" value="Em casa" @if (old("local_parto") == "Em casa") checked @endif>
                                                <label class="form-check-label" for="casa">Em casa</label>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'local_parto'])
                                        </div>
                                        <div class="input-group without-margin{{ $errors->has('fez_parto') ? ' has-danger' : '' }} ">
                                            <div class="custom-radio">
                                                <input type="radio" name="fez_parto" id="medico" value="Com médico" @if (old("fez_parto") == "Com médico") checked @endif>
                                                <label class="form-check-label" for="medico">Com médico</label>
                                            </div>
                                            <div class="custom-radio">
                                                <input type="radio" name="fez_parto" id="parteiraEnfermeira" value="Com parteira/enfermeira" @if (old("fez_parto") == "Com parteira/enfermeira") checked @endif>
                                                <label class="form-check-label" for="parteiraEnfermeira">Com parteira/enfermeira</label>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'fez_parto'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo_parto">
                                            O parto foi?
                                        </label>
                                        <div class="input-group {{ $errors->has('tipo_parto') ? 'has-danger' : '' }}">
                                            <select name="tipo_parto" class="form-control {{ $errors->has('tipo_parto') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Normal" @if (old('tipo_parto') == 'Normal') selected @endif>Normal</option>
                                                <option value="Fórceps" @if (old('tipo_parto') == 'Fórceps') selected @endif>Fórceps</option>
                                                <option value="Cesária" @if (old('tipo_parto') == 'Cesária') selected @endif>Cesária</option>
                                                <option value="Outros" @if (old('tipo_parto') == 'Outros') selected @endif>Outros</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'tipo_parto'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="parto_prematuro">
                                            O parto foi prematuro?
                                        </label>
                                        <div class="input-group {{ $errors->has('parto_prematuro') ? 'has-danger' : '' }}">
                                            <select name="parto_prematuro" class="form-control {{ $errors->has('parto_prematuro') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('parto_prematuro') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('parto_prematuro') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'parto_prematuro'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="problemas_parto">
                                            Houve problemas na hora do parto? Qual?
                                        </label>
                                        <div class="input-group {{ $errors->has('problemas_parto') ? 'has-danger' : '' }}">
                                            <input id="problemas_parto" type="text" class="form-control" name="problemas_parto"
                                                value="{{ old('problemas_parto') }}">
                                            @include('alerts.feedback', ['field' => 'problemas_parto'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="crianca_bem_recebida">
                                            A criança foi bem recebida por todos?
                                        </label>
                                        <div class="input-group {{ $errors->has('crianca_bem_recebida') ? 'has-danger' : '' }}">
                                            <select name="crianca_bem_recebida" class="form-control {{ $errors->has('crianca_bem_recebida') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('crianca_bem_recebida') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('crianca_bem_recebida') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'crianca_bem_recebida'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- EVOLUÇÃO NA INFÂNCIA --}}
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="amamentacao">
                                            A criança foi amamentada? Por quanto tempo? 
                                        </label>
                                        <div class="input-group {{ $errors->has('amamentacao') ? 'has-danger' : '' }}">
                                            <input id="amamentacao" type="text" class="form-control" name="amamentacao" value="{{ old('amamentacao') }}">
                                            @include('alerts.feedback', ['field' => 'amamentacao'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="comeu_pastoso_solido">
                                            Quando começou a comer pastoso? E sólido?
                                        </label>
                                        <div class="input-group {{ $errors->has('comeu_pastoso_solido') ? 'has-danger' : '' }}">
                                            <input id="comeu_pastoso_solido" type="text" class="form-control" name="comeu_pastoso_solido" value="{{ old('comeu_pastoso_solido') }}">
                                            @include('alerts.feedback', ['field' => 'comeu_pastoso_solido'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tomou_todas_vacinas">
                                            A criança tomou todas as vacinas necessárias?
                                        </label>
                                        <div class="input-group {{ $errors->has('tomou_todas_vacinas') ? 'has-danger' : '' }}">
                                            <select name="tomou_todas_vacinas" class="form-control {{ $errors->has('tomou_todas_vacinas') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('tomou_todas_vacinas') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('tomou_todas_vacinas') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'tomou_todas_vacinas'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="permanencia_tres_anos">
                                            Nos três primeiros anos de vida, permaneceu mais tempo em casa com quem? 
                                        </label>
                                        <div class="input-group {{ $errors->has('permanencia_tres_anos') ? 'has-danger' : '' }}">
                                            <input id="permanencia_tres_anos" type="text" class="form-control" name="permanencia_tres_anos" value="{{ old('permanencia_tres_anos') }}">
                                            @include('alerts.feedback', ['field' => 'permanencia_tres_anos'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- DESENVOLVIMENTO PSICOMOTOR --}}
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="iniciou_sustentacao_cabeca">
                                            Com quantos meses começou a sustentação da cabeça?
                                        </label>
                                        <div class="input-group {{ $errors->has('iniciou_sustentacao_cabeca') ? 'has-danger' : '' }}">
                                            <input id="iniciou_sustentacao_cabeca" type="text" class="form-control only-numbers" name="iniciou_sustentacao_cabeca"
                                                value="{{ old('iniciou_sustentacao_cabeca') }}">
                                            @include('alerts.feedback', ['field' => 'iniciou_sustentacao_cabeca'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="idade_sentou_so">
                                            Com que idade sentou-se sozinho(a)?
                                        </label>
                                        <div class="input-group {{ $errors->has('idade_sentou_so') ? 'has-danger' : '' }}">
                                            <input id="idade_sentou_so" type="text" class="form-control" name="idade_sentou_so"
                                                value="{{ old('idade_sentou_so') }}">
                                            @include('alerts.feedback', ['field' => 'idade_sentou_so'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="idade_engatinhou">
                                            Com que idade engatinhou?
                                        </label>
                                        <div class="input-group {{ $errors->has('idade_engatinhou') ? 'has-danger' : '' }}">
                                            <input id="idade_engatinhou" type="text" class="form-control" name="idade_engatinhou"
                                                value="{{ old('idade_engatinhou') }}">
                                            @include('alerts.feedback', ['field' => 'idade_engatinhou'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="idade_andou">
                                            Com que idade andou?
                                        </label>
                                        <div class="input-group {{ $errors->has('idade_andou') ? 'has-danger' : '' }}">
                                            <input id="idade_andou" type="text" class="form-control" name="idade_andou"
                                                value="{{ old('idade_andou') }}">
                                            @include('alerts.feedback', ['field' => 'idade_andou'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="corre_naturalidade">
                                            Corre com naturalidade?
                                        </label>
                                        <div class="input-group {{ $errors->has('corre_naturalidade') ? 'has-danger' : '' }}">
                                            <select name="corre_naturalidade" class="form-control {{ $errors->has('corre_naturalidade') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('corre_naturalidade') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('corre_naturalidade') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'corre_naturalidade'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cai_facilidade">
                                            Cai com facilidade?
                                        </label>
                                        <div class="input-group {{ $errors->has('cai_facilidade') ? 'has-danger' : '' }}">
                                            <select name="cai_facilidade" class="form-control {{ $errors->has('cai_facilidade') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('cai_facilidade') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('cai_facilidade') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'cai_facilidade'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="anda_naturalidade">
                                            Anda com naturalidade ou é desastrado (atropela as pessoas)?
                                        </label>
                                        <div class="input-group {{ $errors->has('anda_naturalidade') ? 'has-danger' : '' }}">
                                            <select name="anda_naturalidade" class="form-control {{ $errors->has('anda_naturalidade') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('anda_naturalidade') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('anda_naturalidade') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'anda_naturalidade'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dominancia_lateral">
                                            Qual sua dominância lateral?
                                        </label>
                                        <div class="input-group{{ $errors->has('dominancia_lateral') ? ' has-danger' : '' }}">
                                            <div class="custom-radio">
                                                <input type="radio" name="dominancia_lateral" id="destro" value="Destro" @if (old('dominancia_lateral') == "Destro") checked @endif>
                                                <label class="form-check-label" for="destro">Destro</label>
                                            </div>
                                            <div class="custom-radio">
                                                <input type="radio" name="dominancia_lateral" id="canhoto" value="Canhoto" @if (old('dominancia_lateral') == "Canhoto") checked @endif>
                                                <label class="form-check-label" for="canhoto">Canhoto</label>
                                            </div>
                                            <div class="custom-radio">
                                                <input type="radio" name="dominancia_lateral" id="ambidestro" value="Ambidestro" @if (old('dominancia_lateral') == "Ambidestro") checked @endif>
                                                <label class="form-check-label" for="ambidestro">Ambidestro</label>
                                            </div>
                                            <div class="custom-radio">
                                                <input type="radio" name="dominancia_lateral" id="nao_identificado" value="Não identificado" @if (old('dominancia_lateral') == "Não identificado") checked @endif>
                                                <label class="form-check-label" for="nao_identificado">Não identificado</label>
                                            </div>
                                            @include('alerts.feedback', ['field' => 'dominancia_lateral'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="atividade_fisicas">
                                            Quais as atividades físicas que costuma fazer?
                                        </label>
                                        <div class="input-group{{ $errors->has('atividade_fisicas') ? ' has-danger' : '' }}">
                                            <div class="form-check text-left">
                                                <label class="form-check-label {{ $errors->has('atividade_fisicas') ? 'is-invalid' : '' }}">
                                                    <input class="form-check-input" type="checkbox" name="atividade_fisicas[]" 
                                                        @if (is_array("atividade_fisicas") && in_array("Jogar Bola", old('atividade_fisicas'))) checked @endif value="Jogar Bola">
                                                    <span class="form-check-sign"></span>
                                                    Jogar Bola
                                                </label>
                                                <label class="form-check-label {{ $errors->has('atividade_fisicas') ? 'is-invalid' : '' }}">
                                                    <input class="form-check-input" type="checkbox" name="atividade_fisicas[]"
                                                        @if (is_array("atividade_fisicas") && in_array("Subir em árvores", old('atividade_fisicas'))) checked @endif value="Subir em árvores">
                                                    <span class="form-check-sign"></span>
                                                    Subir em árvores
                                                </label>
                                                <label class="form-check-label {{ $errors->has('atividade_fisicas') ? 'is-invalid' : '' }}">
                                                    <input class="form-check-input" type="checkbox" name="atividade_fisicas[]"
                                                        @if (is_array("atividade_fisicas") && in_array("Andar de bicicleta", old('atividade_fisicas'))) checked @endif value="Andar de bicicleta">
                                                    <span class="form-check-sign"></span>
                                                    Andar de bicicleta
                                                </label>
                                                <label class="form-check-label {{ $errors->has('atividade_fisicas') ? 'is-invalid' : '' }}">
                                                    <input class="form-check-input" type="checkbox" name="atividade_fisicas[]"
                                                        @if (is_array("atividade_fisicas") && in_array("Nadar", old('atividade_fisicas'))) checked @endif value="Nadar">
                                                    <span class="form-check-sign"></span>
                                                    Nadar
                                                </label>
                                                <label class="form-check-label {{ $errors->has('atividade_fisicas') ? 'is-invalid' : '' }}">
                                                    <input class="form-check-input" type="checkbox" name="atividade_fisicas[]"
                                                        @if (is_array("atividade_fisicas") && in_array("Outros", old('atividade_fisicas'))) checked @endif value="Outros">
                                                    <span class="form-check-sign"></span>
                                                    Outros
                                                </label>
                                                @include('alerts.feedback', ['field' => 'atividade_fisicas'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- DESENVOLVIMENTO DA LINGUAGEM --}}
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="comecou_falar">
                                            Quando começou a falar?
                                        </label>
                                        <div class="input-group {{ $errors->has('comecou_falar') ? 'has-danger' : '' }}">
                                            <input id="comecou_falar" type="text" class="form-control" name="comecou_falar"
                                                value="{{ old('comecou_falar') }}">
                                            @include('alerts.feedback', ['field' => 'comecou_falar'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="teve_gagueira">
                                            Teve gagueira quando pequeno?
                                        </label>
                                        <div class="input-group {{ $errors->has('teve_gagueira') ? 'has-danger' : '' }}">
                                            <select name="teve_gagueira" class="form-control {{ $errors->has('teve_gagueira') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('teve_gagueira') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('teve_gagueira') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'teve_gagueira'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dificuldade_fala">
                                            Trocava, omitia, distorcia os fonemas (dislalia) ao falar?
                                        </label>
                                        <div class="input-group {{ $errors->has('dificuldade_fala') ? 'has-danger' : '' }}">
                                            <select name="dificuldade_fala" class="form-control {{ $errors->has('dificuldade_fala') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('dificuldade_fala') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('dificuldade_fala') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'dificuldade_fala'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="problema_visao_audicao_fala">
                                            A criança apresentou algum problema de visão, audição ou de fala?
                                        </label>
                                        <div class="input-group {{ $errors->has('problema_visao_audicao_fala') ? 'has-danger' : '' }}">
                                            <input id="problema_visao_audicao_fala" type="text" class="form-control" name="problema_visao_audicao_fala"
                                                value="{{ old('problema_visao_audicao_fala') }}">
                                            @include('alerts.feedback', ['field' => 'problema_visao_audicao_fala'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="fala_corretamente">
                                            Atualmente, fala corretamente? Se não, em que apresenta dificuldade?
                                        </label>
                                        <div class="input-group {{ $errors->has('fala_corretamente') ? 'has-danger' : '' }}">
                                            <input id="fala_corretamente" type="text" class="form-control" name="fala_corretamente"
                                                value="{{ old('fala_corretamente') }}">
                                            @include('alerts.feedback', ['field' => 'fala_corretamente'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="gosta_conversar">
                                            Gosta de conversar?
                                        </label>
                                        <div class="input-group {{ $errors->has('gosta_conversar') ? 'has-danger' : '' }}">
                                            <select name="gosta_conversar" class="form-control {{ $errors->has('gosta_conversar') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('gosta_conversar') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('gosta_conversar') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'gosta_conversar'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="conta_historias">
                                            Sabe contar histórias?
                                        </label>
                                        <div class="input-group {{ $errors->has('conta_historias') ? 'has-danger' : '' }}">
                                            <select name="conta_historias" class="form-control {{ $errors->has('conta_historias') ? 'is-invalid' : '' }}" >
                                                <option value=""></option>
                                                <option value="Sim" @if (old('conta_historias') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('conta_historias') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'conta_historias'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="conversa_adultos">
                                            Conversa com os adultos?
                                        </label>
                                        <div class="input-group {{ $errors->has('conversa_adultos') ? 'has-danger' : '' }}">
                                            <select name="conversa_adultos" class="form-control {{ $errors->has('conversa_adultos') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('conversa_adultos') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('conversa_adultos') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'conversa_adultos'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="inventa_casos">
                                            Gosta de inventar casos?
                                        </label>
                                        <div class="input-group {{ $errors->has('inventa_casos') ? 'has-danger' : '' }}">
                                            <select name="inventa_casos" class="form-control {{ $errors->has('inventa_casos') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('inventa_casos') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('inventa_casos') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'inventa_casos'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sabe_cantar">
                                            Sabe cantar? Que tipo de músicas?
                                        </label>
                                        <div class="input-group {{ $errors->has('sabe_cantar') ? 'has-danger' : '' }}">
                                            <input id="sabe_cantar" type="text" class="form-control" name="sabe_cantar"
                                                value="{{ old('sabe_cantar') }}" >
                                            @include('alerts.feedback', ['field' => 'sabe_cantar'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="gosta_musicas">
                                            Gosta de ouvir músicas?
                                        </label>
                                        <div class="input-group {{ $errors->has('gosta_musicas') ? 'has-danger' : '' }}">
                                            <select name="gosta_musicas" class="form-control {{ $errors->has('gosta_musicas') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('gosta_musicas') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('gosta_musicas') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'gosta_musicas'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- HISTÓRIA CLÍNICA --}}
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="doencas_contraidas">
                                            Quais as doenças que já teve?
                                        </label>
                                        <div class="input-group {{ $errors->has('doencas_contraidas') ? 'has-danger' : '' }}">
                                            <input id="doencas_contraidas" type="text" class="form-control" name="doencas_contraidas"
                                                value="{{ old('doencas_contraidas') }}">
                                            @include('alerts.feedback', ['field' => 'doencas_contraidas'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="teve_febre_convulsao">
                                            Teve febre alta ou convulsões, quando pequeno?
                                        </label>
                                        <div class="input-group {{ $errors->has('teve_febre_convulsao') ? 'has-danger' : '' }}">
                                            <select name="teve_febre_convulsao" class="form-control {{ $errors->has('teve_febre_convulsao') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('teve_febre_convulsao') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('teve_febre_convulsao') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'teve_febre_convulsao'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="teve_queda_acidente">
                                            Teve queda ou acidente grave?
                                        </label>
                                        <div class="input-group {{ $errors->has('teve_queda_acidente') ? 'has-danger' : '' }}">
                                            <select name="teve_queda_acidente" class="form-control {{ $errors->has('teve_queda_acidente') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('teve_queda_acidente') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('teve_queda_acidente') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'teve_queda_acidente'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fez_exame_neurologico">
                                            Fez algum exame neurológico?
                                        </label>
                                        <div class="input-group {{ $errors->has('fez_exame_neurologico') ? 'has-danger' : '' }}">
                                            <select name="fez_exame_neurologico" class="form-control {{ $errors->has('fez_exame_neurologico') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('fez_exame_neurologico') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('fez_exame_neurologico') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'fez_exame_neurologico'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="toma_medicamento_controlado">
                                            Toma medicamento controlado?
                                        </label>
                                        <div class="input-group {{ $errors->has('toma_medicamento_controlado') ? 'has-danger' : '' }}">
                                            <select name="toma_medicamento_controlado" class="form-control {{ $errors->has('toma_medicamento_controlado') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('toma_medicamento_controlado') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('toma_medicamento_controlado') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'toma_medicamento_controlado'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="remedios_controlados">
                                            Se sim, qual(is) medicamento(os) controlado(s) toma?
                                        </label>
                                        <div class="input-group {{ $errors->has('remedios_controlados') ? 'has-danger' : '' }}">
                                            <input id="remedios_controlados" type="text" class="form-control" name="remedios_controlados"
                                                value="{{ old('remedios_controlados') }}">
                                            @include('alerts.feedback', ['field' => 'remedios_controlados'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="alergico">
                                            É alérgico?
                                        </label>
                                        <div class="input-group {{ $errors->has('alergico') ? 'has-danger' : '' }}">
                                            <select name="alergico" class="form-control {{ $errors->has('alergico') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('alergico') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('alergico') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'alergico'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="apresenta_deficiencia_fisica">
                                            Apresenta alguma deficiência física?
                                        </label>
                                        <div class="input-group {{ $errors->has('apresenta_deficiencia_fisica') ? 'has-danger' : '' }}">
                                            <input id="apresenta_deficiencia_fisica" type="text" class="form-control" name="apresenta_deficiencia_fisica"
                                                value="{{ old('apresenta_deficiencia_fisica') }}">
                                            @include('alerts.feedback', ['field' => 'apresenta_deficiencia_fisica'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="dificuldade_relacionar_deficiencia">
                                            Tem dificuldade em relacionar-se com essa deficiência?
                                        </label>
                                        <div class="input-group {{ $errors->has('dificuldade_relacionar_deficiencia') ? 'has-danger' : '' }}">
                                            <select name="dificuldade_relacionar_deficiencia" class="form-control {{ $errors->has('dificuldade_relacionar_deficiencia') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('dificuldade_relacionar_deficiencia') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('dificuldade_relacionar_deficiencia') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'dificuldade_relacionar_deficiencia'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="deficiencia_intelectual_familia">
                                            Possui casos de deficiência intelectual na família?
                                        </label>
                                        <div class="input-group {{ $errors->has('deficiencia_intelectual_familia') ? 'has-danger' : '' }}">
                                            <select name="deficiencia_intelectual_familia" class="form-control {{ $errors->has('deficiencia_intelectual_familia') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('deficiencia_intelectual_familia') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('deficiencia_intelectual_familia') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'deficiencia_intelectual_familia'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ENURESE, ENCOPRESE E SONO --}}
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="aprendeu_usar_sanitario">
                                            Quando aprendeu a usar o sanitário?
                                        </label>
                                        <div class="input-group {{ $errors->has('aprendeu_usar_sanitario') ? 'has-danger' : '' }}">
                                            <input id="aprendeu_usar_sanitario" type="text" class="form-control" name="aprendeu_usar_sanitario"
                                                value="{{ old('aprendeu_usar_sanitario') }}">
                                            @include('alerts.feedback', ['field' => 'aprendeu_usar_sanitario'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="teve_enurese_noturna">
                                            Teve enurese noturna?
                                        </label>
                                        <div class="input-group {{ $errors->has('teve_enurese_noturna') ? 'has-danger' : '' }}">
                                            <select name="teve_enurese_noturna" class="form-control {{ $errors->has('teve_enurese_noturna') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('teve_enurese_noturna') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('teve_enurese_noturna') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'teve_enurese_noturna'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="teve_enurese_idade">
                                            Se sim, até que idade?
                                        </label>
                                        <div class="input-group {{ $errors->has('teve_enurese_idade') ? 'has-danger' : '' }}">
                                            <input id="teve_enurese_idade" type="text" class="form-control" name="teve_enurese_idade"
                                                value="{{ old('teve_enurese_idade') }}">
                                            @include('alerts.feedback', ['field' => 'teve_enurese_idade'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="atitude_pais_enurese">
                                            Qual a atitude dos pais?
                                        </label>
                                        <div class="input-group {{ $errors->has('atitude_pais_enurese') ? 'has-danger' : '' }}">
                                            <input id="atitude_pais_enurese" type="text" class="form-control" name="atitude_pais_enurese"
                                                value="{{ old('atitude_pais_enurese') }}">
                                            @include('alerts.feedback', ['field' => 'atitude_pais_enurese'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="onde_dorme">
                                            Onde dorme?
                                        </label>
                                        <div class="input-group {{ $errors->has('onde_dorme') ? 'has-danger' : '' }}">
                                            <input id="onde_dorme" type="text" class="form-control" name="onde_dorme"
                                                value="{{ old('onde_dorme') }}">
                                            @include('alerts.feedback', ['field' => 'onde_dorme'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="com_quem_dorme">
                                            Com quem?
                                        </label>
                                        <div class="input-group {{ $errors->has('com_quem_dorme') ? 'has-danger' : '' }}">
                                            <input id="com_quem_dorme" type="text" class="form-control" name="com_quem_dorme"
                                                value="{{ old('com_quem_dorme') }}">
                                            @include('alerts.feedback', ['field' => 'com_quem_dorme'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="tipo_sono">
                                            Tem sono tranquilo ou agitado?
                                        </label>
                                        <div class="input-group {{ $errors->has('tipo_sono') ? 'has-danger' : '' }}">
                                            <select name="tipo_sono" class="form-control {{ $errors->has('tipo_sono') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Agitado" @if (old('tipo_sono') == 'Agitado') selected @endif>Agitado</option>
                                                <option value="Tranquilo" @if (old('tipo_sono') == 'Tranquilo') selected @endif>Tranquilo</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'tipo_sono'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="conversa_dormindo">
                                            Conversa dormindo?
                                        </label>
                                        <div class="input-group {{ $errors->has('conversa_dormindo') ? 'has-danger' : '' }}">
                                            <select name="conversa_dormindo" class="form-control {{ $errors->has('conversa_dormindo') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('conversa_dormindo') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('conversa_dormindo') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'conversa_dormindo'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="range_dentes_dormindo">
                                            Range os dentes dormindo?
                                        </label>
                                        <div class="input-group {{ $errors->has('range_dentes_dormindo') ? 'has-danger' : '' }}">
                                            <select name="range_dentes_dormindo" class="form-control {{ $errors->has('range_dentes_dormindo') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('range_dentes_dormindo') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('range_dentes_dormindo') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'range_dentes_dormindo'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="quando_dorme">
                                            Dorme cedo ou tarde da noite?
                                        </label>
                                        <div class="input-group {{ $errors->has('quando_dorme') ? 'has-danger' : '' }}">
                                            <input id="quando_dorme" type="text" class="form-control" name="quando_dorme"
                                                value="{{ old('quando_dorme') }}">
                                            @include('alerts.feedback', ['field' => 'quando_dorme'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="habitos_dormir">
                                            Chupa dedo, chupeta ou possui outro hábito?
                                        </label>
                                        <div class="input-group {{ $errors->has('habitos_dormir') ? 'has-danger' : '' }}">
                                            <input id="habitos_dormir" type="text" class="form-control" name="habitos_dormir"
                                                value="{{ old('habitos_dormir') }}">
                                            @include('alerts.feedback', ['field' => 'habitos_dormir'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="atitude_pais_habitos_dormir">
                                            Qual a atitude dos pais?
                                        </label>
                                        <div class="input-group {{ $errors->has('atitude_pais_habitos_dormir') ? 'has-danger' : '' }}">
                                            <input id="atitude_pais_habitos_dormir" type="text" class="form-control" name="atitude_pais_habitos_dormir"
                                                value="{{ old('atitude_pais_habitos_dormir') }}">
                                            @include('alerts.feedback', ['field' => 'atitude_pais_habitos_dormir'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RELACIONAMENTO FAMILIAR --}}
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="adotado_legitimo">
                                            É adotado ou legítimo?
                                        </label>
                                        <div class="input-group {{ $errors->has('adotado_legitimo') ? 'has-danger' : '' }}">
                                            <select name="adotado_legitimo" class="form-control {{ $errors->has('adotado_legitimo') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Adotado" @if (old('adotado_legitimo') == 'Adotado') selected @endif>Adotado</option>
                                                <option value="Legítimo" @if (old('adotado_legitimo') == 'Legítimo') selected @endif>Legítimo</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'adotado_legitimo'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sabe_adocao">
                                            Se for adotado, conhece esta condição?
                                        </label>
                                        <div class="input-group {{ $errors->has('sabe_adocao') ? 'has-danger' : '' }}">
                                            <select name="sabe_adocao" class="form-control {{ $errors->has('sabe_adocao') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('sabe_adocao') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('sabe_adocao') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'sabe_adocao'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="aceita_adocao">
                                            Aceita que é adotado?
                                        </label>
                                        <div class="input-group {{ $errors->has('aceita_adocao') ? 'has-danger' : '' }}">
                                            <select name="aceita_adocao" class="form-control {{ $errors->has('aceita_adocao') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('aceita_adocao') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('aceita_adocao') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'aceita_adocao'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="diz_deseja_ser_crescer">
                                            Diz o que quer ser quando crescer?
                                        </label>
                                        <div class="input-group {{ $errors->has('diz_deseja_ser_crescer') ? 'has-danger' : '' }}">
                                            <select name="diz_deseja_ser_crescer" class="form-control {{ $errors->has('diz_deseja_ser_crescer') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('diz_deseja_ser_crescer') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('diz_deseja_ser_crescer') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'diz_deseja_ser_crescer'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="desejo_familia_crianca">
                                            O que a família quer que ele seja?
                                        </label>
                                        <div class="input-group {{ $errors->has('desejo_familia_crianca') ? 'has-danger' : '' }}">
                                            <input id="desejo_familia_crianca" type="text" class="form-control" name="desejo_familia_crianca"
                                                value="{{ old('desejo_familia_crianca') }}">
                                            @include('alerts.feedback', ['field' => 'desejo_familia_crianca'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="compreensao_familia_comportamento">
                                            Como a família se sente com relação ao comportamento da criança?
                                        </label>
                                        <div class="input-group {{ $errors->has('compreensao_familia_comportamento') ? 'has-danger' : '' }}">
                                            <input id="compreensao_familia_comportamento" type="text" class="form-control" name="compreensao_familia_comportamento"
                                                value="{{ old('compreensao_familia_comportamento') }}">
                                            @include('alerts.feedback', ['field' => 'compreensao_familia_comportamento'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="bom_relacionamento_familia">
                                            O aprendente se dá bem com todos da família?
                                        </label>
                                        <div class="input-group {{ $errors->has('bom_relacionamento_familia') ? 'has-danger' : '' }}">
                                            <select name="bom_relacionamento_familia" class="form-control {{ $errors->has('bom_relacionamento_familia') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('bom_relacionamento_familia') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('bom_relacionamento_familia') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'bom_relacionamento_familia'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ciumes_irmaos">
                                            Se possui irmãos, demonstra ciúmes de algum deles?
                                        </label>
                                        <div class="input-group {{ $errors->has('ciumes_irmaos') ? 'has-danger' : '' }}">
                                            <input id="ciumes_irmaos" type="text" class="form-control" name="ciumes_irmaos"
                                                value="{{ old('ciumes_irmaos') }}">
                                            @include('alerts.feedback', ['field' => 'ciumes_irmaos'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="apresenta_agressividade">
                                            Apresenta agressividade?
                                        </label>
                                        <div class="input-group {{ $errors->has('apresenta_agressividade') ? 'has-danger' : '' }}">
                                            <select name="apresenta_agressividade" class="form-control {{ $errors->has('apresenta_agressividade') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('apresenta_agressividade') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('apresenta_agressividade') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'apresenta_agressividade'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="irrita_facilmente">
                                            Irrita-se facilmente?
                                        </label>
                                        <div class="input-group {{ $errors->has('irrita_facilmente') ? 'has-danger' : '' }}">
                                            <select name="irrita_facilmente" class="form-control {{ $errors->has('irrita_facilmente') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('irrita_facilmente') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('irrita_facilmente') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'irrita_facilmente'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="obediente">
                                            É obediente?
                                        </label>
                                        <div class="input-group {{ $errors->has('obediente') ? 'has-danger' : '' }}">
                                            <input id="obediente" type="text" class="form-control" name="obediente"
                                                value="{{ old('obediente') }}">
                                            @include('alerts.feedback', ['field' => 'obediente'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="faz_perguntas_dificeis">
                                            Faz perguntas difíceis de responder?
                                        </label>
                                        <div class="input-group {{ $errors->has('faz_perguntas_dificeis') ? 'has-danger' : '' }}">
                                            <select name="faz_perguntas_dificeis" class="form-control {{ $errors->has('faz_perguntas_dificeis') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('faz_perguntas_dificeis') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('faz_perguntas_dificeis') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'faz_perguntas_dificeis'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="busca_atencao">
                                            Procura chamar atenção para si?
                                        </label>
                                        <div class="input-group {{ $errors->has('busca_atencao') ? 'has-danger' : '' }}">
                                            <select name="busca_atencao" class="form-control {{ $errors->has('busca_atencao') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('busca_atencao') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('busca_atencao') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'busca_atencao'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="presencia_violencia">
                                            Presenciou ou presencia atos de violência na família?
                                        </label>
                                        <div class="input-group {{ $errors->has('presencia_violencia') ? 'has-danger' : '' }}">
                                            <select name="presencia_violencia" class="form-control {{ $errors->has('presencia_violencia') ? 'is-invalid' : '' }}">
                                                <option value=""></option>
                                                <option value="Sim" @if (old('presencia_violencia') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('presencia_violencia') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'presencia_violencia'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="habitos_alimentares">
                                            Como são seus hábitos alimentares?
                                        </label>
                                        <div class="input-group {{ $errors->has('habitos_alimentares') ? 'has-danger' : '' }}">
                                            <input id="habitos_alimentares" type="text" class="form-control" name="habitos_alimentares"
                                                value="{{ old('habitos_alimentares') }}" required>
                                            @include('alerts.feedback', ['field' => 'habitos_alimentares'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RELACIONAMENTO SOCIAL --}}
                        <div class="tab">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="hobby">
                                            O que mais gosta de fazer (Hobby)?
                                        </label>
                                        <div class="input-group {{ $errors->has('hobby') ? 'has-danger' : '' }}">
                                            <input id="hobby" type="text" class="form-control" name="hobby"
                                                value="{{ old('hobby') }}" required>
                                            @include('alerts.feedback', ['field' => 'hobby'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="participa_atividades">
                                            Participa de atividades:
                                        </label>
                                        <div class="input-group{{ $errors->has('participa_atividades') ? ' has-danger' : '' }}">
                                            <div class="form-check without-margin text-left">
                                                <label class="form-check-label {{ $errors->has('participa_atividades') ? 'is-invalid' : '' }}">
                                                    <input class="form-check-input" type="checkbox" name="participa_atividades" @if (old('participa_atividades') == "Desportistas") checked @endif value="Desportistas">
                                                    <span class="form-check-sign"></span>
                                                    Desportistas
                                                </label>
                                                <label class="form-check-label {{ $errors->has('participa_atividades') ? 'is-invalid' : '' }}">
                                                    <input class="form-check-input" type="checkbox" name="participa_atividades" @if (old('participa_atividades') == "Artísticas") checked @endif value="Artísticas">
                                                    <span class="form-check-sign"></span>
                                                    Artísticas
                                                </label>
                                                <label class="form-check-label {{ $errors->has('participa_atividades') ? 'is-invalid' : '' }}">
                                                    <input class="form-check-input" type="checkbox" name="participa_atividades" @if (old('participa_atividades') == "Literárias") checked @endif value="Literárias">
                                                    <span class="form-check-sign"></span>
                                                    Literárias
                                                </label>
                                                <label class="form-check-label {{ $errors->has('participa_atividades') ? 'is-invalid' : '' }}">
                                                    <input class="form-check-input" type="checkbox" name="participa_atividades" @if (old('participa_atividades') == "Religiosas") checked @endif value="Religiosas">
                                                    <span class="form-check-sign"></span>
                                                    Religiosas
                                                </label>
                                                @include('alerts.feedback', ['field' => 'participa_atividades'])
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="possui_amigos">
                                            Possui amigos?
                                        </label>
                                        <div class="input-group {{ $errors->has('possui_amigos') ? 'has-danger' : '' }}">
                                            <select name="possui_amigos" class="form-control {{ $errors->has('possui_amigos') ? 'is-invalid' : '' }}" required>
                                                <option value=""></option>
                                                <option value="Sim" @if (old('possui_amigos') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('possui_amigos') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'possui_amigos'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prefere_ficar_so">
                                            Prefere ficar mais sozinho(a)?
                                        </label>
                                        <div class="input-group {{ $errors->has('prefere_ficar_so') ? 'has-danger' : '' }}">
                                            <select name="prefere_ficar_so" class="form-control {{ $errors->has('prefere_ficar_so') ? 'is-invalid' : '' }}" required>
                                                <option value=""></option>
                                                <option value="Sim" @if (old('prefere_ficar_so') == 'Sim') selected @endif>Sim</option>
                                                <option value="Não" @if (old('prefere_ficar_so') == 'Não') selected @endif>Não</option>
                                            </select>
                                            @include('alerts.feedback', ['field' => 'prefere_ficar_so'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="com_quem_brinca">
                                            Com quem gosta mais de brincar?
                                        </label>
                                        <div class="input-group {{ $errors->has('com_quem_brinca') ? 'has-danger' : '' }}">
                                            <input id="com_quem_brinca" type="text" class="form-control" name="com_quem_brinca"
                                                value="{{ old('com_quem_brinca') }}" required>
                                            @include('alerts.feedback', ['field' => 'com_quem_brinca'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cuidadoso_desligado">
                                            É cuidadoso(a) ou "desligado"(a)?
                                        </label>
                                        <div class="input-group {{ $errors->has('cuidadoso_desligado') ? 'has-danger' : '' }}">
                                            <input id="cuidadoso_desligado" type="text" class="form-control" name="cuidadoso_desligado"
                                                value="{{ old('cuidadoso_desligado') }}" required>
                                            @include('alerts.feedback', ['field' => 'cuidadoso_desligado'])
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="brinquendo_preferido">
                                            Qual o brinquedo que mais gosta?
                                        </label>
                                        <div class="input-group {{ $errors->has('brinquendo_preferido') ? 'has-danger' : '' }}">
                                            <input id="brinquendo_preferido" type="text" class="form-control" name="brinquendo_preferido"
                                                value="{{ old('brinquendo_preferido') }}" required>
                                            @include('alerts.feedback', ['field' => 'brinquendo_preferido'])
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="row">
                        <div class="col-md-12">
                            <button id="previous" type="button" class="btn btn-primary" onclick="nextPrev(-1)" disabled>
                                <i class="fa fa-reply"></i> Voltar
                            </button>
                            <button id="next" type="button" class="btn btn-primary" onclick="nextPrev(1)">
                                Próximo <i class="fa fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="id" value=" ">
                    <input type="hidden" name="especialista_id" value="">
                </form>
            </div>
        </div>
    </div>
</div>
    <script>
        // Multi-Step Form
        var currentTab = 0;
        var title = document.getElementById("title");
        var subTitle = document.getElementById("subTitle");
        var buttonPrevious = document.getElementById("previous")
        var buttonNext = document.getElementById("next")

        showTab(currentTab);

        function showTab(n) {
            var x = document.getElementsByClassName("tab");

            if (x.length > 0) {
                x[n].style.display = "block";
                if (n >= 0 && n < 7) {
                    title.innerHTML = "Histórico (antecedente e atual)"
                    subTitle.style.display = "block"
                } else if (n == 7) {
                    title.innerHTML = "Relacionamento familiar"
                    subTitle.style.display = "none"
                } else if (n == 8) {
                    title.innerHTML = "Relacionamento social"
                }

                if (n == 0) {
                    subTitle.innerHTML = "Período pré-natal (concepção e gestação)"
                    buttonPrevious.setAttribute('disabled', '')
                } else if (n == 1) {
                    subTitle.innerHTML = "Período perinatal (parto)"
                    buttonPrevious.removeAttribute('disabled');
                } else if (n == 2) {
                    subTitle.innerHTML = "Evolução da infância"
                } else if (n == 3) {
                    subTitle.innerHTML = "Desenvolvimento Psicomotor (estimativa)"
                } else if (n == 4) {
                    subTitle.innerHTML = "Desenvolvimento da linguagem (estimativa)"
                } else if (n == 5) {
                    subTitle.innerHTML = "História clínica"
                } else if (n == 6) {
                    subTitle.innerHTML = "Enurese, encoprese e sono (estimativa)"
                }
                //fixStepIndicator(n);
            }
        }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            
            if (currentTab >= x.length) {
                document.getElementById("formAnamnese").submit();
                return false;
            }
            
            showTab(currentTab);
            window.scrollTo({top: 0, left: 0, behavior: 'smooth'});
        }

        function fixStepIndicator(n) {
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            x[n].className += " active";
        }
    </script>
@endsection