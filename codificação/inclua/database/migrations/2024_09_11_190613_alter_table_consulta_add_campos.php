<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableConsultaAddCampos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->boolean('isPago')->after('preco')->nullable();
            $table->string('forma_pagamento')->after('isPago')->nullable();
            $table->integer('id_usuario_cancelou')->after('motivocancelamento')->nullable();
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
            $table->dropColumn('isPago');
            $table->dropColumn('forma_pagamento');
            $table->dropColumn('id_usuario_cancelou');
        });
    }
}
