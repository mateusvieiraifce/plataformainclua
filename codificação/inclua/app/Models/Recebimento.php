<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recebimento extends Model
{
    use HasFactory;
    protected $table='user_recebimentos';
    protected $fillable = ['inicio','fim','numero_consultas','total_consultas_pix','total_consultas_especie','total_consultas_maquininha',
        'total_consultas_credito','comprovante','vencimento','pagamento','status','especialista_id','taxa_inclua','taxa_cartao','taxa_clinica'];
}
