<?php
    namespace App\Models;

use App\Helper;
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

    public function getTelefone($user_id)
    {
        $user = User::find($user_id);
        $telefone = isset($user->telefone) ? Helper::mascaraTelefone($user->telefone) : null;

        return $telefone;
    }

    public function getCelular($user_id)
    {
        $user = User::find($user_id);
        $celular = isset($user->celular) ? Helper::mascaraCelular($user->celular) : null;

        return $celular;
    }
}