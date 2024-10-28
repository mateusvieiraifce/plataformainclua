<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    protected $table="configuracoes";

    public $timestamps = false;

    protected $fillable =[
        'color_primary',
        'color_gradiente',
        'logo',
        'icon',
        'favicon'
    ];

    public function getLogo()
    {
        $configuracao = Configuracao::first();
        if ($configuracao) {
            $configuracao = $configuracao->logo;
        }
        
        return $configuracao;
    }

    public function getFavicon()
    {
        $configuracao = Configuracao::first();
        if ($configuracao) {
            $configuracao = $configuracao->favicon;
        }

        return $configuracao;
    }

    public function getIcon()
    {
        $configuracao = Configuracao::first();
        if ($configuracao) {
            $configuracao = $configuracao->icon;
        }

        return $configuracao;
    }
}
