<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TamanhoAnuncio extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'qtd_id','tamanho_id','adv_id'
    ];
    protected $table='tamanhos_adv';
}
