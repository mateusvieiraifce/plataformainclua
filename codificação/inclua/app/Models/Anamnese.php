<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anamnese extends Model
{
    use HasFactory;
    protected $fillables = [
        'paciente_id',
        'gravidez_programada',
        'idade_mae_geracao',
        'idade_pai_geracao',
        'pre_natal',
        'posicao_ordem_gestacao',
        'tentativa_aborto',
        'exposicao_raios',
        'fatos_ocorridos',
        'local_parto',
        'fez_parto',
        'tipo_parto',
        'parto_prematuro',
        'problemas_parto',
        'crianca_bem_recebida',
        'amamentacao',
        'comeu_pastoso_solido',
        'tomou_todas_vacinas',
        'permanencia_tres_anos',
        'iniciou_sustentacao_cabeca',
        'idade_sentou_so',
        'idade_engatinhou',
        'idade_andou',
        'corre_naturalidade',
        'cai_facilidade',
        'anda_naturalidade',
        'dominancia_lateral',
        'atividade_fisicas',
        'comecou_falar',
        'teve_gagueira',
        'dificuldade_fala',
        'problema_visao_audicao_fala',
        'fala_corretamente',
        'gosta_conversar',
        'conta_historias',
        'conversa_adultos',
        'inventa_casos',
        'sabe_cantar',
        'gosta_musicas',
        'doencas_contraidas',
        'teve_febre_convulsao',
        'teve_queda_acidente',
        'fez_exame_neurologico',
        'toma_medicamento_controlado',
        'remedios_controlados',
        'alergico',
        'apresenta_deficiencia_fisica',
        'dificuldade_relacionar_deficiencia',
        'deficiencia_intelectual_familia',
        'aprendeu_usar_sanitario',
        'teve_enurese_noturna',
        'teve_enurese_idade',
        'atitude_pais_enurese',
        'onde_dorme',
        'com_quem_dorme',
        'tipo_sono',
        'conversa_dormindo',
        'range_dentes_dormindo',
        'quando_dorme',
        'habitos_dormir',
        'atitude_pais_habitos_dormir',
        'adotado_legitimo',
        'sabe_adocao',
        'aceita_adocao',
        'diz_deseja_ser_crescer',
        'desejo_familia_crianca',
        'compreensao_familia_comportamento',
        'bom_relacionamento_familia',
        'ciumes_irmaos',
        'apresenta_agressividade',
        'irrita_facilmente',
        'obediente',
        'faz_perguntas_dificeis',
        'busca_atencao',
        'presencia_violencia',
        'habitos_alimentares',
        'hobby',
        'participa_atividades',
        'possui_amigos',
        'prefere_ficar_so',
        'com_quem_brinca',
        'cuidadoso_desligado',
        'brinquendo_preferido',
    ];
}
