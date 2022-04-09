<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Generics\NewsController;
use App\Models\GameVersions;
use Illuminate\Http\Request;

//Script tem como função retornar todos os itens relacionado ao patch
class PatcherController extends Controller
{
    public function getPatcher(Request $request){
        
        //retorna a versão mais atualizada do jogo
        $gameSettings = GameVersions::orderBy('version', 'DESC')->first();

        //retorna todas as notícias com base idioma do jogador
        $news = NewsController::getNews($request);

        return response()->json([
            'version' => $gameSettings->version ?? 0,
            'news' => $news,
        ]);
    }
}
