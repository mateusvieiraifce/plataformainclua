<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\TagsAnuncio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{

    function  index(){

        $allDestaque = \App\Models\FileAnuncio::join('anuncios','anuncios.id','=','files_anuncios.anuncio_id')
            ->where('files_anuncios.destaque',true)->where('anuncios.ativo',true)->get();
        $allTypes = \App\Models\TipoAnuncio::all();
        $cores = \App\Models\CorAnuncio::all();
        $tags = \App\Models\TagsAnuncio::select(DB::raw("count(id) as n, replace(descricao,' ','') as descricao"))->groupBy('descricao')->orderBy('n')->limit(15)->get();
        $anuncios = \App\Models\Anuncio::where('ativo','=','1')->limit(8)->get();
        $filtro = new Anuncio();
        $filtro->page = 8;
        return view('frente/index',['allDestaque'=>$allDestaque,'allTypes'=>$allTypes,'cores'=>$cores,'tags'=>$tags,'anuncios'=>$anuncios,'filtro'=>$filtro,'preco'=>-1]);
    }

    function  produtos(){

        $allDestaque = \App\Models\FileAnuncio::join('anuncios','anuncios.id','=','files_anuncios.anuncio_id')
            ->where('files_anuncios.destaque',true)->where('anuncios.ativo',true)->get();
        $allTypes = \App\Models\TipoAnuncio::all();
        $cores = \App\Models\CorAnuncio::all();
        $tags = \App\Models\TagsAnuncio::select(DB::raw("count(id) as n, replace(descricao,' ','') as descricao"))->groupBy('descricao')->orderBy('n')->limit(15)->get();
        $anuncios = \App\Models\Anuncio::where('ativo','=','1')->limit(8)->get();
        $filtro = new Anuncio();
        $filtro->page = 8;
        return view('frente/produtos',['allDestaque'=>$allDestaque,'allTypes'=>$allTypes,'cores'=>$cores,'tags'=>$tags,'anuncios'=>$anuncios,'filtro'=>$filtro,'preco'=>-1]);
    }

    function  pesquisa(Request $request){

    }
    function  search(Request $request){

        $inicio = -1;
        $fim = -1;
        $allDestaque = \App\Models\FileAnuncio::join('anuncios','anuncios.id','=','files_anuncios.anuncio_id')
            ->where('files_anuncios.destaque',true)->where('anuncios.ativo',true)->get();
        $allTypes = \App\Models\TipoAnuncio::all();
        $cores = \App\Models\CorAnuncio::all();
        $tags = \App\Models\TagsAnuncio::select(DB::raw("count(id) as n, replace(descricao,' ','') as descricao"))->groupBy('descricao')->orderBy('n')->limit(15)->get();
        $anuncios = \App\Models\Anuncio::where('ativo','=','1');
        $filtro = new Anuncio();

        if ($request->descricao){
            $filtro_str = '%'.$request->descricao.'%';
            $anuncios= $anuncios->where('titulo','like',$filtro_str);
            $filtro->descricao = $request->descricao;
        }
        if ($request->preco){
            if ($request->preco==10){
            $inicio = 0;
            $fim = 10;
            }

            if ($request->preco==50){
                $inicio=10;
                $fim=50;
            }

            if ($request->preco==100){
                $inicio=50;
                $fim=100;
            }
            if ($request->preco==150){
                $inicio=100;
                $fim=150;
            }

            if ($request->preco==160){
                $inicio=150;
                $fim=10000;
            }
            if ($inicio>=0) {
                $anuncios = $anuncios->whereBetween('preco', [$inicio, $fim]);
            }

        }
        if (isset($request->cor)){
            if ($request->cor != -1) {
            $anuncios= $anuncios->where('color_id','=',$request->cor);
            }
        }

        if ($request->tag){
            $anuncios = $anuncios->where('hashtag','like',"%".$request->tag."%");
        }

        $filtro->cor = $request->cor;
        $filtro->tag = $request->tag;
        $filtro->ord = $request->ord;
        $filtro->page = $request->page;

        //$anuncios=$anuncios->orderby('destaque');
        if ($filtro->ord){

            if ($filtro->ord==1){
                $anuncios=$anuncios->orderby('destaque','desc');
            }
            if ($filtro->ord==4){
                $anuncios=$anuncios->orderby('created_at','desc');
            }
            if ($filtro->ord==5){
                $anuncios=$anuncios->orderby('preco','asc');
            }
            if ($filtro->ord==6){
                $anuncios=$anuncios->orderby('preco','desc');
               // dd($anuncios->toSql());
            }

        }

        if (!isset($request->page)){
            $pag = 8;
        }else{
            $pag = $request->page;
        }
        $return = 'frente/index';

        if (isset($request->origem)){
           // dd('aqui');
            $return = "frente/produtos";
        }
        return view($return,['allDestaque'=>$allDestaque,'allTypes'=>$allTypes,'cores'=>$cores,'tags'=>$tags,
            'anuncios'=>$anuncios->limit($pag)->get(), 'filtro'=>$filtro,'preco'=>$fim]);
    }


    //
}
