<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEndereco extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enderecos', function (Blueprint $table) {
            $table->dropColumn('recebedor');
            $table->dropColumn('princial');
        });

        Schema::table('enderecos', function (Blueprint $table) {
            $table->boolean('principal');
            $table->string('recebedor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('enderecos', function (Blueprint $table) {
            $table->dropColumn('principal');
            $table->dropColumn('recebedor');
        });

        Schema::table('enderecos', function (Blueprint $table) {
            $table->string('recebedor')->nullable();
            $table->boolean('princial');
        });
    }
}
