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

  public function noHasAvaliacao()
  {
    $avaliacao = AvaliacaoComentario::join('avaliacoes', 'avaliacoes.comentario_id', 'avaliacoes_comentarios.id')
      ->where('avaliacoes.consulta_id', $this->id)
      ->where(function ($query) {
        $query->orWhere('tipo_avaliado', 'E')->orWhere('tipo_avaliado', 'C');
      })
      ->count();
    
    if (empty($avaliacao)) {
      return true;
    } else {
      return false;
    }
    
  }
}