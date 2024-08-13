<?php

namespace Database\Seeders;

use App\Models\Clinica;
use App\Models\Permission;
use App\Models\User;
use App\Models\Especialidade;
use App\Models\Especialista;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class populacaoTesteSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //usuario root
        DB::table('users')->insert([
            'nome_completo'=>"Usuario Root - Teste",
            'password'=>bcrypt("1"),
            'email'=>"r@r",
            'created_at'=>now(),
            'updated_at'=>now(),
            'telefone'=>"88888888",
            'tipo_user' => 'R',
            'etapa_cadastro' => 'F',
        ]);

        //usuario paciente
        $entidade = User::create([ 
            'nome_completo'=>"Paciente 01",
            'password'=>bcrypt("1"),
            'email'=>"p@p",
            'created_at'=>now(),
            'updated_at'=>now(),
            'telefone'=>"88888888",
            'tipo_user' => 'P',
            'etapa_cadastro' => 'F',
        ]);
        DB::table('pacientes')->insert([
            'nome'=>"Paciente 01",
            'usuario_id'=>$entidade->id,          
        ]);


        //usuario especialista
        $entidade = User::create([ 
            'nome_completo'=>"Especialista 01",
            'password'=>bcrypt("1"),
            'email'=>"e@e",
            'created_at'=>now(),
            'updated_at'=>now(),
            'telefone'=>"88888888",
            'tipo_user' => 'E',
            'etapa_cadastro' => 'F',
        ]);
        $especialidade = Especialidade::create([ 
            'descricao'=>"Neuro 01",
            'valorpadrao'=>"100",
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);        
       $especialista = Especialista::create([
            'nome'=>"Especialista 01",
            'usuario_id'=>$entidade->id, 
            'especialidade_id'=>$especialidade->id,          
        ]);

        //usuario clinica 01
        $entidade = User::create([ 
            'nome_completo'=>"Usuario da Clinica 01",
            'password'=>bcrypt("1"),
            'email'=>"c@c",
            'created_at'=>now(),
            'updated_at'=>now(),
            'telefone'=>"88888888",
            'tipo_user' => 'C',
            'etapa_cadastro' => 'F',
        ]);
        $clinica01 =  Clinica::create([
            'nome'=>"Clinica 01",
            'usuario_id'=>$entidade->id, 
            'ativo'=>"1",
        ]);
        DB::table('especialidadeclinicas')->insert([
            'valor'=>200,
            'clinica_id'=>$clinica01->id, 
            'especialidade_id'=>$especialidade->id,          
        ]);


        DB::table('especialistaclinicas')->insert([           
            'clinica_id'=>$clinica01->id, 
            'especialista_id'=>$especialista->id,          
        ]);



        

         //usuario clinica 02
         $entidade = User::create([ 
            'nome_completo'=>"Usuario da Clinica 02",
            'password'=>bcrypt("1"),
            'email'=>"c@c2",
            'created_at'=>now(),
            'updated_at'=>now(),
            'telefone'=>"88888888",
            'tipo_user' => 'C',
            'etapa_cadastro' => 'F',
        ]);
        DB::table('clinicas')->insert([
            'nome'=>"Clinica 02",
            'usuario_id'=>$entidade->id, 
            'ativo'=>"1",
        ]);

        //fazer clinica vinculada a especialista


    }
}
