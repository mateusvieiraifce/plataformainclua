<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorAnuncio extends Model
{
    use HasFactory;
    protected $fillable = [
        'descricao','cod'
    ];
    protected $table='color_adv';
    public $timestamps=false;
}
