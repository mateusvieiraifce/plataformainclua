<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Caixa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f4f4f4;
            border-bottom: 2px solid #ccc;
        }

        .logo {
            width: 150px;
            height: auto;
            margin-left: 17rem;
        }

        .info-1,
        .info-2 {
            padding: 0 10px;
        }

        .info-1 {
            position: absolute;
            top: 100px;
            left: 0;
            width: 100%;
        }

        .info-1 {
            text-align: left;
        }

        .info-2 {
            text-align: right;
        }

        .info-1 p {
            margin: 5px 0;
            font-size: 14px;
        }

        .info-2 {
            text-align: right;
            width: auto;
        }


        .title {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .content p {
            font-size: 8px;
            line-height: 1.5;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 3px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ $logo }}" class="logo" alt="Logo">

        <!-- Informações à esquerda -->
        <div class="info-1">
            <p><strong>Total Bruto das consultas:</strong> R$ {{ number_format($preco_f, 2, ',', '.') }}</p>
            <p><strong>Descontos:</strong> R$ {{ number_format($descontos, 2, ',', '.') }}</p>
            <p><strong>Total Líquido das  consultas:</strong> R$ {{ number_format($total_liquido, 2, ',', '.') }}</p>
            <p><strong>Número de consultas:</strong> {{ $num_f }}</p>
            <p><strong>Especialista:</strong>
                @if($especialista !== 'Sem filtro' && $especialista)
                    {{ $especialista->nome }}
                @else
                    {{$especialista}}
                @endif
            </p>
            <p><strong>Clínica:</strong>
                @if($clinica !== 'Sem filtro' && $clinica)
                    {{ $clinica->nome }}
                @else
                    {{ $clinica }}
                @endif
            </p>
            <p><strong>Período:</strong>
                @if($data_inicio !== 'Sem filtro' && $data_inicio)
                    {{ \Carbon\Carbon::parse($data_inicio)->format('d/m/Y') }}
                @else
                    Sem filtro
                @endif
                a
                @if($data_fim !== 'Sem filtro' && $data_fim)
                    {{ \Carbon\Carbon::parse($data_fim)->format('d/m/Y') }}
                @else
                    Sem filtro
                @endif
            </p>
        </div>

        <!-- Informações à direita -->
        <div class="info-2">
            <!-- Total no PIX -->
            <p><strong>Total no PIX:</strong>
                @if($preco_fpix !== 'Sem renda na modalidade' && $preco_fpix !== 'Sem filtro' && $preco_fpix > 0)
                    R$ {{ number_format($preco_fpix, 2, ',', '.') }}
                @else
                    {{$preco_fpix}}
                @endif
            </p>

            <!-- Total no Dinheiro -->
            <p><strong>Total no Dinheiro:</strong>
                @if($preco_fd !== 'Sem renda na modalidade' && $preco_fd !== 'Sem filtro' && $preco_fd > 0)
                    R$ {{ number_format($preco_fd, 2, ',', '.') }}
                @else
                    {{$preco_fd}}
                @endif
            </p>

            <!-- Total no Cartão -->
            <p><strong>Total no Cartão:</strong>
                @if($preco_fcdc !== 'Sem renda na modalidade' && $preco_fcdc !== 'Sem filtro' && $preco_fcdc > 0)
                    R$ {{ number_format($preco_fcdc, 2, ',', '.') }}
                @else
                    R$ {{ number_format($preco_fcdc, 2, ',', '.') }}
                @endif
            </p>

            <p><strong>Total Inclua:</strong>
                @if($preco_inclua !== 'Sem renda na modalidade' && $preco_inclua!== 'Sem filtro' && $preco_inclua > 0)
                    R$ {{ number_format($preco_inclua, 2, ',', '.') }}
                @else
                    R$ {{ number_format($preco_inclua, 2, ',', '.') }}
                @endif
            </p>
        </div>

    </div>


    <div class="title">
        <p>Relatório de Caixa</p>
    </div>

    <div class="content">
        <table style="font-size: 8pt">
        <thead>
            <tr>
                <th>Data</th>
                <th>Paciente</th>
                <th>Forma de pagamento</th>
                <th>Valor</th>
                <th>Descontos</th>
                <th>Liquido</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultas as $consulta)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($consulta->horario_agendado)->format('d/m/Y H:i') }}</td>
                    <td>{{ $consulta->paciente ? $consulta->paciente->nome : 'Paciente não encontrado' }}</td>
                    <td>{{ $consulta->forma_pagamento=="Cartão"?"Cartão Inclua": $consulta->forma_pagamento}}</td>

                    <td>R$  {{

                     number_format($consulta->preco, 2, ',', '.') }}</td>

                    <td>R$ {{ number_format($consulta->valor_desconto, 2, ',', '.') }}</td>

                    <td>R$ {{ number_format($consulta->valor_final, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</body>
</html>
