<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'anuncio_id','comprador_id','nome','email','pontos','ativo'
    ];
    protected $table='comentarios';
}
