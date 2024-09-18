<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Fila extends Model
{
  use HasFactory;
  protected $fillable = ['tipo', 'ordem', 'hora_entrou', 'consulta_id'];
} ?>