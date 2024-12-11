@extends('layouts.app', ['page' => __('Fila'), 'exibirPesquisa' => false, 'pageSlug' => 'fila', 'class' => 'fila'])
@section('title', 'Fila')
@section('content')

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            max-width: 1000px;
            margin: auto;
            display: flex;
            justify-content: space-between;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border: 1px solid #ddd;
            table-layout: fixed;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr {
            cursor: move;
        }

        tr.dragging {
            opacity: 0.5;
        }

        tr:nth-child(odd) {
            background-color: #BDA0E3;
            /* Cor para linhas ímpares */
        }

        tr:nth-child(even) {
            background-color: #ffffff;
            /* Cor para linhas pares */
        }
    </style>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card card-tasks" style="height: auto; min-height: 500px;">
                <div class="card-header">
                    <h6 class="title d-inline">Filas</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('fila.salvarOrdemFilasUserEspecialista')}}">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-6">
                                    <table id="table1">
                                        <thead>
                                            <tr>
                                                <th colspan="4">Fila Normal</th>
                                            </tr>
                                            <tr>
                                                <th>Ordem</th>
                                                <th>Nome</th>
                                                <th colspan="2">Entrou na fila</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(sizeof($listaTipoNormal) > 0)
                                                @php
                                                $cont=1;
                                                @endphp
                                                @foreach($listaTipoNormal as $ent)
                                                    <tr draggable="true">
                                                        <td class="row-number">
                                                            {{$cont}}
                                                        </td>
                                                        @php
                                                            $cont = $cont + 1;
                                                        @endphp
                                                        <td>
                                                            <input type="hidden" name="listaNormal[]" value="{{$ent->id}}">
                                                            {{$ent->nome}}
                                                        </td>
                                                        <td>
                                                            {{date('H:i', strtotime($ent->hora_entrou))}}
                                                        </td>
                                                        <td style=" white-space: nowrap;">
                                                            <a rel="tooltip" title="Iniciar atendimento" class="btn btn-primary" data-original-title="Edit" href="{{route('especialista.iniciarAtendimento', [$ent->id,"prontuarioatual"])}}">
                                                                Iniciar atendimento
                                                            </a>
                                                        </td> 
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <table id="table2">
                                        <thead>
                                            <tr>
                                                <th colspan="4">Fila Prioritário</th>
                                            </tr>
                                            <tr>
                                                <th>Ordem</th>
                                                <th>Nome</th>
                                                <th colspan="2">Entrou na fila</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(sizeof($listaTipoPrioritario) > 0)
                                                @php
                                                $cont=1;
                                                @endphp
                                                @foreach($listaTipoPrioritario as $ent)
                                                    <tr draggable="true">
                                                        <td class="row-number">
                                                            {{ $cont }}
                                                        </td>
                                                        @php
                                                            $cont = $cont + 1;
                                                        @endphp
                                                        <td>
                                                            <input type="hidden" name="listaPrioritario[]" value="{{$ent->id}}">
                                                            {{ $ent->nome }}
                                                        </td>
                                                        <td>
                                                            {{ date('H:i', strtotime($ent->hora_entrou)) }}
                                                        </td>
                                                        <td style=" white-space: nowrap;">
                                                            <a href="#" rel="tooltip" title="Iniciar atendimento" class="btn-primary" data-original-title="Edit" data-target="#modal-form" data-toggle="modal" onclick="setModal('{{ route('especialista.iniciarAtendimento', [$ent->consulta_id, 'prontuarioatual']) }}')">
                                                                Iniciar atendimento
                                                            </a>
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
                    <div class="row">
                        <div class="col-4">
                            <a href="{{route('fila.listClinicaDoEspecialista')}}" class="btn btn-primary">
                                <i class="fa fa-reply"></i> Voltar
                            </a>
                            <button class="btn btn-success" onclick="$('#send').click();" style="margin-right: 5px;margin-left: 5px;">
                                Salvar ordem
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <script>
        let draggingRow = null;

        // Função para iniciar o arrasto
        function handleDragStart(event) {
            draggingRow = event.target.closest('tr');
            draggingRow.classList.add('dragging');
        }

        // Função para finalizar o arrasto
        function handleDragEnd(event) {
            draggingRow.classList.remove('dragging');
            draggingRow = null;
        }

        // Função para arrastar linhas dentro da mesma tabela
        function handleDragOver(event) {
            event.preventDefault();
            const target = event.target.closest('tr');
            if (target && target !== draggingRow && target.parentNode === draggingRow.parentNode) {
                const rect = target.getBoundingClientRect();
                const offsetY = event.clientY - rect.top;
                const middle = rect.height / 2;

                if (offsetY < middle) {
                    target.parentNode.insertBefore(draggingRow, target);
                } else {
                    target.parentNode.insertBefore(draggingRow, target.nextSibling);
                }
            }
            updateRowNumbers(target.parentNode);         
        }

        // Função para mover linhas entre tabelas
        function handleDrop(event) {
            event.preventDefault();
            if (draggingRow) {            
                const targetTable = event.target.closest('table');   
                const originalTable = draggingRow.closest('table'); // Tabela original
                    
                if (targetTable && targetTable !== draggingRow.parentNode.parentNode) {
                    const targetBody = targetTable.querySelector('tbody');
                    targetBody.appendChild(draggingRow);
                    draggingRow.classList.remove('dragging');
                    // Altera o nome dos inputs na linha arrastada
                    const inputs = draggingRow.querySelectorAll('input');
                    inputs.forEach((input, index) => {
                        if (input.name == 'listaPrioritario[]') {
                            input.name = `listaNormal[]`;
                        } else {
                            input.name = `listaPrioritario[]`;
                        }
                    });

                    updateRowNumbers(targetBody); // Atualiza números na tabela de destino    
                    updateRowNumbers(originalTable.querySelector('tbody'));          
                    draggingRow = null;
                }
            }
        }

        // Função para atualizar os números das linhas
        function updateRowNumbers(tbody) { 
            const rows = tbody.querySelectorAll('tr');
            rows.forEach((row, index) => {
                const cell = row.querySelector('.row-number'); 
                if (cell) {
                    cell.textContent = index + 1; // Atualiza o número da linha
                }
            });
        }

        // Adiciona os eventos às tabelas
        const tables = document.querySelectorAll('table');

        tables.forEach(table => {
            table.addEventListener('dragstart', handleDragStart);
            table.addEventListener('dragend', handleDragEnd);
            table.addEventListener('dragover', handleDragOver);
            table.addEventListener('drop', handleDrop);
        });
    </script>
@endsection