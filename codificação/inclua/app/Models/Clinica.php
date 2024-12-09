<?php
namespace App\Models;

use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Especialista;
use App\Models\Clinica;

class Clinica extends Model
{
  use HasFactory;
  protected $fillable = [
    'nome',
    'razaosocial',
    'cnpj',
    'logotipo',
    'ativo',
    'numero_atendimento_social_mensal',
    'anamnese_obrigatoria',
    'usuario_id'
  ];

  public function getUser()
  {
    return $this->hasOne(User::class, 'id', 'usuario_id');
  }

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
}