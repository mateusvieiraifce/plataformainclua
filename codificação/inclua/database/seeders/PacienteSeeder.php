<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Paciente;
use Carbon\Carbon;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cria 100 pacientes
        User::factory()->count(100)->create([
            'tipo_user' => 'P',
        ])->each(function ($user) {
            // Após criar o usuário, cria o registro correspondente na tabela pacientes
            Paciente::create([
                'usuario_id' => $user->id, 
                'nome' => $user->nome_completo, 
                'cpf' => $user->documento, 
                'data_nascimento' => $user->data_nascimento, 
                'sexo' => $user->sexo, 
                'responsavel' => 0, 
                'created_at' => Carbon::now(), 
                'updated_at' => Carbon::now(), 
            ]);
        });
    }
}
?>
