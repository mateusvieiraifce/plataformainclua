<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSendMsgZap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('msg_send_zap', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('msg');
            $table->string('phone');
            $table->string('instance');
            $table->boolean('enviado');
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
        Schema::dropIfExists('msg_send_zap');
    }
}
