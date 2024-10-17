<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $primaryKey = 'id';
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [       
        'email',
        'password',
        'google_id',
        'avatar',
        'type',
        'nome_completo',
        'documento',
        'telefone',
        'celular',
        'codigo_validacao',
        'celular_validado',
        'rg',
        'data_nascimento',
        'estado_civil',
        'consentimento',
        'ativo',
        'sexo',
        'tipo_pessoa',
        'tipo_user',
        'etapa_cadastro'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Enderecos()
    {
        return $this->hasMany(Endereco::class, 'user_id', 'id');
    }

    public function getIdPaciente($usuario_id)
    {
        $paciente = Paciente::where('usuario_id', $usuario_id)->first();
        if ($paciente) {
            return $paciente->id;
        } else {
            return null;
        }
    }

    public function getIdEspecialidade($usuario_id)
    {
        $especialista = Especialista::where('usuario_id', $usuario_id)->first();
        if ($especialista) {
            return $especialista->especialidade_id;
        } else {
            return null;
        }
    }
    
    public function getIdEspecialista($usuario_id)
    {
        $especialista = Especialista::where('usuario_id', $usuario_id)->first();
        if ($especialista) {
            return $especialista->id;
        } else {
            return null;
        }
    }
}
