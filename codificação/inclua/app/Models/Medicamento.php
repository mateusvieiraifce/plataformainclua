<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Medicamento extends Model
{
  use HasFactory;
  protected $fillable = [
    'nome_comercial',
    'nome_generico',
    'forma',
    'concentracao',
    'via',
    'indicacao',
    'posologia',
    'precaucao',
    'advertencia',
    'contraindicacao',
    'composicao',
    'latoratorio_fabricante',
    'tipo_medicamento_id'
  ];
} ?>