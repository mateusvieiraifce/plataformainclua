<?php

namespace Database\Seeders;

use App\Models\Consulta;
use App\Models\User;
use App\Models\Clinica;
use App\Models\Especialista;
use App\Models\Paciente;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ConsultasSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        $clinicas = Clinica::all();
        $especialistas = Especialista::all();
        $pacientes = Paciente::all();
        $usuarios = User::all();

        for ($i = 0; $i < 1000; $i++) {
            $horario_agendado = $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d H:i:s');
            $horario_iniciado = date('Y-m-d H:i:s', strtotime($horario_agendado . ' +1 hour'));
            $horario_finalizado = date('Y-m-d H:i:s', strtotime($horario_iniciado . ' +1 hour'));

            $isCancelled = $faker->boolean(30); 
            $id_usuario_cancelou = null;

            if ($isCancelled) {
                $id_usuario_cancelou = $usuarios->random()->id;
            }

            Consulta::create([
                'status' => null,  
                'horario_agendado' => $horario_agendado,  
                'horario_iniciado' => $horario_iniciado,  
                'horario_finalizado' => $horario_finalizado,  
                'preco' => $faker->numberBetween(200, 500),  
                'isPago' => null,  
                'forma_pagamento' => collect(['Dinheiro', 'PIX', 'Cartão de Crédito'])->random(),
                'porcetagem_repasse_clinica' => 10,  
                'porcetagem_repasse_plataforma' => 10,  
                'paciente_id' => $pacientes->random()->id,
                'clinica_id' => $clinicas->random()->id,  
                'especialista_id' => $faker->randomElement($especialistas->pluck('id')->toArray()),
                'motivocancelamento' => $isCancelled ? 'porque sim' : null,  
                'id_usuario_cancelou' => $id_usuario_cancelou,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
