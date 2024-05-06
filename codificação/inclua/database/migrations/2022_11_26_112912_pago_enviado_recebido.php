<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PagoEnviadoRecebido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens_vendas', function (Blueprint $table) {
            $table->timestamp('data_pago')->nullable();
            $table->timestamp('data_envio')->nullable();
            $table->timestamp('data_recebimento')->nullable();
            $table->unsignedBigInteger('tamanho')->nullable();
        });

        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itens_vendas', function (Blueprint $table) {
            $table->dropColumn('data_pago');
            $table->dropColumn('data_envio');
            $table->dropColumn('data_recebimento');
            $table->dropColumn('tamanho');
        });
    }
}
