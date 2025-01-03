<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssinaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cartao_id')->unsigned();
            $table->date('data_renovacao');
            $table->string('status', 255);
            $table->string('assinante', 255);
            $table->string('mes_referencia', 4);
            $table->string('transaction_code', 256);
            $table->string('motivo', 256)->nullable();
            $table->string('situacao', 256)->nullable();

            $table->foreign('cartao_id')->references('id')->on('cartoes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assinaturas', function(Blueprint $table){
            //remover a fk
            $table->dropForeign('assinaturas_cartao_id_foreign'); //[table]_[coluna]_foreign
            //remover a coluna unidade_id
            $table->dropColumn('cartao_id');
        });

        Schema::dropIfExists('assinaturas');
    }
}
