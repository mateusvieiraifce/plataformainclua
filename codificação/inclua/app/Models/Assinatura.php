<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'cartao_id',
        'data_pagamento',
        'renovacao',
    ];
    
    public $timestamps=false;
}
