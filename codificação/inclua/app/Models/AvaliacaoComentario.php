<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvaliacaoComentario extends Model
{
    use HasFactory;

    protected $table = "avaliacoes_comentarios";

    public $timestamps = false;

    protected $fillable = [
        'avaliacao_id',
        'comentario'
    ];
}
