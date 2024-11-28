<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clinica;
use App\Models\Especialista;
use App\Models\Especialidade;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class EspecialistasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $especialidade = Especialidade::all();

        for ($i = 0; $i < 100; $i++) {
            $user = User::factory()->create([   
                'tipo_user' => 'E',  
                'tipo_pessoa' => 'F',  
            ]);

            // Criar a clínica associada ao usuário
            Especialista::create([
                'nome' => $faker->name,  
                'usuario_id' => $user->id,  
                'especialidade_id' => $especialidade->random()->id,
                'conta_bancaria' => null,
                'agencia' => null,
                'banco' => null,
                'chave_pix' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
?>
