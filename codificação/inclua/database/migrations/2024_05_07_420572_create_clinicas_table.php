<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicasTable extends Migration
{
  public function up()
  {
    Schema::create('clinicas', function (Blueprint $table) {
      $table->id();
      $table->string('nome')->nullable();
      $table->string('razaosocial')->nullable();
      $table->string('cnpj')->nullable();
      $table->string('cep')->nullable();
      $table->string('estado')->nullable();
      $table->string('cidade')->nullable();
      $table->string('rua')->nullable();
      $table->string('bairro')->nullable();
      $table->string('numero')->nullable();
      $table->string('telefone')->nullable();
      $table->double('longitude')->nullable();
      $table->double('latitude')->nullable();
      $table->string('logotipo')->nullable();
      $table->boolean('ativo')->nullable();
      $table->double('numero_atendimento_social_mensal')->nullable();
      $table->unsignedBigInteger('usuario_id')->nullable();
      $table->timestamps();
    });

    Schema::table('clinicas', function (Blueprint $table) {
      $table->foreign('usuario_id')->references('id')->on('users');
    });
  }
  public function down()
  {
    Schema::dropIfExists('clinicas');
  }
} ?>