<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'recebedor','cep','estado','cidade','bairro','rua','numero','complemento','informacoes','user_id','princial'
    ];
    protected $table='enderecos';
    public $timestamps=false;

}
