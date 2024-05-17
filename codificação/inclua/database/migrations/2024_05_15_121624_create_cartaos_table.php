<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->string('numero_cartao', 255)->nullable(false)->unique();
            $table->char('mes_validade', 2);
            $table->char('ano_validade', 4);
            $table->string('cvv', 255)->nullable(false);
            $table->string('nome_titular', 255)->nullable(false);
            $table->string('principal', 1)->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cartoes', function(Blueprint $table){
            //remover a fk
            $table->dropForeign('cartoes_user_id_foreign'); //[table]_[coluna]_foreign
            //remover a coluna unidade_id
            $table->dropColumn('user_id');
        });
        
        Schema::dropIfExists('cartoes');
    }
}