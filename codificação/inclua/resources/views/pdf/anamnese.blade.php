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
            border: 20px rgb(137,119,249) solid;
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
<div class="text-center" style="margin-top: 12px">
<img src="https://app.plataformainclua.com/assets/img/logo-01.png"  width="170"/>
</div>    {{-- {{dd($anamnese)}} --}}
    <h1 class="text-center" >
        Anamnese
    </h1>
    <div class="margin-page">
        <table class="table-reset">
            <tr class="width-100">
                <td class="width-100">
                    <table class="table-reset">
                        <tr class="width-100">
                            <td class="width-800">
                                Nome: {{ $paciente->nome }}
                            </td>
                            <td class="width-40">
                                Nasc: {{ date('d/m/Y', strtotime($paciente->data_nascimento)) }}
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
                                Sexo: {{ $paciente->sexo }}
                            </td>
                            <td class="width-20">
                                CPF: {{ $paciente->cpf }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <div style="margin-top: 20px; padding: 20px;">

            </div>
            <h3 style="position: relative; top: -70px;">
                Histórico (antecedente e atual)
            </h3>
            <table class="table-reset" style="position: relative; top: -80px;">
                <tr class="width-70">
                    <td class="width-20">
                        <table class="table-reset">
                            <tr class="width-80">
                                <td class="width-40">

                                    Foi gravidez programada? {{ $anamnese->gravidez_programada }}<br><br>
                                    Qual a idade da mãe quando foi gerado(a)? {{ $anamnese->idade_mae_geracao}} anos<br><br>
                                    Qual a idade do pai quando foi gerado(a)? {{ $anamnese->idade_pai_geracao }} anos <br><br>
                                    Fez o pré natal? {{ $anamnese->pre_natal }}<br><br>
                                    Qual a posição da criança na ordem de gestação? {{ $anamnese->posicao_ordem_gestacao }}<br><br>
                                    Houve tentativa ou ameaça de aborto? {{ $anamnese->tentativa_aborto}}<br><br>
                                    Houve exposição a raios X ou semelhantes? {{ $anamnese->exposicao_raios}}<br><br>
                                    Fatos ocorridos durante a gestação (hemorragias, acidentes, condições de alimentação,
                                    condições emocionais, vícios, tomou algum medicamento sem orientação médica, etc) {{ $anamnese->fatos_ocorridos}}
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="width-100">
                    <td class="width-40">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-40">
                                 <hr>
                                    <h3 class="width-30"> Período perinatal (parto)</h3>
                                    O parto foi realizado? {{ $anamnese->fez_parto }}<br><br>
                                    O parto foi? {{ $anamnese->tipo_parto}} <br><br>
                                    O parto foi prematuro? {{ $anamnese->parto_prematuro }}  <br><br>
                                    Houve problemas na hora do parto? Qual?{{ $anamnese->problemas_parto }}<br><br>
                                    A criança foi bem recebida por todos? {{ $anamnese->crianca_bem_recebida }}

                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>


                <tr class="width-100">
                    <td class="width-40">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-40">
                                    <hr>
                                    <h3>Evolução da infância</h3>
                                    A criança foi amamentada? Por quanto tempo? {{ $anamnese->amamentacao }}<br><br>
                                    Quando começou a comer pastoso? E sólido? {{ $anamnese->comeu_pastoso_solido}} <br><br>
                                    A criança tomou todas as vacinas necessárias? {{ $anamnese->tomou_todas_vacinas }}  <br><br>
                                    Nos três primeiros anos de vida, permaneceu mais tempo em casa com quem?{{ $anamnese->permanencia_tres_anos }}<br><br>
                                </td>

                            </tr>
                        </table>
                    </td>

                <tr class="width-100">
                    <td class="width-40">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-40">
                                    <hr>
                                    <BR><br>
                                    <h3>Desenvolvimento Psicomotor (estimativa)</h3>
                                    Com quantos meses começou a sustentação da cabeça? {{ $anamnese->iniciou_sustentacao_cabeca }}<br><br>
                                    Com que idade sentou-se sozinho(a)? {{ $anamnese->idade_sentou_so}} <br><br>
                                    Com que idade engatinhou?{{ $anamnese->idade_engatinhou }}  <br><br>
                                    Com que idade andou?{{ $anamnese->idade_andou }}<br><br>
                                    Corre com naturalidade? {{ $anamnese->corre_naturalidade }}<br><br>
                                    Cai com facilidade?{{ $anamnese->cai_facilidade }}<br><br>
                                    Anda com naturalidade ou é desastrado (atropela as pessoas)? {{ $anamnese->anda_naturalidade }}<br><br>
                                    Qual sua dominância lateral? {{ $anamnese->dominancia_lateral }}<br><br>
                                    Quais as atividades físicas que costuma fazer?{{ $anamnese->atividade_fisicas }}

                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="width-100">
                    <td class="width-40">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-40">
                                    <hr>
                                    <h3>Desenvolvimento da linguagem (estimativa)</h3>
                                    Quando começou a falar? {{ $anamnese->comecou_falar }}<br><br>
                                    Teve gagueira quando pequeno?{{ $anamnese->teve_gagueira}} <br><br>
                                    Trocava, omitia, distorcia os fonemas (dislalia) ao falar?{{ $anamnese->dificuldade_fala }}  <br><br>
                                    A criança apresentou algum problema de visão, audição ou de fala?{{ $anamnese->problema_visao_audicao_fala }}<br><br>
                                    Atualmente, fala corretamente? Se não, em que apresenta dificuldade?{{ $anamnese->fala_corretamente }}<br><br>
                                    Gosta de conversar?{{ $anamnese->gosta_conversar }}<br><br>
                                    Sabe contar histórias? {{ $anamnese->conta_historias }}<br><br>
                                    Conversa com os adultos? {{ $anamnese->conversa_adultos }}<br><br>
                                    Gosta de inventar casos?{{ $anamnese->inventa_casos }}<br><br>
                                    Sabe cantar? Que tipo de músicas?{{ $anamnese->sabe_cantar }}<br><br>
                                    Gosta de ouvir músicas?{{ $anamnese->gosta_musicas }}<hr>
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="width-100">
                    <td class="width-40">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-40">
                                    <hr><br><br>
                                    <h3>História clínica</h3>
                                    Quais as doenças que já teve? {{ $anamnese->doencas_contraidas }}<br><br>
                                    Teve febre alta ou convulsões, quando pequeno?{{ $anamnese->teve_febre_convulsao}} <br><br>
                                    Teve queda ou acidente grave?{{ $anamnese->teve_queda_acidente }}  <br><br>
                                    Fez algum exame neurológico?{{ $anamnese->fez_exame_neurologico }}<br><br>
                                    Toma medicamento controlado?{{ $anamnese->toma_medicamento_controlado }}<br><br>
                                    Se sim, informe o(s) medicamento(s) controlado(s):?{{ $anamnese->remedios_controlados }}<br><br>
                                    É alérgico? {{ $anamnese->alergico }}<br><br>
                                    Tem alguma dificuldade física? {{ $anamnese->apresenta_deficiencia_fisica }}<br><br>
                                    Tem dificuldade em lidar com essa deficiência?{{ $anamnese->dificuldade_relacionar_deficiencia }}<br><br>
                                    Possui casos de deficiência intelectual na família?{{ $anamnese->deficiencia_intelectual_familia }}
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="width-100">
                    <td class="width-40">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-40">
                                    <hr>
                                    <h3>Enurese, encoprese e sono (estimativa)</h3>
                                    Quando aprendeu a usar o sanitário? {{ $anamnese->aprendeu_usar_sanitario }}<br><br>
                                    Teve enurese noturna?{{ $anamnese->teve_enurese_noturna}} <br><br>
                                    Se sim, até que idade?{{ $anamnese->teve_enurese_idade }}  <br><br>
                                    Qual a atitude dos pais?{{ $anamnese->atitude_pais_enurese }}<br><br>
                                    Onde dorme?{{ $anamnese->onde_dorme }}<br><br>
                                    Com quem?{{ $anamnese->com_quem_dorme }}<br><br>
                                    Tem sono tranquilo ou agitado? {{ $anamnese->tipo_sono }}<br><br>
                                    Conversa dormindo? {{ $anamnese->conversa_dormindo }}<br><br>
                                    Range os dentes dormindo?{{ $anamnese->range_dentes_dormindo }}<br><br>
                                    Dorme cedo ou tarde da noite?{{ $anamnese->quando_dorme }}<br><br>
                                    Chupa dedo, chupeta ou possui outro hábito?{{ $anamnese->habitos_dormir }}<br><br>
                                    Qual a atitude dos pais?{{ $anamnese->atitude_pais_habitos_dormir }}
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="width-100">
                    <td class="width-40">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-40">
                                    <hr>
                                    <br><br>
                                    <h3>Relacionamento familiar</h3>
                                    É adotado ou legítimo? {{ $anamnese->adotado_legitimo }}<br><br>
                                    Se for adotado, conhece esta condição?{{ $anamnese->sabe_adocao}} <br><br>
                                    Aceita que é adotado?{{ $anamnese->aceita_adocao }}  <br><br>
                                    Diz o que quer ser quando crescer?{{ $anamnese->diz_deseja_ser_crescer }}<br><br>
                                    O que a família quer que ele seja?{{ $anamnese->desejo_familia_crianca }}<br><br>
                                    Como a família se sente com relação ao comportamento da criança?{{ $anamnese->compreensao_familia_comportamento }}<br><br>
                                    O aprendente se dá bem com todos da família? {{ $anamnese->bom_relacionamento_familia }}<br><br>
                                    Se possui irmãos, demonstra ciúmes de algum deles? {{ $anamnese->ciumes_irmaos }}<br><br>
                                    Apresenta agressividade?{{ $anamnese->apresenta_agressividade }}<br><br>
                                    Irrita-se facilmente?{{ $anamnese->irrita_facilmente }}<br><br>
                                    É obediente?{{ $anamnese->obediente }}<br><br>
                                    Faz perguntas difíceis de responder?{{ $anamnese->faz_perguntas_dificeis }}<br><br>
                                    Procura chamar atenção para si?{{ $anamnese->busca_atencao }}<br><br>
                                    Presenciou ou presencia atos de violência na família?{{ $anamnese->presencia_violencia }}<br><br>
                                    Como são seus hábitos alimentares?{{ $anamnese->habitos_alimentares }}
                                </td>

                            </tr>
                        </table>
                    </td>
                </tr>

                <tr class="width-100">
                    <td class="width-40">
                        <table class="table-reset">
                            <tr class="width-100">
                                <td class="width-40">
                                    <hr>

                                    <h3>Relacionamento social</h3>
                                    O que mais gosta de fazer (Hobby)? {{ $anamnese->hobby }}<br><br>
                                    Participa de atividades:{{ $anamnese->participa_atividades}} <br><br>
                                    Possui amigos?{{ $anamnese->possui_amigos }}  <br><br>
                                    Prefere ficar mais sozinho(a)?{{ $anamnese->prefere_ficar_so }}<br><br>
                                    Com quem gosta mais de brincar?{{ $anamnese->com_quem_brinca }}<br><br>
                                    É cuidadoso(a) ou "desligado"(a)?{{ $anamnese->cuidadoso_desligado }}<br><br>
                                    Qual o brinquedo que mais gosta? {{ $anamnese->brinquendo_preferido }}

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
