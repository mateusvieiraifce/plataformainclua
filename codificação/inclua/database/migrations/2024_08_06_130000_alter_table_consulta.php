<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableConsulta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {     
        Schema::table('consultas', function (Blueprint $table) {
            $table->string('motivocancelamento', 255)->nullable()->after('especialista_id');
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
            $table->dropColumn('motivocancelamento');
        });
    }
}
