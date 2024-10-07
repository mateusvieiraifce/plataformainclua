<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    protected $table = 'avaliacoes';

    public $timestamps = false;
    
    protected $fillable = [
        'categoria',
        'nota',
        'avaliador_id',
        'consulta_id',
        'tipo_avaliado'
    ];
   
}
