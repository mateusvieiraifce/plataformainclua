<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Notificacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificacoes', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 256);
            $table->timestamps();
            $table->unsignedBigInteger('id_user')->unsigned();
            $table->timestamp('data_leitura')->nullable();
            $table->unsignedBigInteger('id_anuncio')->unsigned()->nullable();
            $table->unsignedBigInteger('id_venda')->unsigned()->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificacoes');
    }
}
