<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialistaclinica extends Model
{
  use HasFactory;
  protected $fillable = ['especialista_id', 'clinica_id'];
} ?>