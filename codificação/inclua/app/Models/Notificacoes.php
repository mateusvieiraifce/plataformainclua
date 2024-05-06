<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacoes extends Model
{
    use HasFactory;
    protected $fillable = [
        'descricao','id_user','data_leitura','id_anuncio','id_venda'
    ];
    protected $table='notificacoes';
}
