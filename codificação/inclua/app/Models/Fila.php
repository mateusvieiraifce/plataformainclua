<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Fila extends Model
{
  use HasFactory;
  protected $fillable = ['tipo', 'ordem', 'hora_entrou', 'clinica_id', 'especialista_id',
  'paciente_id','consulta_id'];
} ?>