<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEspecialistaClinicasAddisVinculado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('especialistaclinicas', function (Blueprint $table) {
            $table->boolean('is_vinculado')->after('local_consulta')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('especialistaclinicas', function (Blueprint $table) {
            $table->dropColumn('is_vinculado');
        });
    }
}
