<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnamnesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anamneses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id')->unique();
            $table->string('gravidez_programada', 3)->nullable();
            $table->integer('idade_mae_geracao')->nullable();
            $table->integer('idade_pai_geracao')->nullable();
            $table->string('pre_natal', 3)->nullable();
            $table->string('posicao_ordem_gestacao')->nullable();
            $table->string('tentativa_aborto', 3)->nullable();
            $table->string('exposicao_raios', 3)->nullable();
            $table->string('fatos_ocorridos', 1000)->nullable();
            $table->string('local_parto')->nullable();
            $table->string('fez_parto')->nullable();
            $table->string('tipo_parto')->nullable();
            $table->string('parto_prematuro', 3)->nullable();
            $table->string('problemas_parto', 1000)->nullable();
            $table->string('crianca_bem_recebida', 3)->nullable();
            $table->string('amamentacao')->nullable();
            $table->string('comeu_pastoso_solido')->nullable();
            $table->string('tomou_todas_vacinas', 3)->nullable();
            $table->string('permanencia_tres_anos')->nullable();
            $table->integer('iniciou_sustentacao_cabeca')->nullable();
            $table->string('idade_sentou_so')->nullable();
            $table->string('idade_engatinhou')->nullable();
            $table->string('idade_andou')->nullable();
            $table->string('corre_naturalidade', 3)->nullable();
            $table->string('cai_facilidade', 3)->nullable();
            $table->string('anda_naturalidade', 3)->nullable();
            $table->string('dominancia_lateral')->nullable();
            $table->string('atividade_fisicas')->nullable();
            $table->string('comecou_falar')->nullable();
            $table->string('teve_gagueira', 3)->nullable();
            $table->string('dificuldade_fala', 3)->nullable();
            $table->string('problema_visao_audicao_fala', 3)->nullable();
            $table->string('fala_corretamente')->nullable();
            $table->string('gosta_conversar', 3)->nullable();
            $table->string('conta_historias', 3)->nullable();
            $table->string('conversa_adultos', 3)->nullable();
            $table->string('inventa_casos', 3)->nullable();
            $table->string('sabe_cantar')->nullable();
            $table->string('gosta_musicas', 3)->nullable();
            $table->string('doencas_contraidas')->nullable();
            $table->string('teve_febre_convulsao', 3)->nullable();
            $table->string('teve_queda_acidente', 3)->nullable();
            $table->string('fez_exame_neurologico', 3)->nullable();
            $table->string('toma_medicamento_controlado', 3)->nullable();
            $table->string('remedios_controlados')->nullable();
            $table->string('alergico', 3)->nullable();
            $table->string('apresenta_deficiencia_fisica')->nullable();
            $table->string('dificuldade_relacionar_deficiencia', 3)->nullable();
            $table->string('deficiencia_intelectual_familia', 3)->nullable();
            $table->string('aprendeu_usar_sanitario')->nullable();
            $table->string('teve_enurese_noturna', 3)->nullable();
            $table->string('teve_enurese_idade')->nullable();
            $table->string('atitude_pais_enurese')->nullable();
            $table->string('onde_dorme')->nullable();
            $table->string('com_quem_dorme')->nullable();
            $table->string('tipo_sono')->nullable();
            $table->string('conversa_dormindo', 3)->nullable();
            $table->string('range_dentes_dormindo', 3)->nullable();
            $table->string('quando_dorme')->nullable();
            $table->string('habitos_dormir')->nullable();
            $table->string('atitude_pais_habitos_dormir')->nullable();
            $table->string('adotado_legitimo')->nullable();
            $table->string('sabe_adocao', 3)->nullable();
            $table->string('aceita_adocao', 3)->nullable();
            $table->string('diz_deseja_ser_crescer', 3)->nullable();
            $table->string('desejo_familia_crianca')->nullable();
            $table->string('compreensao_familia_comportamento')->nullable();
            $table->string('bom_relacionamento_familia', 3)->nullable();
            $table->string('ciumes_irmaos')->nullable();
            $table->string('apresenta_agressividade', 3)->nullable();
            $table->string('irrita_facilmente', 3)->nullable();
            $table->string('obediente', 1000)->nullable();
            $table->string('faz_perguntas_dificeis', 3)->nullable();
            $table->string('busca_atencao', 3)->nullable();
            $table->string('presencia_violencia', 3)->nullable();
            $table->string('habitos_alimentares')->nullable();
            $table->string('hobby', 1000)->nullable();
            $table->string('participa_atividades')->nullable();
            $table->string('possui_amigos', 3)->nullable();
            $table->string('prefere_ficar_so', 3)->nullable();
            $table->string('com_quem_brinca')->nullable();
            $table->string('cuidadoso_desligado')->nullable();
            $table->string('brinquendo_preferido')->nullable();
            $table->timestamps();

            $table->foreign('paciente_id')->references('id')->on('pacientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anamneses', function (Blueprint $table) {
            $table->dropForeign('anamneses_paciente_id_foreign');
        });
        Schema::dropIfExists('anamneses');
    }
}
