<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\PagamentoConta;

class PagamentoContaController extends Controller
{
    public function list() {
        $user_id = auth()->user()->id;
        $contas_a_pagar = PagamentoConta::where('user_id', '=', $user_id)->get();
        return view('userClinica.financeiro.list', ['contas_a_pagar' => $contas_a_pagar]);
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
