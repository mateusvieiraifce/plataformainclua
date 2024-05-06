<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tamanho extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'descricao'
    ];
    protected $table='tamanhos';
}
