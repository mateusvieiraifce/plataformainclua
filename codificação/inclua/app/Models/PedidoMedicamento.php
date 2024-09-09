<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PedidoMedicamento extends Model
{
  use HasFactory;
  protected $fillable = ['consulta_id', 'medicamento_id', 'prescricao_indicada'];
} ?>