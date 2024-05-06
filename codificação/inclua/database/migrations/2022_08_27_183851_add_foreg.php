<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      /*  Schema::table('anuncios', function (Blueprint $table) {
          //  $table->foreign('type_id')->references('id')->on('type_adv')->cascadeOnDelete();//
           // $table->foreign('user_id')->references('id')->on('users');//
        });

        Schema::table('files_anuncios', function (Blueprint $table) {
            $table->foreign('anuncio_id')->references('id')->on('anuncios')->cascadeOnDelete();;//
        });

        Schema::table('tags_adv', function (Blueprint $table) {
            $table->foreign('adv_id')->references('id')->on('anuncios')->cascadeOnDelete();;//
        });

        Schema::table('anuncios', function (Blueprint $table) {
            $table->foreign('color_id')->references('id')->on('color_adv')->cascadeOnDelete();;//
        });

        Schema::table('enderecos', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();;//
        });*/


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
