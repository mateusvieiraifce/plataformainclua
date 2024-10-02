<?php

namespace App\Http\Controllers;

use App\Models\Especialistaclinica;
use App\Models\Clinica;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        session()->flash('msg', ['valor' => trans("Bem vindo a Plataforma Inclua!"), 'tipo' => 'success']);
        if ($user->tipo_user == 'P') {
            //home user Paciente
            return redirect()->route('paciente.home');
        } elseif ($user->tipo_user ==='E') {
            //home user Especialista
            return redirect()->route('consulta.listconsultaporespecialista');
         }
         elseif ($user->tipo_user ==='C') {
          //home user Clinica
          return redirect()->route('dashboard.dashboardClinica');
         }
        return view('dashboard');
    }

    function dashboardClinica()
    {
        $dataAtual = Carbon::now();
        $umAnoAntes = $dataAtual->subYear();
        $dataAtual = Carbon::now();

        $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();    
        //retornando todos os especialistas vinculados       
        $especialistas = Especialistaclinica::join('especialistas', 'especialistas.id', '=',
        'especialistaclinicas.especialista_id')->
        where('clinica_id', $clinica->id)->     
        orderBy('especialistas.nome', 'asc')->
        select('especialistas.id', 'especialistas.nome')->get();
      
        // selecionar as consultas na qual o status igual a finalizado
        $TodasConsultasPorMes = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')->
        where('consultas.clinica_id', '=', $clinica->id)->
        where('status', 'Finalizada')->
        whereBetween('horario_agendado', [$umAnoAntes, $dataAtual])->
        selectRaw('MONTH(horario_agendado) as mes, sum(preco) as preco_total, 
                count(*) as quantidade')->
        groupBy(Consulta::raw('MONTH(horario_agendado)'))->
        limit(12)->get();
   
        return view('userClinica/dashboard', ['lista' => $especialistas, 'TodasConsultasPorMes' => $TodasConsultasPorMes]);
    }


}
