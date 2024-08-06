<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvaliacaoespecilistasTable extends Migration
{
  public function up()
  {
    Schema::create('avaliacaoespecilistas', function (Blueprint $table) {
      $table->id();
      $table->string('qtdestrela')->nullable();
      $table->string('messagem')->nullable();
      $table->unsignedBigInteger('consulta_id');
      $table->timestamps();
    });
    Schema::table('avaliacaoespecilistas', function (Blueprint $table) {
      $table->foreign('consulta_id')->references('id')->on('consultas');
    });
  }
  public function down()
  {
    Schema::dropIfExists('avaliacaoespecilistas');
  }
} ?>