<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPedidoExames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedido_exames', function (Blueprint $table) {
            $table->string('exame_efetuado', 3)->nullable()->after('laudo');
            $table->string('local_arquivo_exame')->nullable()->after('exame_efetuado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedido_exames', function (Blueprint $table) {
            $table->dropColumn("local_arquivo_exame");
            $table->dropColumn("exame_efetuado");
        });
    }
}
