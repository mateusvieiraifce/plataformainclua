<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinica extends Model
{
  use HasFactory;
  protected $fillable = ['nome', 'razaosocial', 'cnpj', 'cep','estado',
  'cidade', 'rua', 'bairro', 'numero', 'telefone', 'longitude', 
  'latitude', 'logotipo','ativo', 'numero_atendimento_social_mensal', 'usuario_id'];
} ?>