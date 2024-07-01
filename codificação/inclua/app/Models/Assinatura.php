<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cartao_id',
        'data_renovacao',
        'assinante',
        'mes_referencia',
        'transaction_code',
        'motivo',
        'situacao'
    ];
    
    public $timestamps=false;
}
