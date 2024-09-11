<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
  use HasFactory;
  protected $fillable = ['status', 'horario_agendado', 'horario_iniciado',
   'horario_finalizado', 'preco', 'porcetagem_repasse_clinica', 'porcetagem_repasse_plataforma',
    'paciente_id', 'especialista_id', 'clinica_id','motivocancelamento',
    'isPago','forma_pagamento','id_usuario_cancelou'
  ];
} ?>