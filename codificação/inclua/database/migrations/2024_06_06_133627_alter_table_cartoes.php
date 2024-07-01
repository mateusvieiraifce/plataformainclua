<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCartoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cartoes', function (Blueprint $table) {
            $table->dropColumn('cvv');
            $table->string('codigo_seguranca', 255)->nullable(false)->after('ano_validade');
            $table->string('status', 255)->after('nome_titular');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cartoes', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('codigo_seguranca');
            $table->string('cvv', 255)->nullable(false)->after('ano_validade');
        });
    }
}
