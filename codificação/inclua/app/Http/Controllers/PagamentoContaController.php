<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\PagamentoConta;
use Carbon\Carbon;

class PagamentoContaController extends Controller
{
    public function list(Request $request) {
        $user_id = auth()->user()->id;
        
        $inicioDoDiaFiltro = Carbon::parse($request->inicio_data)->startOfDay();
        $fimDoDiaFiltro = Carbon::parse($request->final_data)->endOfDay();
        
        // Define query das condicionais if e else if
        $query = PagamentoConta::where('user_id', '=', $user_id)->where('descricao', 'like', '%' . $request->descconta . '%')->whereBetween('created_at', [$inicioDoDiaFiltro, $fimDoDiaFiltro])->orderBy('created_at', 'desc');

        if ($request->status == "todas") {
            $contas_a_pagar = $query->get();
        } else if ($request->status){
            $contas_a_pagar = $query->where('status', '=', $request->status)->get();
        } else {
            $contas_a_pagar = PagamentoConta::where('user_id', '=', $user_id)
                                              ->orderBy('created_at', 'desc')
                                              ->get();
        }
        return view('userClinica.financeiro.list', ['contas_a_pagar' => $contas_a_pagar,
                                                    'status_selecionado' => $request->status,
                                                    'inicio_data' => $request->inicio_data,
                                                    'final_data' => $request->final_data,
                                                    'descconta' => $request->descconta,
                                                   ]);
    }

    public function edit($id) { 
        $user_id = auth()->user()->id;
        $conta = PagamentoConta::find($id);
        return view('userClinica.financeiro.edit_conta_pagar', [
            'conta' => $conta, 
            'user_id' => $user_id,
        ]);
    }

    public function update(Request $request, $id) {
        $input = $request->validate([
            'user_id' => 'required',
            'descricao' => 'required|string', 
            'valor' => 'required|string',
            'vencimento' => 'required',
            'status' => 'required|string',
        ]);
        $conta = PagamentoConta::find($id);
        $conta->fill($input);
        $conta->save();

        return Redirect::route('clinica.financeiro');
    }

    public function create() {
        $user_id = auth()->user()->id;
        return view('userClinica.financeiro.add_conta_pagar', ['user_id' => $user_id]);
    }

    public function store(Request $request) {
        $input = $request->validate([
            'user_id' => 'required',
            'descricao' => 'required|string', 
            'valor' => 'required|string',
            'vencimento' => 'required',
            'status' => 'required|string',
        ]);
        PagamentoConta::create($input);

        return Redirect::route('clinica.financeiro');
    }

    public function destroy($id) {
        $conta = PagamentoConta::find($id);
        $conta->delete();

        return Redirect::route('clinica.financeiro');
    }
}
