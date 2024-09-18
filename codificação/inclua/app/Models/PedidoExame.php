<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoExame extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'exame_id',
        'laudo',
        'exame_efetuado',
        'local_arquivo_exame'
    ];
}
