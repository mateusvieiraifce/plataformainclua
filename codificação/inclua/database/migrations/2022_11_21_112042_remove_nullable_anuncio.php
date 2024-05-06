<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\Type;

class RemoveNullableAnuncio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Type::hasType('double')) {
            Type::addType('double', FloatType::class);
        }
        Schema::table('anuncios', function (Blueprint $table) {
            $table->double('preco')->nullable(false)->change();
            $table->double('quantidade')->nullable(false)->change();
            $table->boolean('ativo')->nullable(false)->change();
            $table->boolean('destaque')->nullable(false)->change();
            $table->double('altura')->nullable(false)->change();
            $table->double('largura')->nullable(false)->change();
            $table->double('peso')->nullable(false)->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
