<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TamanhoVenda extends Model
{
    use HasFactory;
    protected $fillable = [
        'adv_id','venda_id','qtd_id','tamanho_id'
    ];
    protected $table='tamanhos_venda';
}
