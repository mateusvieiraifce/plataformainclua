<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecialidadeclinicasTable extends Migration
{
  public function up()
  {
    Schema::create('especialidadeclinicas', function (Blueprint $table) {
      $table->id();
      $table->double('valor')->nullable();
      $table->unsignedBigInteger('clinica_id');
      $table->unsignedBigInteger('especialidade_id');
      $table->timestamps();
    });

    Schema::table('especialidadeclinicas', function (Blueprint $table) {
      $table->foreign('clinica_id')->references('id')->on('clinicas');
    });

    Schema::table('especialidadeclinicas', function (Blueprint $table) {
      $table->foreign('especialidade_id')->references('id')->on('especialidades');
    });

  }
  public function down()
  {
    Schema::dropIfExists('especialidadeclinicas');
  }
} ?>