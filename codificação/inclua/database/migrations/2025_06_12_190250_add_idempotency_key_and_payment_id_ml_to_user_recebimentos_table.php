<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdempotencyKeyAndPaymentIdMlToUserRecebimentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_recebimentos', function (Blueprint $table) {
            $table->string('idempotencyKey', 255)->nullable()->comment('Chave de idempotência para evitar processamento duplicado');
            $table->string('payment_id_ml', 255)->nullable()->comment('ID do pagamento no Mercado Livre');
            $table->decimal('liquido_ml', 8,2)->nullable()->comment('valor liquido no Mercado Livre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_recebimentos', function (Blueprint $table) {
            $table->dropColumn('idempotencyKey');
            $table->dropColumn('payment_id_ml');
            $table->dropColumn('liquido_ml');
        });
    }
}
