<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartao extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'token',
        'issuer_id',
        'installments',
        'payment_method_id',
        'email'
    ];

    protected $table = 'cartoes';
}
