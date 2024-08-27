<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePedidoExamesTable extends Migration
{
  public function up()
  {
    Schema::create('pedido_exames', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('consulta_id');
      $table->unsignedBigInteger('exame_id');
      $table->string('laudo')->nullable();
      $table->timestamps();
    });
    Schema::table('pedido_exames', function (Blueprint $table) {
      $table->foreign('consulta_id')->references('id')->on('consultas');
    });

    Schema::table('pedido_exames', function (Blueprint $table) {
      $table->foreign('exame_id')->references('id')->on('exames');
    });
  }
  public function down()
  {
    Schema::dropIfExists('pedido_exames');
  }
} ?>