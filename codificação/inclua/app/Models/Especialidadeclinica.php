<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidadeclinica extends Model
{
  use HasFactory;
  protected $fillable = ['valor', 'clinica_id','is_vinculado', 'especialidade_id'];

    public function getEndereco($clinica_id)
    {

        $clinica = Clinica::find($clinica_id);
        //dd($clinica,$clinica_id);

        $endereco = Endereco::where('user_id', $clinica->usuario_id)->where("principal",true)->first();
        //$telefone = isset($user->telefone) ? Helper::mascaraTelefone($user->telefone) : null;
        return $endereco;
    }
} ?>
