<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEspecialidadeClinicaAddisVinculado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('especialidadeclinicas', function (Blueprint $table) {
            $table->boolean('is_vinculado')->after('especialidade_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('especialidadeclinicas', function (Blueprint $table) {
            $table->dropColumn('is_vinculado');
        });
    }
}
