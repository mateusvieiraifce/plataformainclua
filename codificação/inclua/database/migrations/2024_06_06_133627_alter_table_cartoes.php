<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCartoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //REMOVER ANTIGOS CAMPOS
        Schema::table('cartoes', function (Blueprint $table) {
            $table->dropColumn('numero_cartao');
            $table->dropColumn('mes_validade');
            $table->dropColumn('ano_validade');
            $table->dropColumn('cvv');
            $table->dropColumn('nome_titular');
        });

        //ADICIONAR NOVOS CAMPOS
        Schema::table('cartoes', function (Blueprint $table) {
            $table->string('token', 256)->nullable(false)->after('user_id');
            $table->string('issuer_id', 256)->nullable(false)->after('token');
            $table->string('installments', 256)->nullable(false)->after('issuer_id');
            $table->string('payment_method_id', 256)->nullable(false)->after('installments');
            $table->string('email', 255)->nullable(false)->after('payment_method_id');
            $table->string('status', 255)->nullable(false)->after('email');
            $table->string('ultimo_digitos', 4)->nullable(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //REMOVER NOVOS CAMPOS
        Schema::table('cartoes', function (Blueprint $table) {
            $table->dropColumn('token');
            $table->dropColumn('issuer_id');
            $table->dropColumn('installments');
            $table->dropColumn('payment_method_id');
            $table->dropColumn('email');
            $table->dropColumn('status');
            $table->dropColumn('ultimo_digitos');
        });

        //ADICIONAR ANTIGOS CAMPOS
        Schema::table('cartoes', function (Blueprint $table) {
            $table->string('numero_cartao', 255)->nullable(false)->unique();
            $table->char('mes_validade', 2);
            $table->char('ano_validade', 4);
            $table->string('cvv', 255)->nullable(false);
            $table->string('nome_titular', 255)->nullable(false);
        });
    }
}
