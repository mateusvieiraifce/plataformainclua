<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateEspecialistaclinicasTable extends Migration{
  public function up(){
    Schema::create('especialistaclinicas', function (Blueprint $table) {
      $table->id();
      $table->string('especialista_id')->nullable();
      $table->unsignedBigInteger('clinica_id');
      $table->timestamps();
    });
 Schema::table('especialistaclinicas', function (Blueprint $table) {
            $table->foreign('clinica_id')->references('id')->on('clinicas');
        });
  } 
  public function down(){ 
    Schema::dropIfExists('especialistaclinicas');
  } 
} ?>
