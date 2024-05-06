<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TamanhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tamanhos')->insert([
            'descricao' => 'Único',
        ]);
        DB::table('tamanhos')->insert([
            'descricao' => 'P',
        ]);

        DB::table('tamanhos')->insert([
            'descricao' => 'M',
        ]);

        DB::table('tamanhos')->insert([
            'descricao' => 'G',
        ]);
        DB::table('tamanhos')->insert([
            'descricao' => 'Até 3 Meses',
        ]);
        DB::table('tamanhos')->insert([
            'descricao' => 'Até 6 Meses',
        ]);
        DB::table('tamanhos')->insert([
            'descricao' => 'Até 12 Meses',
        ]);
        DB::table('tamanhos')->insert([
            'descricao' => '1 Ano',
        ]);
        DB::table('tamanhos')->insert([
            'descricao' => '2 Anos',
        ]);

    }
}
