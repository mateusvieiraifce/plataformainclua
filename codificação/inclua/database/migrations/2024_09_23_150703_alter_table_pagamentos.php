<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePagamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->string('transaction_code', 256);
            $table->string('status');
            $table->string('servico');
            $table->dateTime('data_pagamento')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropColumn('transaction_code');
            $table->dropColumn('status');
        });
    }
}
