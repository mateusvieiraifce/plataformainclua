<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColunDebitoConsulta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->float('debito')->default(0)->nullable()->comment('debito');
            $table->boolean("reenbolsado")->nullable()->default(false)->comment('Reenbolsado');
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
