<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'numero_cartao',
        'instituicao',
        'mes_validade',
        'ano_validade',
        'codigo_seguranca',
        'nome_titular',
        'status'
    ];

    protected $table = 'cartoes';
}
