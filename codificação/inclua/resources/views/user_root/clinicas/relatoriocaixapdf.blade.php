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
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #f4f4f4;
            border-bottom: 2px solid #ccc;
        }

        .logo {
            width: 150px;
            margin-left: 17rem;
            height: auto;
        }

        .info {
            text-align: right;
        }

        .info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .title {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .content p {
            font-size: 14px;
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
        <div class="info">

            <p><strong>Total das consultas:</strong>R$ {{ number_format($preco_f, 2, ',', '.') }}</p>
            <p><strong>Número de consultas:</strong>{{ $num_f }}</p>
            
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
    </div>

    <div class="title">
        <p>Relatório de Caixa</p>
    </div>

    <div class="content">
        <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Paciente</th>
                <th>Forma de pagamento</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultas as $consulta)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($consulta->horario_agendado)->format('d/m/Y H:i') }}</td>
                    <td>{{ $consulta->paciente->nome }}</td>
                    <td>{{ $consulta->forma_pagamento }}</td>
                    <td>R$ {{ number_format($consulta->preco, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>

</body>
</html>
