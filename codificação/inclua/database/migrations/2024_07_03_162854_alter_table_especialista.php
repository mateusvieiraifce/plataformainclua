<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEspecialista extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('especialistas', function (Blueprint $table) {
            $table->dropColumn('telefone');
            $table->string('celular')->nullable()->after('nome');
            $table->string('conta_bancaria')->nullable()->after('especialidade_id');
            $table->string('agencia')->nullable()->after('conta_bancaria');
            $table->string('banco')->nullable()->after('agencia');
            $table->string('chave_pix')->nullable()->after('banco');
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
            $table->dropColumn('chave_pix');
            $table->dropColumn('banco');
            $table->dropColumn('agencia');
            $table->dropColumn('conta_bancaria');
            $table->dropColumn('celular');
            $table->string('telefone')->nullable()->after('nome');
        });
    }
}
