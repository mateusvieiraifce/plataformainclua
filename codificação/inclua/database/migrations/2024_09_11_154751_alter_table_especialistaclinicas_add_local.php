<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEspecialistaClinicasAddLocal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('especialistaclinicas', function (Blueprint $table) {
            $table->string('local_consulta')->after('especialista_id')->nullable();
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
            $table->dropColumn('local_consulta');
        });
    }
}
