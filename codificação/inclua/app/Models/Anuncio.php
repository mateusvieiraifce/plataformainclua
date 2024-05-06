<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_anuncio','titulo','descricao','preco','quantidade','ativo','destaque',
        'user_id','type_id','altura','largura','peso','color_id','hashtag'
    ];

    protected $table='anuncios';
}
