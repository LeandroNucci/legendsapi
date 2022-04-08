<?php

namespace App\Http\Controllers\Skin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\Skins\SkinRequest;
use App\Models\CharacterSkins;
use App\Models\CharacterSkinsPrices;
use Illuminate\Http\Request;

class SkinController extends Controller
{
    //Retorna todas as skins do personagem
    public function getCharacterSkins(SkinRequest $request){
        
        $characterId = $request->character_id;
        
        //Todas as skins disponíveis para o personagem
        $skins = CharacterSkins::where('character_id', $characterId)
        ->with('skins')
        ->get();

        return response()->json([
            "data" => $skins,
        ]);
    }

    //Retorna todos os preços da skin
    public function getSkinPrices(Request $request){

        $skinId = $request->skin_id;
        
        $prices = CharacterSkinsPrices::where('character_skin_id', $skinId)->get();
        return response()->json([
            "data" => $prices,
        ]);
    }

    public function buySkin(Request $request){

        $skinId = $request->skin_id;
        $coinId = $request->coin_id;

        $price = CharacterSkinsPrices::where('character_skin_id', $skinId)
        ->where('coin_id', $coinId)
        ->first();

        if($price === null){
            return response()->json([
                "data" => 'Não foi encontrado o preço',
            ], 401);
        }

        echo $price;
    }
    
}
