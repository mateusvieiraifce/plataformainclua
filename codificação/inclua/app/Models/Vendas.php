<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendas extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_venda','total','transaction_pag_seguro','data_pagamento','valor','valor_liquido','taxa_operadora',
        'taxa_ecomoda','status_pagseguro','txt_status_pagseguro','status_metodo','comprador_id',
        'endereco_id'
    ];
    protected $table='vendas';

}
