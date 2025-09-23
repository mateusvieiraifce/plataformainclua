<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableConsultasAddRembolsoSaldo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->float('debito')->nullable()->comment('nao comparecimento');
            $table->string('reenbolsado', 10)->nullable()->comment('informar se uma consulta precisa de reembolso ou se ja foi reembolsada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn('debito');
            $table->dropColumn('reenbolsado');
        });
    }
}
