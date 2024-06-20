<?php
namespace App\Http\Controllers;
use App\Models\Clinica;
use App\Models\Especialidadeclinica;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
   
   function marcarconsultapasso1()
   {
      return view('userPaciente/marcarconsultapasso1');
   }

   function marcarconsultapasso2Clinica()
   {
      //retonando a lista de clincias
      $filter = "";
      if (isset($_GET['filtro'])) {
         $filter = $_GET['filtro'];
      }
      $lista = Clinica::join('users', 'users.id', '=', 'usuario_id')->
         where('nome', 'like', "%" . "%")->
         orderBy('nome', 'asc')->
         select('clinicas.id', 'users.nome_completo as nome_responsavel', 'nome', 'cnpj', 'clinicas.telefone', 'clinicas.ativo')->
         paginate(8);
      return view('userPaciente/marcarconsultapasso2', ['lista' => $lista, 'filtro' => $filter]);

   }

   function marcarconsultapasso3Clinica($clinica_id)
   {
      /*
      //todoas os especialista que eh vinculado a clinica
      $lista =  Especialistaclinica::
      join('especialistas', 'especialistas.id','=','especialistaclinicas.especialista_id')->
      where('clinica_id',$clinica_id)->
      orderBy('especialistas.nome', 'asc')->
      select('especialistas.id','especialistas.nome')->
      paginate(8);
      return view('userPaciente/marcarconsultapasso3', ['lista' => $lista]);
      */

       //todas as especialidades que eh vinculado a clinica
       $lista =  Especialidadeclinica::
       join('especialidades', 'especialidades.id','=','especialidadeclinicas.especialidade_id')->
       where('clinica_id',$clinica_id)->
       orderBy('especialidades.descricao', 'asc')->
       select('especialidades.id','especialidades.descricao')->
       paginate(8);
       return view('userPaciente/marcarconsultapasso3', ['lista' => $lista]);
       

   }

   function marcarconsultapasso4Clinica($clinica_id,$especialidade_id)
   {
     
       //todas as especialidades que eh vinculado a clinica
       $lista =  Especialidadeclinica::
       join('especialidades', 'especialidades.id','=','especialidadeclinicas.especialidade_id')->
       where('clinica_id',$clinica_id)->
       orderBy('especialidades.descricao', 'asc')->
       select('especialidades.id','especialidades.descricao')->
       paginate(8);
       return view('userPaciente/marcarconsultapasso3', ['lista' => $lista]);
       

   }
   
   
 
 
 
} ?>