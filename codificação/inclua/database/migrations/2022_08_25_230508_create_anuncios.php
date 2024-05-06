<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnuncios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_adv', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->timestamps();
        });

        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_anuncio');
            $table->string('titulo');
            $table->string('descricao');
            $table->double('preco')->nullable()->default(0);
            $table->double('quantidade')->nullable()->default(0);
            $table->boolean('ativo')->nullable();
            $table->boolean('destaque')->nullable()->default(false);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->timestamps();
            $table->double('altura')->nullable()->default(0);;
            $table->double('largura')->nullable()->default(0);;
            $table->double('peso')->nullable()->default(0);;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anuncios');
        Schema::dropIfExists('type_adv');
    }
}
