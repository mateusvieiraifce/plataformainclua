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

               
        Schema::table('enderecos', function (Blueprint $table) {
            $table->dropColumn('longitude');
            $table->dropColumn('latitude');
        });
    }
}
