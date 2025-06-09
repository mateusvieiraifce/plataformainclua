<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRecebimentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_recebimentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('inicio');
            $table->date('fim');
            $table->integer('numero_consultas');
            $table->decimal('total_consultas_pix', 8 , 2);
            $table->decimal('total_consultas_especie', 8 , 2);
            $table->decimal('total_consultas_maquininha', 8 , 2);
            $table->decimal('total_consultas_credito', 8 , 2);
            $table->decimal('taxa_clinica', 8 , 2);
            $table->decimal('taxa_inclua', 8 , 2);
            $table->decimal('taxa_cartao', 8 , 2);
            $table->decimal('saldo', 8 , 2);
            $table->string("comprovante")->nullable() ;
            $table->date('vencimento');
            $table->date('pagamento')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('especialista_id');
            $table->unsignedBigInteger('clinica_id');
            $table->foreign('especialista_id')->references('id')->on('especialistas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('clinica_id')->references('id')->on('clinicas')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_recebimentos');
    }
}
