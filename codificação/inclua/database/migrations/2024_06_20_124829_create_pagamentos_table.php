<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedBigInteger('cartao_id')->unsigned()->nullable();
            $table->unsignedBigInteger('assinatura_id')->unsigned()->nullable();
            $table->date('data_pagamento');
            $table->double('valor', 8, 2);
            
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cartao_id')->references('id')->on('cartoes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('assinatura_id')->references('id')->on('assinaturas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagamentos', function(Blueprint $table){
            $table->dropForeign('pagamentos_user_id_foreign');
            $table->dropColumn('user_id');
            $table->dropForeign('pagamentos_cartao_id_foreign');
            $table->dropColumn('cartao_id');
            $table->dropForeign('pagamentos_assinatura_id_foreign');
            $table->dropColumn('assinatura_id');
        });

        Schema::dropIfExists('pagamentos');
    }
}
