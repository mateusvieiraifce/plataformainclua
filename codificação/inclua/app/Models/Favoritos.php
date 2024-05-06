<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favoritos extends Model
{
    use HasFactory;
    protected $fillable = [
        'anuncio_id','comprador_id','ativo'
    ];
    protected $table='favoritos';
}
