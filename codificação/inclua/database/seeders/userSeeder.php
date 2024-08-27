<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nome_completo'=>"Gerente master",
            'password'=>bcrypt("12345"),
            'email'=>"admin@inclua.com.br",
            'created_at'=>now(),
            'updated_at'=>now(),
            'telefone'=>"88888888",
            'tipo_user' => 'R',
            'etapa_cadastro' => 'F',
        ]);
    }
}
