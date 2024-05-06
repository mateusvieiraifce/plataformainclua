<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAnuncio extends Model
{
    protected $fillable = [
        'descricao'
    ];
    protected $table='type_adv';
    public $timestamps=false;
}
