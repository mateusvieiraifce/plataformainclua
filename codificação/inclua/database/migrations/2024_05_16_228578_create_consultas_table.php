<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
  public function up()
  {
    Schema::create('consultas', function (Blueprint $table) {
      $table->id();
      $table->string('status')->nullable();
      $table->dateTime('horario_agendado')->nullable();
      $table->dateTime('horario_iniciado')->nullable();
      $table->dateTime('horario_finalizado')->nullable();
      $table->double('preco')->nullable();
      $table->double('porcetagem_repasse_clinica')->nullable();
      $table->double('porcetagem_repasse_plataforma')->nullable();
      $table->unsignedBigInteger('paciente_id')->nullable();
      $table->unsignedBigInteger('clinica_id');
      $table->unsignedBigInteger('especialista_id');
      $table->timestamps();
    });
    Schema::table('consultas', function (Blueprint $table) {
      $table->foreign('especialista_id')->references('id')->on('especialistas');
    });

    Schema::table('consultas', function (Blueprint $table) {
      $table->foreign('paciente_id')->references('id')->on('pacientes');
    });

    Schema::table('consultas', function (Blueprint $table) {
      $table->foreign('clinica_id')->references('id')->on('clinicas');
    });
  }
  public function down()
  {
    Schema::dropIfExists('consultas');
  }
} ?>