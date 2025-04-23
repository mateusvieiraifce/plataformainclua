<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEspecialistas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('especialistas', function (Blueprint $table) {
            $table->string('path_certificado')->after('especialidade_id')->nullable();
            $table->dateTime('data_validacao')->after('path_certificado')->nullable();
            $table->dateTime('data_invalidacao')->after('data_validacao')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('especialistas', function (Blueprint $table) {
            $table->dropColumn('path_certificado');
            $table->dropColumn('data_validacao');
            $table->dropColumn('data_invalidacao');
        });
    }
}
