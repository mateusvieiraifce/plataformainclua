<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateFilasTable extends Migration
{
  public function up()
  {
    Schema::create('filas', function (Blueprint $table) {
      $table->id();
      $table->string('tipo')->nullable();
      $table->integer('ordem')->nullable();
      $table->dateTime('hora_entrou')->nullable();
      $table->integer('consulta_id')->nullable();
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists('filas');
  }
} ?>