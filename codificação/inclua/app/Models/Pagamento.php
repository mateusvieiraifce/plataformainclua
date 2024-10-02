<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;
    
    protected $fillables = [
        'user_id',
        'cartao_id',
        'assinatura_id',
        'data_pagamento',
        'valor',
        'transaction_code',
        'status',
        'servico'
    ];
    
    public $timestamps=false;

    public function getCard()
    {
        
        return $this->hasOne(Cartao::class, 'id', 'cartao_id');
    }
}
