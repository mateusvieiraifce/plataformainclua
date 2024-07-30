<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEspecilistaClinica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('especialistas', function (Blueprint $table) {
            $table->dropColumn('celular');
        });

        Schema::table('clinicas', function (Blueprint $table) {
            $table->dropColumn('cep');
            $table->dropColumn('estado');
            $table->dropColumn('cidade');
            $table->dropColumn('rua');
            $table->dropColumn('bairro');
            $table->dropColumn('numero');
            $table->dropColumn('complemento');
            $table->dropColumn('telefone');
            $table->dropColumn('celular');
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
        });
        
        Schema::table('enderecos', function (Blueprint $table) {
            $table->double('longitude')->nullable()->after('complemento');
            $table->double('latitude')->nullable()->after('longitude');
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
            $table->string('celular')->nullable()->after('nome');
        });

        Schema::table('clinicas', function (Blueprint $table) {
            $table->string('cep')->nullable();
            $table->string('estado')->nullable();
            $table->string('cidade')->nullable();
            $table->string('rua')->nullable();
            $table->string('bairro')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('telefone')->nullable();
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
        });
        
        Schema::table('enderecos', function (Blueprint $table) {
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
        });
    }
}
