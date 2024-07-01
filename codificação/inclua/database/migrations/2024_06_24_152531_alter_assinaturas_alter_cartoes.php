<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAssinaturasAlterCartoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assinaturas', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unsigned()->after('id');
            
            $table->foreign('user_id')->references('id')->on('users');
        });
        
        Schema::table('cartoes', function (Blueprint $table) {
            $table->string('instituicao', 255)->nullable(false)->after('numero_cartao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assinaturas', function(Blueprint $table){
            //remover a fk
            $table->dropForeign('assinaturas_user_id_foreign'); //[table]_[coluna]_foreign
            //remover a coluna unidade_id
            $table->dropColumn('user_id');
        });
        
        Schema::table('cartoes', function (Blueprint $table) {
            $table->dropColumn('instituicao');
        });
    }
}
