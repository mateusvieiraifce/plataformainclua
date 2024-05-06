<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAnuncio extends Model
{
    use HasFactory;
    protected $fillable = [
        'path','anuncio_id','destaque'
    ];
    protected $table='files_anuncios';
}
