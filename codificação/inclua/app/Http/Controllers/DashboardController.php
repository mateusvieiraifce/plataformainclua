<?php

namespace App\Http\Controllers;

use App\Models\Especialistaclinica;
use App\Models\Clinica;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $year = Carbon::now()->year;

        // Consulta que conta os pacientes criados por mês
        $usersByMonth = DB::table('users')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('tipo_user', 'P') // Filtra pelo ano atual
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at) DESC')
            ->pluck('total', 'month');
        $totalUsers = DB::table('users')->where('tipo_user', 'P')->count();
        $monthlyCountsUsers = array_fill(1, 12, 0);
        
        foreach ($usersByMonth as $month => $count) {
            $monthlyCountsUsers[$month] = $count;
        }

        // Consulta que conta os especialistas criados por mês
        $especialistasByMonth = DB::table('users')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('tipo_user', 'E') // Filtra pelo ano atual
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at) DESC')
            ->pluck('total', 'month');
        $totalEspecialistas = DB::table('users')->where('tipo_user', 'E')->count();
        $monthlyCountsEspecialistas = array_fill(1, 12, 0);
        
        foreach ($especialistasByMonth as $month => $count) {
            $monthlyCountsEspecialistas[$month] = $count;
        }

        // Consulta que conta as clínicas criados por mês
        $clinicasByMonth = DB::table('users')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('tipo_user', 'C') // Filtra pelo ano atual
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at) DESC')
            ->pluck('total', 'month');
        $totalClinicas = DB::table('users')->where('tipo_user', 'C')->count();
        $monthlyCountsClinicas = array_fill(1, 12, 0);
        
        foreach ($clinicasByMonth as $month => $count) {
            $monthlyCountsClinicas[$month] = $count;
        }

        // Consulta que conta as consultas criadas por mês
        $queriesByMonth = DB::table('consultas')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year) // Filtra pelo ano atual
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at) DESC')
            ->take(6)
            ->pluck('total', 'month');
        $queriesByMonth = $queriesByMonth->sortKeys();
        $totalQueries = DB::table('consultas')->count();

        $monthlyCountsQueries = array_fill(7, 6, 0);
        
        foreach ($queriesByMonth as $month => $count) {
            $monthlyCountsQueries[$month] = $count;
        }

        // Consulta que conta as o total de reais das consultas criadas por mês
        $queriesSaleByMonth = DB::table('consultas')
            ->selectRaw('MONTH(created_at) as month, SUM(preco) as total')
            ->whereYear('created_at', $year) 
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at) DESC') 
            ->take(6) 
            ->pluck('total', 'month');
        $queriesSaleByMonth = $queriesByMonth->sortKeys();
        $totalSale = DB::table('consultas')
            ->whereYear('created_at', $year) 
            ->sum('preco');

        $monthlyCountsQueriesSale = array_fill(7, 6, 0);
        
        foreach ($queriesSaleByMonth as $month => $count) {
            $monthlyCountsQueriesSale[$month] = $count;
        }

        // Consulta que conta os cancelamentos por mês
        $cancellationsByMonth = DB::table('consultas')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->whereNotNull('id_usuario_cancelou')
            ->groupByRaw('MONTH(created_at)')
            ->orderByRaw('MONTH(created_at) DESC')
            ->take(6)
            ->pluck('total', 'month');

        $cancellationsByMonth = $cancellationsByMonth->sortKeys();

        $totalCancellations = DB::table('consultas')
            ->whereNotNull('id_usuario_cancelou')
            ->whereYear('created_at', $year)
            ->count();

        $monthlyCountsCancellations = array_fill(7, 6, 0);

        foreach ($cancellationsByMonth as $month => $count) {
            $monthlyCountsCancellations[$month] = $count;
        }
        return view('dashboard', [
            'monthlyCountsUsers' => $monthlyCountsUsers,
            'totalUsers' => $totalUsers,
            'monthlyCountsEspecialistas' => $monthlyCountsEspecialistas,
            'totalEspecialistas' => $totalEspecialistas,
            'monthlyCountsClinicas' => $monthlyCountsClinicas,
            'totalClinicas' => $totalClinicas,
            'monthlyCountsQueries' => $monthlyCountsQueries,
            'totalQueries' => $totalQueries,
            'monthlyCountsQueriesSale' => $monthlyCountsQueriesSale,
            'totalSale' => $totalSale,
            'monthlyCountsCancellations' => $monthlyCountsCancellations,
            'totalCancellations' => $totalCancellations
        ]);
    }

    function dashboardClinica()
    {
        $clinica = Clinica::where('usuario_id', '=', Auth::user()->id)->first();
        //retornando todos os especialistas vinculados       
        $especialistas = Especialistaclinica::join('especialistas', 'especialistas.id', '=',
        'especialistaclinicas.especialista_id')->
        where('clinica_id', $clinica->id)->     
        orderBy('especialistas.nome', 'asc')->
        select('especialistas.id', 'especialistas.nome')->get();

        $dataAtual = \Carbon\Carbon::now();
        $mesInicial = $dataAtual->copy()->subMonths(11)->startOfMonth(); // Primeiro mês da janela (12 meses atrás)
        $mesFinal = $dataAtual->endOfMonth(); // Último mês da janela (mês atual)

        // selecionar as consultas na qual o status igual a finalizado
        $TodasConsultasPorMes = Consulta::join('clinicas', 'clinicas.id', '=', 'consultas.clinica_id')
            ->where('consultas.clinica_id', '=', $clinica->id)
            ->where('status', 'Finalizada')
            ->whereBetween('horario_agendado', [$mesInicial, $mesFinal]) // Filtra os últimos 12 meses
            ->selectRaw('YEAR(horario_agendado) as ano, MONTH(horario_agendado) as mes, sum(preco) as preco_total, count(*) as quantidade')
            ->groupByRaw('YEAR(horario_agendado), MONTH(horario_agendado)') // Agrupa por ano e mês
            ->orderByRaw('YEAR(horario_agendado), MONTH(horario_agendado)') // Ordena de forma crescente (de Janeiro a Dezembro)
            ->get();
        return view('userClinica/dashboard', ['lista' => $especialistas, 'TodasConsultasPorMes' => $TodasConsultasPorMes]); 
    }


}
