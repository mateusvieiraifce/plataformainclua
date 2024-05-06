<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorAdv extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_adv', function (Blueprint $table) {
            $table->id();
            $table->string('descricao')->unique();
            $table->string('cod');
        });

        Schema::table('anuncios', function (Blueprint $table) {
            $table->unsignedBigInteger('color_id')->unsigned()->nullable();

         });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('color_adv');
        Schema::dropColumns('anuncios','color_id');
    }
}
