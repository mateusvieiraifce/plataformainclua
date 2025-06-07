@extends('layouts.app', ['page' => __('Atendimento'), 'exibirPesquisa' => false, 'pageSlug' => 'listconsultaporespecialista', 'class' => 'atendimento'])
@section('content')
@section('title', 'Atendimento')
    @php
        $prontuarioCompleto = session('prontuarioCompleto') ?? $prontuarioCompleto;
    @endphp

    <div class="card" style="min-height: 90vh;">
        <div class="card-header">
            <div class="row">
                <div class="col-6 col-lg-2">
                    @if($usuarioPaciente->avatar)
                        {!! Html::image($usuarioPaciente->avatar) !!}

                    @else
                        <img src="/assets/img/anime3.png" alt="{{ __('Profile Photo') }}"
                             style="height: 100px; width: 100px;">
                    @endif
                </div>
                <div class="col-6 col-lg-3">
                    <h6 class="title d-inline">Paciente: {{$paciente->nome}}</h6>
                    <br>
                    <h6 class="title d-inline">
                        Idade: {{ $idadePaciente }} anos
                    </h6>
                </div>
                <div class="col-6 col-lg-4">
                    @if(isset($primeiraConsulta))
                        <h6 class="title d-inline">
                            Primeira consulta em {{ date('d/m/Y H:i', strtotime($primeiraConsulta->horario_agendado)) }}
                        </h6>
                    @else
                        <h6 class="title d-inline">Primeira consulta.</h6>
                    @endif
                    <br>
                    <h6 class="title d-inline">Total de consultas realizadas: {{ $qtdConsultasRealizadas }}</h6>
                </div>
                <div class="col-6 col-lg-2">
                    <div id="chronometer" name="cronometro">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body justify-content-between flex-column">
            <div class="row">
                <div class="tab-container">
                    <div class="tabs">
                        <div class="col-md-12">
                            <button class="tab-button btn-primary {{ $aba == "prontuarioatual" ? "active" : "" }}" onclick="openTab(event, 'prontuarioatual')">
                                Pronturário Atual
                            </button>
                            <button class="tab-button btn-primary {{ $aba == "prescricoes" ? "active" : "" }}" onclick="openTab(event, 'prescricoes')">
                                Prescrições
                            </button>
                            <button class="tab-button btn-primary {{ $aba == "exames" ? "active" : "" }}" onclick="openTab(event, 'exames')">
                                Pedidos de exames
                            </button>
                            <button class="tab-button btn-primary {{ $aba == "atestados" ? "active" : "" }}" onclick="openTab(event, 'atestados')">
                                Atestados
                            </button>
                            <button class="tab-button btn-primary {{ $aba == "prontuario" ? "active" : "" }}" onclick="openTab(event, 'prontuario')">
                                Prontuário completo
                            </button>
                            <button class="tab-button btn-primary {{ $aba == "anamnese" ? "active" : "" }}" onclick="openTab(event, 'anamnese')">
                                Anamnese
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="tab-content">
                            <div id="prontuarioatual" class="tab-pane {{ $aba == "prontuarioatual" ? "active" : "" }}">
                                <div class="col-md-12">
                                    <form action="{{ route('prontuario.store') }}" method="post">
                                        @csrf
                                        <div class="form-group{{ $errors->has('dados_consulta') ? ' has-danger' : '' }}">
                                            <label for="dados_consulta">
                                                Dados da consulta:
                                            </label>
                                            <textarea class="form-control{{ $errors->has('dados_consulta') ? ' is-invalid' : '' }}" id="dados_consulta" name="dados_consulta" rows="15" placeholder="Digite os dados da consulta aqui" required>{{ isset($prontuario->dados_consulta) ? $prontuario->dados_consulta : '' }}</textarea>
                                            @include('alerts.feedback', ['field' => 'dados_consulta'])
                                        </div>

                                        <input type="hidden" id="consulta_id" name="consulta_id" value="{{ $consulta->id }}">
                                    </form>
                                </div>
                            </div>
                            <div id="prescricoes" class="tab-pane {{ $aba == "prescricoes" ? "active" : "" }}">
                                <div class="col-md-12">
                                    <a id="adicionarMedicamento" rel="tooltip" title="Pedir medicamento" class="btn btn-default" data-target="#modal-form-prescricao" data-toggle="modal" href="#">
                                        Prescrever medicamento
                                    </a>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="4" class="text-center">
                                                        Medicamentos
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Nome
                                                    </th>
                                                    <th>
                                                        Posologia
                                                    </th>
                                                    <th>
                                                        Data
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(sizeof($listaPedidosMedicamentos) > 0)
                                                    @foreach($listaPedidosMedicamentos as $pedidoMedicamento)
                                                        <tr>
                                                            <td>
                                                                {{ $pedidoMedicamento->nome_comercial }}
                                                            </td>
                                                            <td>
                                                                {{ $pedidoMedicamento->prescricao_indicada }}
                                                            </td>
                                                            <td>
                                                                {{ date("d/m/Y", $pedidoMedicamento->created_at) }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('pedido_medicamento.delete', [$pedidoMedicamento->id,$consulta->id]) }}" rel="tooltip" title="Excluir" class="btn btn-link" data-original-title="Remove">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $listaPedidosMedicamentos->withPath(route('especialista.iniciarAtendimento', [$consulta->id, "prescricoes"]))->appends(request()->query()) }}
                                    </div>
                                </div>
                            </div>
                            <div id="exames" class="tab-pane {{ $aba == "exames" ? "active" : "" }}">
                                <div class="col-md-12">
                                    <a id="adicionarExame" rel="tooltip" title="Pedir Exame" class="btn btn-default" data-target="#modal-form-exame" data-toggle="modal" href="#">
                                        Pedir exame
                                    </a>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="4" class="text-center">
                                                        Exames
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        Nome
                                                    </th>
                                                    <th>
                                                        Data
                                                    </th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(sizeof($listaPedidosExames) > 0)
                                                    @foreach($listaPedidosExames as $pedidoexame)
                                                        <tr>
                                                            <td>
                                                                {{ $pedidoexame->nome }}
                                                            </td>
                                                            <td>
                                                                {{ date("d/m/Y", $pedidoexame->created_at) }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('pedido_exame.delete', [$pedidoexame->id,$consulta->id]) }}" rel="tooltip" title="Excluir" class="btn btn-link" data-original-title="Remove">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $listaPedidosExames->withPath(route('especialista.iniciarAtendimento', [$consulta->id, "exames"]))->appends(request()->query()) }}
                                    </div>
                                </div>
                            </div>
                            <div id="atestados" class="tab-pane {{ $aba == "atestados" ? "active" : "" }}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <form action="{{ route('atestado.store') }}" method="post">
                                            @csrf
                                            <label for="texto">
                                                Dados do atestado:
                                            </label>
                                            <textarea class="form-control" id="texto" name="texto" rows="15" placeholder="Digite os dados do atestado aqui..." required></textarea>
                                            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="consulta_id" id="consulta_id" value="{{ $consulta->id }}">
                                            <button id="salvarAtestado" type="submit" rel="tooltip" title="Salvar atestado" class="btn btn-default" data-original-title="Edit" @if ($atestado->count() > 0) disabled @endif>
                                                Salvar atestado
                                            </button>
                                            <a id="gerarAtestado" rel="tooltip" title="Gerar atestado" class="btn btn-default" data-original-title="Edit" href="{{ route('atestado.download', $consulta->id) }}">
                                                Gerar atestado
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="prontuario" class="tab-pane {{ $aba == "prontuario" ?  "active" : "" }}">
                                <div class="col-md-12">
                                    <a id="filtrarProntuario" rel="tooltip" title="Filtrar" class="btn btn-default" data-target="#modal-form-filtro-prontuario" data-toggle="modal" href="#">
                                        Filtrar
                                    </a>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                @if(sizeof($prontuarioCompleto) > 0)
                                                    @foreach($prontuarioCompleto as $prontuarioConsulta)
                                                        <tr>
                                                            <td>
                                                                Dia: {{ date("d/m/Y", strtotime($prontuarioConsulta->horario_finalizado)) }}
                                                                <div>
                                                                    Especialista: {{ $prontuarioConsulta->especialista }} - {{ $prontuarioConsulta->especialidade }}
                                                                </div>
                                                                <div>
                                                                    Prontuário: {{ $prontuarioConsulta->prontuario }}
                                                                </div>
                                                                <div>
                                                                    Medicamentos preescritos:
                                                                    <br>
                                                                    <p class="paragraph">
                                                                        @foreach ($prontuarioConsulta->pedido_medicamentos as $pedido_medicamento)
                                                                            {{ $pedido_medicamento->nome_comercial }} - {{ $pedido_medicamento->prescricao_indicada }}
                                                                            <br>
                                                                        @endforeach
                                                                    </p>
                                                                </div>
                                                                <div>
                                                                    Exames solicitados:
                                                                    <br>
                                                                    <p class="paragraph">
                                                                        @foreach ($prontuarioConsulta->pedido_exames as $pedido_exame)
                                                                            {{ $pedido_exame->nome }}
                                                                            <br>
                                                                        @endforeach
                                                                    </p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td>
                                                            Não há registros anteriores.
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $prontuarioCompleto->withPath(route('especialista.iniciarAtendimento', [$consulta->id, "prontuario"]))->appends(request()->query()) }}
                                    </div>
                                </div>
                            </div>
                            <div id="anamnese" class="tab-pane {{ $aba == "anamnese" ?  "active" : "" }}">
                                <div class="col-md-12">
                                    <a title="Relatório anamnese" class="btn btn-default" href="{{ route('relatorio.anamnese', ['id' => $consulta->paciente_id]) }}" target="_blank" rel="noopener noreferrer">
                                        Anamnese
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('consulta.listConsultaPorEspecialistaPesquisar') }}" class="btn btn-primary">
                        <i class="fa fa-reply"></i>
                        Voltar
                    </a>
                    <button name="finalizar" class="btn btn-primary"  onclick="saveProntuario('finaliza')">
                        Finalizar
                        <i class="fa fa-save"></i>
                    </button>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PRESCRIÇÃO DE MEDICAMENTO --}}
    @component('layouts.modal_form', ["title" => "Favor, selecionar o medicamento desejado", "route" => route('pedido_medicamento.store'), "textButton" => "Adicionar medicamento", "id" => "modal-form-prescricao"])
        <div class="form-group">
            <label for="medicamento_id">
                Selecionar medicamento:
            </label>
            <div class="input-group">
                <select class="select2" name="medicamento_id" id="medicamento_id" class="form-control" title="Por favor selecionar medicamento...">
                    <option></option>
                    @foreach($medicamentos as $medicamento)
                        <option value="{{ old('medicamento_id', $medicamento->id) }}">
                            {{ $medicamento->nome_comercial }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="posologia">
                Posologia
            </label>
            <div class="input-group">
                <input type="text" placeholder="Digite a posologia para o medicamento selecionado" name="posologia" id="posologia" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label>
                Não encontrou o medicamento?
                <a href="#" rel="tooltip" title="Adicionar novo exame" data-target="#modal-form-cadastro-medicamento" data-toggle="modal">
                    Click aqui para cadastrar.
                </a>
            </label>
            <input type="hidden" id="consulta_id" name="consulta_id" value="{{ $consulta->id }}">
        </div>
    @endcomponent

    {{-- MODAL CADASTRO DE MEDICAMENTO --}}
    @component('layouts.modal_form', ["title" => "Adicionar novo medicamento", "route" => route('especialista.salvaNovoMedicamento'), "textButton" => "Salvar", "id" => "modal-form-cadastro-medicamento"])
        <div class="form-group">
            <label for="nome_comercial">
                Nome Comercial
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="nome_comercial" name="nome_comercial" required>
            </div>
        </div>
        <div class="form-group">
            <label for="nome_generico">
                Nome Genérico
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="nome_generico" name="nome_generico" required>
            </div>
        </div>
        <div class="form-group">
            <label for="forma">
                Forma
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="forma" name="forma" required>
            </div>
        </div>
        <div class="form-group">
            <label for="concentracao">
                Concentração
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="concentracao" name="concentracao" required>
            </div>
        </div>
        <div class="form-group">
            <label for="via">
                Via
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="via" name="via" required>
            </div>
        </div>
        <div class="form-group">
            <label for="indicacao">
                Indicação
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="indicacao" name="indicacao" required>
            </div>
        </div>
        <div class="form-group">
            <label for="posologia">
                Posologia
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="posologia" name="posologia" required>
            </div>
        </div>
        <div class="form-group">
            <label for="precaucao">
                Precaução
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="precaucao" name="precaucao" required>
            </div>
        </div>
        <div class="form-group">
            <label for="advertencia">
                Advertência
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="advertencia" name="advertencia" required>
            </div>
        </div>
        <div class="form-group">
            <label for="contraindicacao">
                Contraindicação
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="contraindicacao" name="contraindicacao" required>
            </div>
        </div>
        <div class="form-group">
            <label for="composicao">
                Composição
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="composicao" name="composicao" required>
            </div>
        </div>
        <div class="form-group">
            <label for="latoratorio_fabricante">
                Latoratório Fabricante
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="latoratorio_fabricante" name="latoratorio_fabricante" required>
            </div>
        </div>
        <div class="form-group">
            <label for="tipo_medicamento_id">
                Tipo de Medicamento
            </label>
            <div class="input-group">
                <select name="tipo_medicamento_id" id="tipo_medicamento_id" class="form-control" title="Por favor selecionar ..." required>
                    @foreach($tipo_medicamentos as $iten)
                        <option value="{{ $iten->id }}">
                            {{ $iten->descricao }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" name="consulta_id" value="{{ $consulta->id }}">
    @endcomponent

    {{-- MODAL PEDIDO EXAMES --}}
    @component('layouts.modal_form', ["title" => "Favor, selecionar o exame desejado", "route" => route('pedido_exame.salveVarios'), "textButton" => "Adicionar exame", "id" => "modal-form-exame"])
        <div class="form-group">
            <label for="exame_id">
                Selecionar exame:
            </label>
            <div class="input-group">
                <select class="select2" name="exames[]" class="form-control" multiple="multiple" id="exame_id" title="Por favor selecionar o exame..." required>
                    @foreach($exames as $exame)
                        <option data-color="red" value="{{ old('exames', $exame->id) }}">
                            {{ $exame->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>
                Não encontrou o exame?
                <a href="#" rel="tooltip" title="Adicionar novo exame" data-target="#modal-form-cadastro-exame" data-toggle="modal">
                    Click aqui para cadastrar.
                </a>
            </label>
        </div>
        <input type="hidden" name="consulta_id" value="{{$consulta->id}}">
    @endcomponent

    {{-- MODAL PEDIDO EXAMES --}}
    @component('layouts.modal_form', ["title" => "Favor, selecionar o exame desejado", "route" => route('especialista.salvaNovoExame'), "textButton" => "Salvar", "id" => "modal-form-cadastro-exame"])
        <div class="form-group">
            <label id="nome">
                Nome
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
        </div>
        <div class="form-group">
            <label id="descricao">
                Descrição
            </label>
            <div class="input-group">
                <input type="text" class="form-control" id="descricao" name="descricao" required>
            </div>
        </div>
        <div class="form-group">
            <label id="tipoexame_id">
                Tipo
            </label>
            <div class="input-group">
                <select name="tipoexame_id" id="tipoexame_id" class="form-control" title="Por favor selecionar um tipo de exame ..." required>
                    @foreach($tipoexames as $tipoExame)
                        <option value="{{ old('tipoexame_id', $tipoExame->id) }}">
                            {{ $tipoExame->descricao }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" name="consulta_id" value="{{ $consulta->id }}">
    @endcomponent

    {{-- MODAL FILTRO PRONTUARIO COMPLETO --}}
    @component('layouts.modal_form', ["title" => "Favor, selecionar a especialidade para filtrar", "route" => route('prontuario_completo.filter'), "textButton" => "Filtrar", "id" => "modal-form-filtro-prontuario"])
        <div class="form-group">
            <label for="exame_id">
                Selecionar especialidade:
            </label>
            <div class="input-group">
                <select class="select2" name="especialidade_id" class="form-control" title="Por favor selecionar a especialidade..." required>
                    @foreach($especialidades as $especialidade)
                        <option data-color="red" value="{{ $especialidade->id }}">
                            {{ $especialidade->descricao }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <input type="hidden" name="consulta_id" value="{{ $consulta->id }}">
    @endcomponent

    <script>
        const chronometer = document.getElementById('chronometer');
        let startTime = Date.now();
        //aqui add startTime dentro da sessao
        let elapsedTime = 0;
        let timerInterval;

        let tempo = localStorage.getItem('tempo') ? parseInt(localStorage.getItem('tempo')) : 0;


        function updateChronometer() {
            tempo++;
            localStorage.setItem('tempo', tempo);
            const hours = String(Math.floor(tempo / 3600)).padStart(2, '0');
            const minutes = String(Math.floor((tempo % 3600) / 60)).padStart(2, '0');
            const seconds = String(tempo % 60).padStart(2, '0');

            const formattedHours = String(hours).padStart(2, '0');
            const formattedMinutes = String(minutes).padStart(2, '0');
            const formattedSeconds = String(seconds).padStart(2, '0');

            chronometer.textContent = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
        }

        function startTimer() {
            timerInterval = setInterval(updateChronometer, 1000);
        }

        startTimer();

       /* document.getElementById('btnFinalizar').onclick = () => {
            tempo = 0;

        };*/

        function  saveProntuario(finaliza){

            var produtarioAtual = document.getElementById("dados_consulta").value;
            if (produtarioAtual.trim()==""){
                alert("Os dados da consulta são obrigatórios")
                return;

            }
            const cosId = document.getElementById("consulta_id").value;


            $.ajax({
                url: '{{ route("prontuario.store") }}', // Usando a helper do Laravel para gerar a URL
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Token CSRF para segurança
                    dados_consulta: produtarioAtual,  // Dados que você quer enviar
                    consulta_id:  cosId      // Outros dados que podem ser úteis
                },
                success: function(response) {
                    if (finaliza){
                        window.location.href = '{{ route("especialista.finalizarAtendimento",$consulta->id) }}';
                        localStorage.removeItem('tempo'); // Remove o tempo do localStorage
                        document.getElementById('chronometer').innerText = '00:00:00';
                    }

                    console.log('Sucesso:', finaliza);
                    // Aqui você pode adicionar lógica para tratar a resposta
                },
                error: function(xhr, status, error) {
                    console.error('Erro:', error);
                    // Tratamento de erros
                }
            });

        }
        function openTab(event, tabId) {

           //alert(tabId);
            if (tabId!="prontuarioatual"){
                saveProntuario();
            }




           // alert(produtarioAtual);
            //alert('aqui'+tabId)
            // Hide all tab panes
            var tabPanes = document.querySelectorAll('.tab-pane');
            tabPanes.forEach(pane => {
                pane.classList.remove('active');
            });

            // Remove active class from all tab buttons
            var tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active');
            });

            // Show the clicked tab pane and add active class to the clicked tab button
            document.getElementById(tabId).classList.add('active');
            event.currentTarget.classList.add('active');
        }
    </script>
@endsection
