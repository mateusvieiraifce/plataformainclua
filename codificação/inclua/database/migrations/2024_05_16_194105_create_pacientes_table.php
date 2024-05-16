<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesTable extends Migration
{
  public function up()
  {
    Schema::create('pacientes', function (Blueprint $table) {
      $table->id();
      $table->string('nome')->nullable();
      $table->unsignedBigInteger('usuario_id')->nullable();
      $table->timestamps();
    });

    Schema::table('pacientes', function (Blueprint $table) {
      $table->foreign('usuario_id')->references('id')->on('users');
    });
  }
  public function down()
  {
    Schema::dropIfExists('pacientes');
  }
} ?>