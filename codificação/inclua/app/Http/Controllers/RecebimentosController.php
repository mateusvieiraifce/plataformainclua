<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Clinica;
use App\Models\Consulta;
use App\Models\Especialista;
use App\Models\Recebimento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecebimentosController extends Controller
{

    public function calculaRecebimento($especialista, $clinicaId=null)
    {

        $lastRecep = Recebimento::where('especialista_id', '=', $especialista->id)->where("clinica_id","=",$clinicaId)->whereNotNull('pagamento')->orderBy('fim','DESC')->first();

        $inicio = Carbon::now()->subYear(2)->startOfDay();

        if ($lastRecep != null) {
            $data = Carbon::parse($lastRecep->fim);
            $inicio = $data->endOfDay();
        }

        $fimDoDiaFiltro = Carbon::now()->subDays(1)->endOfDay();

        // dd($inicio, $fimDoDiaFiltro);
        $consultasBase = Consulta::whereBetween('horario_agendado', [$inicio, $fimDoDiaFiltro])
            ->where('isPago',true)->where('especialista_id',$especialista->id)->where("clinica_id","=",$clinicaId)->where('status','Finalizada');

        //dd($consultasBase->toSql());

        $Numero = $consultasBase->count();


        $consultasPIX  = Consulta::whereBetween('horario_agendado', [$inicio, $fimDoDiaFiltro])
            ->where('isPago',true)->where('especialista_id',$especialista->id)->where("clinica_id","=",$clinicaId)->where('status','Finalizada')->where('forma_pagamento', "Pix");
        $totalPix = $consultasPIX->sum("preco");


        $consultasEspecie  = Consulta::whereBetween('horario_agendado', [$inicio, $fimDoDiaFiltro])
            ->where('isPago',true)->whereNull('id_usuario_cancelou')->where('especialista_id',$especialista->id)->where("clinica_id","=",$clinicaId)->where('status','Finalizada')->where('forma_pagamento', "Éspecie");
        $totalEspecie = $consultasEspecie->sum('preco');
       // dd($totalEspecie);

        $consultasCartao  = Consulta::whereBetween('horario_agendado', [$inicio, $fimDoDiaFiltro])
            ->where('isPago',true)->whereNull('id_usuario_cancelou')->where('especialista_id',$especialista->id)->where("clinica_id","=",$clinicaId)->where('status','Finalizada')->where('forma_pagamento', "Cartão");
        $totalCartao = $consultasCartao->sum("preco");


        //$totalCartao = $consultasBase->whereRaw('LOWER(forma_pagamento) = ?', ["Cartão"])->sum('preco');
        $totalMaquininha = $consultasBase->whereNull('id_usuario_cancelou')->where("clinica_id","=",$clinicaId)->whereRaw('LOWER(forma_pagamento) = ?', ["Maquininha"])->sum('preco');

        $porcentagemClinica = env("COMICAO_CLINICA");
        $porcentagemInclua = env("COMICAO_INCLUA");
        $taxaMaquina  = 1 - env("TAXA_MAQUINETA");
        $liquidoMaquina = $totalMaquininha*($taxaMaquina);
        $liquidoCartao = $totalCartao*$taxaMaquina;
        //dd($liquidoCartao,$liquidoMaquina);

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

        $recebimento = new Recebimento();
        $recebimento->inicio =  $inicio;
        $recebimento->fim = $fimDoDiaFiltro;
        $recebimento->numero_consultas = $Numero;
        $recebimento->total_consultas_pix = $totalPix;
        $recebimento->total_consultas_especie = $totalEspecie;
        $recebimento->total_consultas_maquininha=$totalMaquininha;
        $recebimento->total_consultas_credito=$totalCartao;
        $recebimento->especialista_id = $especialista->id;
        $recebimento->taxa_inclua = $comissaoInclua;
        $recebimento->taxa_cartao = $taxaMaquina;
        $recebimento->taxa_clinica = $commissaoClinica;
        $recebimento->saldo = $saldo;
        return $recebimento;
    }

    public function home($id_especialista=null, $clinicaId=null)
    {


        if ($id_especialista) {
            $especialista = Especialista::where('id', '=',$id_especialista)->first();
        }else {
            $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
        }

        $selecionado = null;
        $clinicasAssociado = Clinica::join("especialistaclinicas","clinicas.id","=","clinica_id")->where("especialistaclinicas.especialista_id","=",$especialista->id)
            ->OrderBy("clinicas.id","asc")->get();
      //  dd($clinicasAssociado);
        if ($clinicasAssociado->count() > 0) {
            $selecionado = $clinicasAssociado[0]->clinica_id;
        }
        if ($clinicaId){
            $selecionado = $clinicaId;
        }
       // dd($clinicasAssociado);
     //   dd($especialista);

        if (!$especialista){
            session()->flash('msg', ['valor' => trans("Especialista não encontrado!"), 'tipo' => 'danger']);
          return redirect(route('home'));
        }
        $recebimentos =  $this->calculaRecebimento($especialista, $selecionado);

        $recebimentosList = Recebimento::join("especialistas","especialistas.id","=","especialista_id")->where("clinica_id","=",$selecionado)-> where("especialista_id",$especialista->id)->paginate(12);


        return view('userEspecialista.recebimentos.listtodasconsultas', ['pageSlug' => 'recebimentos',
            'numero'=>$recebimentos->numero_consultas,
            'pix'=>$recebimentos->total_consultas_pix,
            'especie'=>$recebimentos->total_consultas_especie,
            'cartao'=>$recebimentos->total_consultas_credito,
            'maquina'=>$recebimentos->total_consultas_maquininha,
            'inicio'=>$recebimentos->inicio,
            "fim"=>$recebimentos->fim,
            "filtro"=>$especialista->nome,
            "comissaoClinica"=>$recebimentos->taxa_clinica,
            "comissaoInclua"=>$recebimentos->taxa_inclua,
            "saldo"=>$recebimentos->saldo,
            "lista"=>$recebimentosList,
            "clinicas"=>$clinicasAssociado,
            "clinicaselecionada_id"=>$selecionado,
            "especialista_id"=>$especialista->id
            ]);
    }

    public function criar_solicitacao(Request $request){

        try{

            $clinica_id = $request->clinica_id;
           // dd();
            $especialista = Especialista::where('usuario_id', '=', Auth::user()->id)->first();
            $lastRecep = Recebimento::where('especialista_id', '=', $especialista->id)->where("clinica_id","=",$clinica_id)->orderBy('fim','DESC')->first();
            if ($lastRecep != null) {
                session()->flash('msg', ['valor' => trans("Há uma solicitação em aberto, aguarda a finalização!"), 'tipo' => 'danger']);
                return redirect(route('especialista.recebeimentos.list'));
            }

            $solicitacao = $this->calculaRecebimento($especialista,$clinica_id);

            $solicitacao->vencimento = Helper::getDataDiasUteis();
            $solicitacao->especialista_id= $especialista->id;
            $solicitacao->clinica_id = $clinica_id;
            $consultaCreditoLiquido =$solicitacao->total_consultas_credito * $solicitacao->taxa_cartao;
            //dd($consultaCreditoLiquido);
            if ($consultaCreditoLiquido>$solicitacao->taxa_inclua){
                $incluaSaldo  =  $consultaCreditoLiquido-$solicitacao->taxa_inclua;
                $solicitacao->status = "A Receber do Inclua ". (Helper::padronizaMonetario( $incluaSaldo ));
            } else{

                $solicitacao->saldo = $consultaCreditoLiquido-$solicitacao->taxa_inclua;
                $solicitacao->status = "A Pagar ao Inclua ". Helper::padronizaMonetario($solicitacao->saldo*-1 );
            }
            $solicitacao->save();
            session()->flash('msg', ['valor' => trans("Operação realizada com sucesso!"), 'tipo' => 'success']);
            if (env("PRODUCAO")) {
               // dd("aqui");
                Helper::sendEmail("Validar a solicitação de Pagamento " . $solicitacao->id,"Validar a solicitação de Pagamento : ". $solicitacao->id ,env("EMAIL_ROOT"));
            }
            }catch (\Exception $e){
               # dd($e->getMessage());
                session()->flash('msg', ['valor' => trans("Houve um erro ao realizar o cadastro, tente novamente!"), 'tipo' => 'danger']);
            }
            $urlRoute = route('especialista.recebeimentos.list') ."/".$especialista->id."/".$clinica_id;
           // dd($urlRoute);
            return redirect($urlRoute);

    }
    //
}
