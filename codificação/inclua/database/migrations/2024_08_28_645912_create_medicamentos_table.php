<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateMedicamentosTable extends Migration{
  public function up(){
    Schema::create('medicamentos', function (Blueprint $table) {
      $table->id();
      $table->string('nome_comercial')->nullable();
      $table->string('nome_generico')->nullable();
      $table->string('forma')->nullable();
      $table->string('concentracao')->nullable();
      $table->string('via')->nullable();
      $table->string('indicacao')->nullable();
      $table->string('posologia')->nullable();
      $table->string('precaucao')->nullable();
      $table->string('advertencia')->nullable();
      $table->string('contraindicacao')->nullable();
      $table->string('composicao')->nullable();
      $table->string('latoratorio_fabricante')->nullable();
      $table->unsignedBigInteger('tipo_medicamento_id');
      $table->timestamps();
    });

    Schema::table('medicamentos', function (Blueprint $table) {
      $table->foreign('tipo_medicamento_id')->references('id')->on('tipo_medicamentos');
    });
  } 
  public function down(){ 
    Schema::dropIfExists('medicamentos');
  } 
} ?>
