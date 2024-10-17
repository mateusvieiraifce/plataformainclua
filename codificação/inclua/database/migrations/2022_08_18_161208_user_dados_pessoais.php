<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserDadosPessoais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nome_completo')->nullable();
            $table->string('documento')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->boolean('ativo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nome_completo');
            $table->dropColumn('documento');
            $table->dropColumn('telefone');
            $table->dropColumn('celular');
            $table->dropColumn('ativo');
        });
    }
}
