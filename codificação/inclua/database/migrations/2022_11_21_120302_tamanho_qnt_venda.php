<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TamanhoQntVenda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tamanhos_venda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('venda_id');
            $table->unsignedBigInteger('adv_id');
            $table->unsignedBigInteger('qtd_id')->default(1);
            $table->unsignedBigInteger('tamanho_id');
            $table->timestamps();
        });

        Schema::create('tamanhos_adv', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('adv_id');
            $table->unsignedBigInteger('qtd_id')->default(1);
            $table->unsignedBigInteger('tamanho_id');
            $table->timestamps();
        });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tamanhos_adv');
        //
    }
}
