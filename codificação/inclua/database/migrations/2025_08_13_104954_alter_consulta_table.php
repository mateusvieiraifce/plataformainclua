<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterConsultaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->integer('tempo')->default(30)->nullable()->comment('tempo da consulta');
            $table->string('linkmeet', 100)->nullable()->comment('link do convite');
            $table->string('convite', 300)->nullable()->comment('link do convite');
            $table->boolean('remota')->nullable()->default(false)->comment('diferenciar consulta presencial de remota');
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
            $table->dropColumn('linkmeet');
            $table->dropColumn('convite');
            $table->dropColumn('remota');
            $table->dropColumn('tempo');
        });
    }
}
