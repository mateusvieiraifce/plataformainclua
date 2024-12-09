<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialistaClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $especialistaIds = DB::table('especialistas')->pluck('id')->toArray();
        $clinicaIds = DB::table('clinicas')->pluck('id')->toArray();

        $consultas = [];
        for ($i = 0; $i < 100; $i++) {
            $consultas[] = [
                'especialista_id' => $especialistaIds[array_rand($especialistaIds)], 
                'clinica_id' => $clinicaIds[array_rand($clinicaIds)],
                'is_vinculado' => 1,
                'local_consulta' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('especialistaclinicas')->insert($consultas);
    }
}
