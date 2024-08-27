<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Tipoexame extends Model
{
  use HasFactory;
  protected $fillable = ['descricao'];
} ?>