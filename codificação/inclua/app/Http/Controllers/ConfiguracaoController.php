<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        $configuracao = Configuracao::first();

        return view('configuracao.layout', ['configuracao' => $configuracao]);
    }

    public function store(Request $request)
    {
        try {
            /* SALVANDO A LOGO */
            if ($request->hasFile('image_logo') && $request->file('image_logo')->isValid()) {
                //VERIFICANDO SE EXISTE ALGUMA LOGO JA CADASTRADO PARA DELETAR
                $configuracao = Configuracao::find($request->configuracao_id);
                if(!empty($configuracao->logo)) {
                    //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
                    $linkStorage = explode('/', $configuracao->logo);
                    $linkStorage = "$linkStorage[1]/$linkStorage[2]";
                    Storage::delete([$linkStorage]);
                }

                // Nome do Arquivo
                $requestImage = $request->image_logo;
                // Recupera a extensão do arquivo
                $extension = $requestImage->extension();
                // Define o nome
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                // Faz o upload:
                $pathLogo = $request->file('image_logo')->storeAs('imagens-configuracao', $imageName);
            }

            /* SALVANDO O ICONE SIDEBAR */
            if ($request->hasFile('image_icon') && $request->file('image_icon')->isValid()) {
                //VERIFICANDO SE EXISTE ALGUM ICONE JA CADASTRADO PARA DELETAR
                $configuracao = Configuracao::find($request->configuracao_id);
                if(!empty($configuracao->icon)) {
                    //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
                    $linkStorage = explode('/', $configuracao->icon);
                    $linkStorage = "$linkStorage[1]/$linkStorage[2]";
                    Storage::delete([$linkStorage]);
                }

                // Nome do Arquivo
                $requestImage = $request->image_icon;
                // Recupera a extensão do arquivo
                $extension = $requestImage->extension();
                // Define o nome
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                // Faz o upload:
                $pathIcon = $request->file('image_icon')->storeAs('imagens-configuracao', $imageName);
            }
            
            /* SALVANDO  O FAVICON */
            if ($request->hasFile('image_favicon') && $request->file('image_favicon')->isValid()) {
                //VERIFICANDO SE EXISTE ALGUM FAVICON JA CADASTRADO PARA DELETAR
                $configuracao = Configuracao::find($request->configuracao_id);
                if(!empty($configuracao->favicon)) {
                    //REMOÇÃO DE 'storage/' PARA DELETAR O ARQUIVO NA RAIZ
                    $linkStorage = explode('/', $configuracao->favicon);
                    $linkStorage = "$linkStorage[1]/$linkStorage[2]";
                    Storage::delete([$linkStorage]);
                }

                // Nome do Arquivo
                $requestImage = $request->image_favicon;
                // Recupera a extensão do arquivo
                $extension = $requestImage->extension();
                // Define o nome
                $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;
                // Faz o upload:
                $pathFavicon = $request->file('image_favicon')->storeAs('imagens-configuracao', $imageName);
            }

            if ($request->configuracao_id) {
                $configuracao = Configuracao::find($request->configuracao_id);
            } else {
                $configuracao = new Configuracao();                
            }

            $configuracao->color_primary = $request->color_primary;
            $configuracao->color_gradiente = $request->color_gradiente;
            $configuracao->logo = !empty($pathLogo) ? "storage/$pathLogo" : $configuracao->logo;
            $configuracao->icon = !empty($pathIcon) ? "storage/$pathIcon" : $configuracao->icon;
            $configuracao->favicon = !empty($pathFavicon) ? "storage/$pathFavicon" : $configuracao->favicon;
            $configuracao->save();

            session()->flash('msg', ['valor' => trans("As alterações foram salvas com sucesso!"), 'tipo' => 'success']);
        } catch (QueryException $e) {
            dd($e);
            session()->flash('msg', ['valor' => trans("Houve um erro ao salvar as alterações, tente novamente."), 'tipo' => 'danger']);
        }

        return back();
    }
}
