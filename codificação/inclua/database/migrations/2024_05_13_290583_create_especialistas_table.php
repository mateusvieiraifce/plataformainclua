<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecialistasTable extends Migration
{
  public function up()
  {
    Schema::create('especialistas', function (Blueprint $table) {
      $table->id();
      $table->string('nome')->nullable();
      $table->string('telefone')->nullable();
      $table->unsignedBigInteger('usuario_id')->nullable();
      $table->unsignedBigInteger('especialidade_id')->nullable();
      
      $table->timestamps();
    });
    Schema::table('especialistas', function (Blueprint $table) {
      $table->foreign('usuario_id')->references('id')->on('users');
    });

    Schema::table('especialistas', function (Blueprint $table) {
      $table->foreign('especialidade_id')->references('id')->on('especialidades');
    });


  }
  public function down()
  {
    Schema::dropIfExists('especialistas');
  }
} ?>