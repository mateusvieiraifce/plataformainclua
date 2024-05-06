<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class start_populate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_adv')->insert([
            'descricao' => 'Bordados',
        ]);
        DB::table('type_adv')->insert([
            'descricao' => 'Artesanato',
        ]);
        DB::table('type_adv')->insert([
            'descricao' => 'Tecidos',
        ]);
        DB::table('type_adv')->insert([
            'descricao' => 'Roupas de Bebê',
        ]);

        DB::table('color_adv')->insert([
            'descricao' => 'preto','cod'=>'#222'
        ]);

        DB::table('color_adv')->insert([
            'descricao' => 'azul','cod'=>'#4272d7'
        ]);

        DB::table('color_adv')->insert([
            'descricao' => 'rosa','cod'=>'#ffcbdb'
        ]);

        DB::table('color_adv')->insert([
            'descricao' => 'colorido','cod'=>'#9370DB'
        ]);

        DB::table('color_adv')->insert([
            'descricao' => 'cinza','cod'=>'#b3b3b3'
        ]);

        DB::table('color_adv')->insert([
            'descricao' => 'verde','cod'=>'#00ad5f'
        ]);

        DB::table('color_adv')->insert([
            'descricao' => 'branco','cod'=>'#aaa'
        ]);


    }
}
