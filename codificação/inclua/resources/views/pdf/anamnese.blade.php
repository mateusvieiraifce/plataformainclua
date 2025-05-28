<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anamnese</title>
    <style>
        @page {
            width: 100%;
            margin: 0;
        }

        body {
            box-sizing: border-box;
            border: 25px rgb(137,119,249) solid;
        }
        
        .margin-page {
            margin-left: 20px;
            margin-right: 20px;
        }

        .table-reset {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
            border: none;
            background-color: transparent;
            font-size: inherit;
            font-family: inherit;
            line-height: inherit;
        }
        
        .width-100 {
            width: 100%;
        }

        .width-90 {
            width: 90%;
        }

        .width-80 {
            width: 80%;
        }

        .width-70 {
            width: 70%;
        }

        .width-65 {
            width: 65%;
        }

        .width-60 {
            width: 60%;
        }

        .width-40 {
            width: 40%;
        }

        .width-35 {
            width: 35%;
        }

        .width-30 {
            width: 30%;
        }

        .width-20 {
            width: 20%;
        }
        
        .border-avaliacao {
            border: 1px rgb(137,119,249) solid;
        }

        thead tr th {
            text-transform: uppercase;
            font-weight: 700;
        }

        tbody tr th {
            
        }

        .text-center {
            text-align: center;
        }
        
    </style>
</head>
<body>
    {{-- {{dd($anamnese)}} --}}
    <h1 class="text-center">
        ANAMNESE
    </h1>
    <div class="margin-page">
        <table class="table-reset">
            <tr class="width-100">
                <td class="width-100">
                    <table class="table-reset">
                        <tr class="width-100">
                            <td class="width-80">
                                Nome: {{ $paciente->nome }}
                            </td>
                            <td class="width-20">
                                Nasc.: {{ date('d/m/Y', strtotime($paciente->data_nascimento)) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="width-100">
                <td class="width-100">
                    <table class="table-reset">
                        <tr class="width-100">
                            <td class="width-30">
                                CPF: {{ $paciente->cpf }}
                            </td>
                            <td class="width-30">
                                Sexo: {{ $paciente->sexo }}
                            </td>
                            <td class="width-30">
                                CPF: {{ $paciente->cpf }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        
        <div class="border-avaliacao" style="margin-top: 20px; padding: 8px;">
            <div class="text-center" style="background-color: white; position: relative; top: -46px; left: 20px; width: 150px;">
                <h2 style="color: rgb(137,119,249);">Questionário</h2>
            </div>
            <h3 style="position: relative; top: -60px;">
                Histórico (antecedente e atual)
            </h3>
            <table class="table-reset" style="position: relative; top: -60px;">
                <tr class="width-100">
                    <td class="width-40">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-40">
                                    Foi gravidez programada? {{ $anamnese->gravidez_programada }}
                                </td>
                                <td class="width-60">
                                    Qual a idade da mãe quando foi gerado(a)? {{ $anamnese->idade_mae_geracao }} anos
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="width-100">
                    <td class="width-100">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-60">
                                    Qual a idade do pai quando foi gerado(a)? {{ $anamnese->idade_pai_geracao }} anos
                                </td>
                                <td class="width-40">
                                    Fez o pré natal? {{ $anamnese->pre_natal }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>