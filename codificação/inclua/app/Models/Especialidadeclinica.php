<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidadeclinica extends Model
{
  use HasFactory;
  protected $fillable = ['valor', 'clinica_id', 'especialidade_id'];
} ?>