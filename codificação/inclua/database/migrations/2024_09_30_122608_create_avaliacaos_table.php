<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->string('categoria', 15);
            $table->integer('nota');
            $table->unsignedBigInteger('avaliador_id');
            $table->unsignedBigInteger('consulta_id');
            $table->string('tipo_avaliado', 1);

            $table->foreign('consulta_id')->references('id')->on('consultas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('avaliador_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
        

        Schema::create('avaliacoes_comentarios', function (Blueprint $table) {
            $table->id();
            $table->string('comentario', 200);
            $table->unsignedBigInteger('avaliacao_id');

            $table->foreign('avaliacao_id')->references('id')->on('avaliacoes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('avaliacoes_comentarios', function (Blueprint $table) {
            $table->dropForeign('avaliacoes_comentarios_avaliacao_id_foreign');
        });

        Schema::dropIfExists('avaliacoes_comentarios');

        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->dropForeign('avaliacoes_consulta_id_foreign');
            $table->dropForeign('avaliacoes_avaliador_id_foreign');
        });

        Schema::dropIfExists('avaliacoes');
    }
}
