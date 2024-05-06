<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('tags_adv', function (Blueprint $table) {
            $table->dropUnique(['descricao']);
        });*/

        Schema::table('anuncios', function (Blueprint $table) {
            $table->dropColumn(['id_anuncio']);
            $table->dropColumn(['ativo']);
        });


        Schema::table('anuncios', function (Blueprint $table) {
            $table->string('id_anuncio');
            $table->boolean('ativo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
