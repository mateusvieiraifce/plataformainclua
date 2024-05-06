<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensVenda extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantidade','preco_item','anuncio_id','venda_id','vendedor_id','tamanho'
    ];
    protected $table='itens_vendas';
    public $timestamps=false;
}
