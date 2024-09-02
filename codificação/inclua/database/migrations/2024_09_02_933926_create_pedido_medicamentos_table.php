<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreatePedidoMedicamentosTable extends Migration
{
  public function up()
  {
    Schema::create('pedido_medicamentos', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('consulta_id')->nullable();
      $table->unsignedBigInteger('medicamento_id')->nullable();
      $table->string('prescricao_indicada')->nullable();
      $table->timestamps();
    });

    Schema::table('pedido_medicamentos', function (Blueprint $table) {
      $table->foreign('consulta_id')->references('id')->on('consultas');
    });

    Schema::table('pedido_medicamentos', function (Blueprint $table) {
      $table->foreign('medicamento_id')->references('id')->on('medicamentos');
    });
  }
  public function down()
  {
    Schema::dropIfExists('pedido_medicamentos');
  }
} ?>