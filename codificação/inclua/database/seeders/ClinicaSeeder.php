<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Clinica;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 5; $i++) {
            $user = User::factory()->create([
                'tipo_user' => 'C',  
                'tipo_pessoa' => 'J',  
                'nome_completo' => $faker->company,
                'email' => $faker->unique()->safeEmail,
                'sexo' => null,
                'data_nascimento' => null,
                'documento' => $faker->numerify('##############'),
            ]);

            // Criar a clínica associada ao usuário
            Clinica::create([
                'nome' => $faker->company,  
                'razaosocial' => null,  
                'cnpj' =>$user->documento,
                'logotipo' => 'https://via.placeholder.com/150x150.png/00aa44?text=Clínica',  
                'ativo' => 1,  
                'numero_atendimento_social_mensal' => 10,  
                'anamnese_obrigatoria' => 'N',
                'usuario_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
?>
