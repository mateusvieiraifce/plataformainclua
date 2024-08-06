<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacaoespecilista extends Model
{
  use HasFactory;
  protected $fillable = ['qtdestrela', 'messagem', 'consulta_id'];
} ?>