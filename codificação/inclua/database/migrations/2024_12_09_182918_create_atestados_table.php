<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtestadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atestados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('consulta_id')->unsigned();
            $table->string('texto');
            $table->date('data');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            $table->foreign('consulta_id')
                  ->references('id')
                  ->on('consultas')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {    
        Schema::table('atestados', function(Blueprint $table){
            //remover a fk
            $table->dropForeign('atestados_user_id_foreign'); //[table]_[coluna]_foreign
            //remover a coluna unidade_id
            $table->dropColumn('user_id');

            //remover a fk
            $table->dropForeign('atestados_consulta_id_foreign');
            // remover a coluna unidade_id
            $table->dropCOlumn('consulta_id');
        });

        Schema::dropIfExists('atestados');
    }
}
