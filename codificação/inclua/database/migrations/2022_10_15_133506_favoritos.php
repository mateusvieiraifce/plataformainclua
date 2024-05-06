<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Favoritos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('anuncio_id');
            $table->unsignedBigInteger('comprador_id')->nullable();
            $table->string('ativo', 1)->default('S');
            $table->foreign('anuncio_id')->references('id')->on('anuncios')->cascadeOnDelete();
            $table->foreign('comprador_id')->references('id')->on('users')->cascadeOnDelete();
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
        Schema::dropIfExists('favoritos');
    }
}
