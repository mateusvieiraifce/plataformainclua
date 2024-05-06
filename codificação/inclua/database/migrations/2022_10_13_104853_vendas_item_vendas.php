<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VendasItemVendas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_venda')->unique();
            $table->double('total');
            $table->string('transaction_pag_seguro')->nullable();;
            $table->timestamp('data_pagamento')->nullable();;
            $table->double('valor');
            $table->double('valor_liquido')->nullable();;
            $table->double('taxa_operadora')->nullable();;
            $table->double('taxa_ecomoda')->nullable();;
            $table->integer('status_pagseguro')->nullable();;
            $table->string('txt_status_pagseguro')->nullable();;
            $table->string('txt_status_metodo')->nullable();;
            $table->integer('status_metodo')->nullable();
            $table->unsignedBigInteger('comprador_id');
            $table->unsignedBigInteger('endereco_id');
            $table->foreign('comprador_id')->references('id')->on('users')->cascadeOnDelete();;//
            $table->foreign('endereco_id')->references('id')->on('enderecos')->cascadeOnDelete();;//
            $table->timestamps();
    });

        Schema::create('itens_vendas', function (Blueprint $table) {
             $table->id();
             $table->double('quantidade');
             $table->double('preco_item');
             $table->unsignedBigInteger('anuncio_id');
             $table->unsignedBigInteger('venda_id');
             $table->unsignedBigInteger('vendedor_id');
             $table->foreign('vendedor_id')->references('id')->on('users')->cascadeOnDelete();;//
             $table->foreign('anuncio_id')->references('id')->on('anuncios')->cascadeOnDelete();
             $table->foreign('venda_id')->references('id')->on('vendas')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itens_vendas');
        Schema::dropIfExists('vendas');
    }
}
