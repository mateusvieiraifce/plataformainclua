<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateExamesTable extends Migration
{
  public function up()
  {
    Schema::create('exames', function (Blueprint $table) {
      $table->id();
      $table->string('nome')->nullable();
      $table->string('descricao')->nullable();
      $table->unsignedBigInteger('tipoexame_id');
      $table->timestamps();
    });
    Schema::table('exames', function (Blueprint $table) {
      $table->foreign('tipoexame_id')->references('id')->on('tipoexames');
    });
  }
  public function down()
  {
    Schema::dropIfExists('exames');
  }
} ?>