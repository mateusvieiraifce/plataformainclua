<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagamentoConta extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'descricao', 'valor', 'vencimento', 'status',
    ];

    protected $table = "pagamentos_contas";
}
