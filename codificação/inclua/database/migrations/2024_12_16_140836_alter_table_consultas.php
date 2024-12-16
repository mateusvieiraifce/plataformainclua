<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableConsultas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultas', function(Blueprint $table) {
            $table->unsignedBigInteger('pagamento_id')->unsigned()->nullable()->after('forma_pagamento');

            $table->foreign('pagamento_id')->references('id')->on('pagamentos')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultas', function(Blueprint $table) {
            $table->dropForeign('consultas_pagamento_id_foreign');
            $table->dropColumn('pagamento_id');
        });
    }
}
