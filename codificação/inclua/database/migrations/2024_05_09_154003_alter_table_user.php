<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('codigo_validacao', 1)->nullable()->after('celular');
            $table->string('celular_validado', 1)->nullable()->after('codigo_validacao');
            $table->string('rg', 255)->nullable()->after('celular_validado');
            $table->date('data_nascimento')->nullable()->after('rg');
            $table->string('estado_civil', 1)->nullable()->after('data_nascimento');
            $table->string('consentimento', 1)->nullable()->after('estado_civil');
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
            $table->dropColumn('consentimento');
            $table->dropColumn('estado_civil');
            $table->dropColumn('data_nascimento');
            $table->dropColumn('rg');
            $table->dropColumn('celular_validado');
            $table->dropColumn('codigo_validacao');
            $table->string('name', 255)->nullable(false)->after('id');
        });
    }
}
