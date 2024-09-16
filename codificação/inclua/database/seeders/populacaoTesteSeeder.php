<?php

namespace Database\Seeders;

use App\Models\Clinica;
use App\Models\Permission;
use App\Models\Tipoexame;
use App\Models\TipoMedicamento;
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

        //usuario paciente 01
        $userPaciente01 = User::create([ 
            'nome_completo' => "Paciente 01",
            'password' => bcrypt("1"),
            'email' => "p@p",
            'created_at' => now(),
            'updated_at' => now(),
            'telefone' => "889811224454",
            'tipo_user' => 'P',
            'etapa_cadastro' => 'F',
        ]);
        DB::table('pacientes')->insert([
            'nome' => "Paciente 01",
            'usuario_id' => $userPaciente01->id,          
            'cpf' => "12345678978"
        ]);
        
        //usuario paciente 02
        $userPaciente02 = User::create([ 
            'nome_completo' => "Paciente 02",
            'password' => bcrypt("1"),
            'email' => "p2@p",
            'created_at' => now(),
            'updated_at' => now(),
            'telefone' => "889811224454",
            'tipo_user' => 'P',
            'etapa_cadastro' => 'F',
        ]);
        DB::table('pacientes')->insert([
            'nome' => "Paciente 02",
            'usuario_id' => $userPaciente02->id,          
            'cpf' => "98765432112"
        ]);

        //usuario especialista 01
        $userEspecialista01 = User::create([ 
            'nome_completo' => "Especialista 01",
            'password' => bcrypt("1"),
            'email' => "e@e",
            'created_at' => now(),
            'updated_at' => now(),
            'telefone' => "88981548765",
            'tipo_user' => 'E',
            'etapa_cadastro' => 'F',
        ]);
        $especialidade01 = Especialidade::create([ 
            'descricao' => "Neurologia",
            'valorpadrao' => "100",
            'created_at' => now(),
            'updated_at' => now(),
        ]);        
        $especialista01 = Especialista::create([
            'nome' => "Especialista 01",
            'usuario_id' => $userEspecialista01->id, 
            'especialidade_id' => $especialidade01->id,          
        ]);

        //usuario especialista 02
        $userEspecialista02 = User::create([ 
            'nome_completo' => "Especialista 02",
            'password' => bcrypt("1"),
            'email' => "e2@e",
            'created_at' => now(),
            'updated_at' => now(),
            'telefone' => "88981544865",
            'tipo_user' => 'E',
            'etapa_cadastro' => 'F',
        ]);
        $especialidade02 = Especialidade::create([ 
            'descricao' => "Psicologia",
            'valorpadrao' => "120",
            'created_at' => now(),
            'updated_at' => now(),
        ]);        
        $especialista02 = Especialista::create([
            'nome' => "Especialista 02",
            'usuario_id' => $userEspecialista02->id, 
            'especialidade_id' => $especialidade02->id,          
        ]);

        //usuario clinica 01
        $userClinica01 = User::create([ 
            'nome_completo' => "Usuario da Clinica 01",
            'password' => bcrypt("1"),
            'email' => "c@c",
            'created_at'=> now(),
            'updated_at' => now(),
            'telefone' => "88981548659",
            'tipo_user' => 'C',
            'etapa_cadastro' => 'F',
        ]);
        $clinica01 =  Clinica::create([
            'nome' => "Clinica 01",
            'usuario_id' => $userClinica01->id, 
            'ativo' => "1",
            'anamnese_obrigatoria' => "S",
        ]);

        DB::table('especialidadeclinicas')->insert([
            'valor' => 200,
            'clinica_id' => $clinica01->id, 
            'especialidade_id' => $especialidade01->id,          
        ]);

        DB::table('especialistaclinicas')->insert([           
            'clinica_id' => $clinica01->id, 
            'especialista_id' => $especialista01->id, 
            'is_vinculado'  => true         
        ]);

        //usuario clinica 02
        $userClinica02 = User::create([ 
            'nome_completo' => "Usuario da Clinica 02",
            'password' => bcrypt("1"),
            'email' => "c2@c",
            'created_at'=> now(),
            'updated_at' => now(),
            'telefone' => "88981231659",
            'tipo_user' => 'C',
            'etapa_cadastro' => 'F',
        ]);
        $clinica02 =  Clinica::create([
            'nome' => "Clinica 02",
            'usuario_id' => $userClinica02->id, 
            'ativo' => "1",
            'anamnese_obrigatoria' => "N",
        ]);

        DB::table('especialidadeclinicas')->insert([
            'valor' => 200,
            'clinica_id' => $clinica02->id, 
            'especialidade_id' => $especialidade02->id,   
            'is_vinculado'  => true           
        ]);

        DB::table('especialistaclinicas')->insert([           
            'clinica_id' => $clinica02->id, 
            'especialista_id' => $especialista02->id,      
            'is_vinculado' => true,        
        ]);

        //cad medicamentos
         $tipoMedicamento = TipoMedicamento::create([ 
            'descricao'=>"Amtibiótico",
            'qtdFolha'=>2,
        ]);

        DB::table('medicamentos')->insert([
            'nome_comercial'=>"Cefalosporinas",
            'tipo_medicamento_id'=>$tipoMedicamento->id, 
        ]);
        DB::table('medicamentos')->insert([
            'nome_comercial'=>"Fluoroquinolonas",
            'tipo_medicamento_id'=>$tipoMedicamento->id, 
        ]);

         //cad exames
           $tipoExame = Tipoexame::create([ 
            'descricao'=>"Imagem",
        ]);

        DB::table('exames')->insert([
            'nome'=>"Raio X",
            'tipoexame_id'=>$tipoExame->id, 
        ]);
        DB::table('exames')->insert([
            'nome'=>"Radiografia",
            'tipoexame_id'=>$tipoExame->id, 
        ]);



        //fazer clinica vinculada a especialista


    }
}
