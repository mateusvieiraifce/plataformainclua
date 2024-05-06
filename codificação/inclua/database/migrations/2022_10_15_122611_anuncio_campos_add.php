<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnuncioCamposAdd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anuncios', function (Blueprint $table) {
            $table->string('descricaod')->nullable();
            $table->string('material')->nullable();
            $table->string('titulo_destaque')->nullable();
            $table->string('subtitulo')->nullable();
            $table->string('hashtag')->nullable();
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
        Schema::table('anuncios', function (Blueprint $table) {
            $table->dropColumn('titulo_destaque');
            $table->dropColumn('subtitulo');
            $table->dropColumn('hashtag');
            $table->dropColumn('tamanho');
        });
    }
}
