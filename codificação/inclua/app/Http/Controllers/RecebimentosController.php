<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Consulta;
use App\Models\Especialista;
use App\Models\Recebimento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecebimentosController extends Controller
{
    public function home()
    {

        $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
     //   dd($especialista);

        $lastRecep = Recebimento::where('especialista_id', '=', $especialista->id)->whereNotNull('pagamento')->orderBy('fim','DESC')->first();

        $inicio = Carbon::now()->subYear(2)->startOfDay();

        if ($lastRecep != null) {
            $data = Carbon::parse($lastRecep->fim);
            $inicio = $data->endOfDay();
        }

        $fimDoDiaFiltro = Carbon::now()->subDays(1)->endOfDay();

       // dd($inicio, $fimDoDiaFiltro);
        $consultasBase = Consulta::whereBetween('horario_agendado', [$inicio, $fimDoDiaFiltro])
            ->where('isPago',true)->where('especialista_id',$especialista->id)->where('status','Finalizada');

        //dd($consultasBase->toSql());

        $Numero = $consultasBase->count();

        $consultasPIX  = Consulta::whereBetween('horario_agendado', [$inicio, $fimDoDiaFiltro])
            ->where('isPago',true)->where('especialista_id',$especialista->id)->where('status','Finalizada')->where('forma_pagamento', "Pix");
        $totalPix = $consultasPIX->sum("preco");


        $consultasEspecie  = Consulta::whereBetween('horario_agendado', [$inicio, $fimDoDiaFiltro])
            ->where('isPago',true)->where('especialista_id',$especialista->id)->where('status','Finalizada')->where('forma_pagamento', "Éspecie");
        $totalEspecie = $consultasEspecie->sum("preco");

        $consultasCartao  = Consulta::whereBetween('horario_agendado', [$inicio, $fimDoDiaFiltro])
            ->where('isPago',true)->where('especialista_id',$especialista->id)->where('status','Finalizada')->where('forma_pagamento', "Cartão");
        $totalCartao = $consultasCartao->sum("preco");


        //$totalCartao = $consultasBase->whereRaw('LOWER(forma_pagamento) = ?', ["Cartão"])->sum('preco');
        $totalMaquininha = $consultasBase->whereRaw('LOWER(forma_pagamento) = ?', ["Maquininha"])->sum('preco');

        $porcentagemClinica = env("COMICAO_CLINICA");
        $porcentagemInclua = env("COMICAO_INCLUA");
        $taxaMaquina  = env("TAXA_MAQUINETA");
        $liquidoMaquina = $totalMaquininha-($totalMaquininha *$taxaMaquina);
        $liquidoCartao = $totalCartao-($totalCartao *$taxaMaquina);

        $commissaoIncluaPix = $totalPix*$porcentagemInclua;
        $commissaoIncluaEspecie = $totalEspecie*$porcentagemInclua;
        $commissaoIncluaMaquineta = $liquidoMaquina * $porcentagemInclua;
        $comissaoSistema = $liquidoCartao * $porcentagemInclua;
       // dd($commissaoIncluaPix, $commissaoIncluaEspecie, $commissaoIncluaMaquineta, $comissaoSistema  );
        $comissaoInclua = $commissaoIncluaMaquineta + $commissaoIncluaPix + $commissaoIncluaEspecie+$comissaoSistema;

        $comissaoClinicaPix = $totalPix*$porcentagemClinica;
        $comissaoClinicaEspecie = $totalEspecie*$porcentagemClinica;
        $comissaoClinicaMaquineta = $liquidoMaquina * $porcentagemClinica;
        $comissaoClinicaSistema = $liquidoCartao * $porcentagemClinica;

        $commissaoClinica = $comissaoClinicaEspecie+$comissaoClinicaMaquineta+$comissaoClinicaPix+$comissaoClinicaSistema;

        $saldo=  $totalPix +$totalCartao + $totalMaquininha + $totalEspecie - $commissaoClinica - $comissaoInclua;
        $recebimentos = Recebimento::where("especialista_id",$especialista->id)->paginate(12);

        return view('userEspecialista.recebimentos.listtodasconsultas', ['pageSlug' => 'recebimentos',
            'numero'=>$Numero,
            'pix'=>$totalPix,
            'especie'=>$totalEspecie,
            'cartao'=>$totalCartao,
            'maquina'=>$totalMaquininha,
            'inicio'=>$inicio,
            "fim"=>$fimDoDiaFiltro,
            "filtro"=>$especialista->nome,
            "comissaoClinica"=>$commissaoClinica,
            "comissaoInclua"=>$comissaoInclua,
            "saldo"=>$saldo,
            "lista"=>$recebimentos
            ]);
    }

    public function criar_solicitacao(Request $request){

        try{

            $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
            $lastRecep = Recebimento::where('especialista_id', '=', $especialista->id)->orderBy('fim','DESC')->first();
            if ($lastRecep != null) {
                session()->flash('msg', ['valor' => trans("Há uma solicitação em aberto, aguarda a finalização!"), 'tipo' => 'danger']);
                return redirect(route('especialista.recebeimentos.list'));
            }

            $solicitacao =  new Recebimento();
            $solicitacao->inicio = $request->inicio_data;
            $solicitacao->fim = $request->final_data;
            $solicitacao->total_consultas_pix = Helper::converterMonetario($request->pix);
            $solicitacao->total_consultas_especie = Helper::converterMonetario($request->especie);
            $solicitacao->total_consultas_maquininha = Helper::converterMonetario($request->maquina);
            $solicitacao->numero_consultas = Helper::converterMonetario($request->numero);
            $solicitacao->total_consultas_credito = Helper::converterMonetario($request->cartao);
            $solicitacao->taxa_clinica = Helper::converterMonetario($request->comissao_clinica);
            $solicitacao->taxa_inclua = Helper::converterMonetario($request->comissao_inclua);
            $solicitacao->taxa_cartao = env("TAXA_MAQUINETA");
            $solicitacao->vencimento = Helper::getDataDiasUteis();
            $solicitacao->especialista_id= $especialista->id;

            if ($solicitacao->total_consultas_credito>$solicitacao->taxa_inclua){
                $solicitacao->saldo = $solicitacao->total_consultas_credito-$solicitacao->taxa_inclua;
                $solicitacao->status = "A Receber do Inclua ". ($solicitacao->saldo );
            } else{

                $solicitacao->saldo = $solicitacao->taxa_inclua-$solicitacao->total_consultas_credito;
                $solicitacao->status = "A Pagar do Inclua ". ($solicitacao->saldo );
            }
            $solicitacao->save();
            session()->flash('msg', ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success']);
            Helper::sendEmail("Validar a solicitação de Pagamento " . $solicitacao->id,"Validar a solicitação de Pagamento : ". $solicitacao->id ,env("EMAIL_ROOT"));
            }catch (\Exception $e){
               # dd($e->getMessage());
                session()->flash('msg', ['valor' => trans("Houve um erro ao realizar o cadastro, tente novamente!"), 'tipo' => 'danger']);
            }
        return redirect(route('especialista.recebeimentos.list'));

    }
    //
}
