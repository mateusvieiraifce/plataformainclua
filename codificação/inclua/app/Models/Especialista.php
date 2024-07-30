<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Especialista extends Model
    {
    use HasFactory;
    protected $fillable = [
        'nome',
        'usuario_id',
        'especialidade_id',
        'conta_bancaria',
        'agencia',
        'banco',
        'chave_pix'
    ];
}