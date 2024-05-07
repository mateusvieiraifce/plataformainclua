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
        $this->call(start_populate::class);
        $this->call(TamanhoSeeder::class);
        $this->call(userSeeder::class);
        $this->call(populacaoTesteSeeder::class);
        
    }
}
