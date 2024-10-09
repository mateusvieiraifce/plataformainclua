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
        Schema::create('avaliacoes_comentarios', function (Blueprint $table) {
            $table->id();
            $table->string('comentario', 200)->nullable();
            $table->string('motivo_denuncia')->nullable();
            $table->string('status')->nullable();
            $table->string('tipo_avaliado', 1);
            $table->unsignedBigInteger('avaliador_id');
            $table->foreign('avaliador_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
      
        });
        
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();
            $table->string('categoria', 15);
            $table->integer('nota');
            $table->unsignedBigInteger('consulta_id');
            $table->unsignedBigInteger('comentario_id');
            $table->foreign('comentario_id')->references('id')->on('avaliacoes_comentarios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('consulta_id')->references('id')->on('consultas')->onUpdate('cascade')->onDelete('cascade');
        });
        

     
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::table('avaliacoes_comentarios', function (Blueprint $table) {          
           $table->dropForeign('avaliacoes_avaliador_id_foreign');
        });
        Schema::table('avaliacoes', function (Blueprint $table) {
            $table->dropForeign('avaliacoes_comentarios_avaliacao_id_foreign');
            $table->dropForeign('avaliacoes_consulta_id_foreign');
           
        });*/
        Schema::dropIfExists('avaliacoes');

        Schema::dropIfExists('avaliacoes_comentarios');       

       
    }
}
