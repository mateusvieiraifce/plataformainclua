<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TamanhoEstoque extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tamanhos', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 50);
            $table->timestamps();
        });

        Schema::table('vendas', function (Blueprint $table) {
            $table->unsignedBigInteger('tamanho')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tamanhos');
        Schema::table('vendas', function (Blueprint $table) {
            $table->dropColumn('tamanho');
        });
    }
}
