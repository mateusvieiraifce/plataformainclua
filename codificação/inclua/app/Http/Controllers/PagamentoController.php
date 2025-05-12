<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Assinatura;
use App\Models\Cartao;
use App\Models\Consulta;
use App\Models\Pagamento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    public function store($user_id, $valor, $transaction_code, $status, $servico, $cartao_cadastrado = true)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataLocal = Carbon::now();
        try {
            $assinaturaController = new AssinaturaController();
            $assinatura = $assinaturaController->getAssinatura($user_id);

            $pagamento = new Pagamento();
            $pagamento->user_id = $user_id;
            $pagamento->cartao_id = ($cartao_cadastrado ? $assinatura->cartao_id : null);
            $pagamento->assinatura_id = $assinatura->id ?? null;
            $pagamento->valor = Helper::converterMonetario($valor);
            $pagamento->transaction_code = $transaction_code;
            $pagamento->data_pagamento = $dataLocal;
            $pagamento->status = $status;
            $pagamento->servico = $servico;
            $pagamento->save();
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }

            return $pagamento->id;
    }

    public function update($transaction_code, $status)
    {
        date_default_timezone_set('America/Sao_Paulo');
        $dataLocal = Carbon::now();

        try {
            $pagamento = Pagamento::where('transaction_code', $transaction_code)->first();
            $pagamento->data_pagamento = $dataLocal;
            $pagamento->status = $status;
            $pagamento->save();
        } catch (QueryException $e) {
            $msg = ['valor' => trans("Erro ao executar a operação!"), 'tipo' => 'danger'];
            session()->flash('msg', $msg);
        }
    }

    public function historicoPagamentosPaciente()
    {
        $user = Auth::user();
        $pagamentos = Pagamento::leftJoin('consultas', 'consultas.pagamento_id', 'pagamentos.id')
            ->where('user_id', $user->id)
            ->select('pagamentos.*', 'consultas.forma_pagamento')
            ->orderBy('data_pagamento', 'desc')
            ->paginate(2, ['*'], 'page_payments');

        $assinaturaController = new AssinaturaController();
        $assinatura = $assinaturaController->getAssinatura($user->id);

        $cartaoController = new CartaoController();
        $cartoes = $cartaoController->getCartoes($user->id, 2);
        
        return view('userPaciente.financeiro.lista', ['user' => $user, 'pagamentos' => $pagamentos, 'assinatura' => $assinatura, 'cartoes' => $cartoes]);
    }
    
    public function historicoPagamentosPacientes()
    {
        $pagamentos = Pagamento::orderBy('data_pagamento', 'desc')->paginate(4, ['*'], 'page_payments');
       
        $assinaturas = Assinatura::paginate(4, ['*'], 'page_signature');

        return view('user_root.pacientes.financeiro', ['pagamentos' => $pagamentos, 'assinaturas' => $assinaturas]);
    }
    
    public function pagarConsulta(Request $request)
    {
        $consulta = Consulta::find($request->consulta_id);
        $usuario = User::join('pacientes', 'pacientes.usuario_id', 'users.id')
            ->where('pacientes.id', $consulta->paciente_id)
            ->select('users.*')
            ->first();
        $userLogged = Auth::user();

        $cartao = Cartao::join('assinaturas', 'assinaturas.cartao_id', 'cartoes.id')
            ->where('cartoes.user_id', $usuario->id)
            ->select('cartoes.*')
            ->first();

        if ($request->metodo_pagamento == "null") {
            session()->flash('msg',  ['valor' => trans("Selecione a forma de pagamento com o cartão."), 'tipo' => 'danger']);
            
            return back();
        }

        if($request->metodo_pagamento == "Cartão") {
            //VERIFICAR SE O PACIENTE DA CONSULTA POSSUI UM CARTÃO CADASTRADO
            if (!$cartao) {
                session()->flash('msg',  ['valor' => trans("O paciente não possui um cartão cadastrado na plataforma."), 'tipo' => 'danger']);

                return back();
            }
            
            //CRIAR O CHECKOUT
            $checkout = Helper::createCheckoutSumupConsulta($consulta->preco);
            //PASSAR O ID DA CUNSULTA E MOTIVO DE CANCELAMENTO
            session()->put("consulta_id_$checkout->id", $consulta->id);
            //CRIAR O PAGAMENTO
            $pagamento = Helper::createPagamento($cartao, $checkout);
            

            if (isset($pagamento->status) && $pagamento->status == "FAILED") {
                $this->store($cartao->user_id, floatval(Helper::converterMonetario($consulta->preco)), $pagamento->transactions[0]->transaction_code, 'Negado', 'Pagamento da consulta');

                return redirect()->route('callback.pagamento.consulta', ['checkout_id' => $pagamento->id]);
            } elseif (isset($pagamento->status) && $pagamento->status == "PAID") {
                $this->store($cartao->user_id, floatval(Helper::converterMonetario($consulta->preco)), $pagamento->transactions[0]->transaction_code, 'Aprovado', 'Pagamento da consulta');

                return redirect()->route('callback.pagamento.consulta', ['checkout_id' => $pagamento->id]);
            } elseif (isset($pagamento->next_step)) {
                $this->store($cartao->user_id, floatval(Helper::converterMonetario($consulta->preco)), $pagamento->next_step->current_transaction->transaction_code, 'Pendente', 'Pagamento da consulta');

                return redirect($pagamento->next_step->url);
            }            
        } else {
            try {
                $pagamento_id = $this->store($usuario->id, floatval(Helper::converterMonetario($consulta->preco)), $request->numero_autorizacao, 'Aprovado', 'Pagamento da consulta', false);

                $consulta->isPago = true;
                $consulta->forma_pagamento = $request->metodo_pagamento;
                $consulta->pagamento_id = $pagamento_id;
                $consulta->save();
                
                session()->flash('msg', ['valor' => trans("O pagamento da consulta foi realizado com sucesso!"), 'tipo' => 'success']);
            } catch (QueryException $e) {
                session()->flash('msg', ['valor' => trans("Houve um erro ao realizar o pagamento da consulta, tente novamente."), 'tipo' => 'danger']);
            }

            if ($userLogged->tipo_user == "C") {
                return redirect()->route('consulta.agendaConsultas', ['clinica_id' => $consulta->clinica_id]);
            } elseif ($userLogged->tipo_user == "E") {
                return redirect()->route('consulta.listconsultaporespecialista');
            }
        }
    }
    
    public function callbackPagamentoConsulta(Request $request)
    {      
        $response = Helper::getCheckout($request->checkout_id);
      
        $consultaId = session()->get("consulta_id_$request->checkout_id");
        
        session()->forget("consulta_id_$request->checkout_id");
        //ver a questao financeira
        $consulta = Consulta::find($consultaId);
        $userLogged = Auth::user();

        if ($response->status == 'FAILED') {
            $this->update($response->transactions[0]->transaction_code, 'Negado');
            session()->flash('msg', ['valor' => trans("Não foi possível realizar o pagamento da consulta, tente novamente."), 'tipo' => 'danger']);

            if ($userLogged->tipo_user == "C") {
                return redirect()->route('consulta.listconsultaporespecialista');
            } elseif ($userLogged->tipo_user == "E") {
                return redirect()->route('consulta.listconsultaporespecialista');
            }
        } elseif ($response->status == 'PAID') {
            try {
                $consulta->isPago = true;
                $consulta->forma_pagamento = 'Cartão';
                $consulta->save();
                
                $this->update($response->transactions[0]->transaction_code, 'Aprovado');
                session()->flash('msg', ['valor' => trans("O pagamento da consulta foi realizado com sucesso!"), 'tipo' => 'success']);
            } catch (QueryException $e) {
                session()->flash('msg', ['valor' => trans("Houve um erro ao realizar o pagamento da consulta, tente novamente."), 'tipo' => 'danger']);
            }
            
            if ($userLogged->tipo_user == "C") {
                return redirect()->route('consulta.agendaConsultas', ['clinica_id' => $consulta->clinica_id]);
            } elseif ($userLogged->tipo_user == "E") {
                return redirect()->route('consulta.listconsultaporespecialista');
            }
        }
    }
}
