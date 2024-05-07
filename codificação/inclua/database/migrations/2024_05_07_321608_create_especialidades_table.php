<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecialidadesTable extends Migration
{
  public function up()
  {
    Schema::create('especialidades', function (Blueprint $table) {
      $table->id();
      $table->string('descricao')->nullable();
      $table->double('valorpadrao')->nullable();
      $table->timestamps();
    });
  }
  public function down()
  {
    Schema::dropIfExists('especialidades');
  }
} ?>