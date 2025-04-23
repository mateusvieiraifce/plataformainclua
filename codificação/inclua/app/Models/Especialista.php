<?php
namespace App\Models;

use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clinica;

class Especialista extends Model
    {
    use HasFactory;
    protected $fillable = [
        'nome',
        'usuario_id',
        'especialidade_id',
        'path_certificado',
        'conta_bancaria',
        'agencia',
        'banco',
        'chave_pix',
        'data_validacao',
        'data_invalidacao'
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

    public function clinicas()
    {
        return $this->belongsToMany(
            Clinica::class,          // Modelo relacionado
            'especialistaclinicas',             // Tabela de ligação
            'especialista_id',       // Chave estrangeira na tabela de ligação (do especialista)
            'clinica_id'             // Chave estrangeira na tabela de ligação (da clínica)
        )->withPivot('is_vinculado') // Inclui dados adicionais da tabela de ligação, se necessário
         ->wherePivot('is_vinculado', 1); // Filtra apenas vínculos ativos
    }
    public function especialistas()
    {
        return $this->belongsToMany(
            Especialista::class,    // Modelo relacionado
            'especialistaclinicas',            // Tabela de ligação
            'clinica_id',           // Chave estrangeira na tabela de ligação (da clínica)
            'especialista_id'       // Chave estrangeira na tabela de ligação (do especialista)
        )->withPivot('is_vinculado') // Inclui dados adicionais da tabela de ligação, se necessário
         ->wherePivot('is_vinculado', 1); // Filtra apenas vínculos ativos
    }

    public function getClinica()
    {
        $clinica = Especialistaclinica::join('clinicas', 'clinicas.id', 'especialistaclinicas.clinica_id')
            ->where('especialista_id', $this->id)
            ->first();

        return $clinica->nome;
    }
}