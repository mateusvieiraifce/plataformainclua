<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsAnuncio extends Model
{
    use HasFactory;
    protected $fillable = [
        'descricao','adv_id'
    ];
    protected $table='tags_adv';
}
