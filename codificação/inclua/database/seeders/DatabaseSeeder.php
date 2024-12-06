<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(userSeeder::class);
        $this->call(populacaoTesteSeeder::class);
        $this->call([PacienteSeeder::class]);
        $this->call([ClinicaSeeder::class]);
        $this->call([EspecialistasSeeder::class]);
        $this->call([ConsultasSeeder::class]);   
    }
}
