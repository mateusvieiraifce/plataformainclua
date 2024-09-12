<?php
namespace App\Models;

use App\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}