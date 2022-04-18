<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CoinController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LuckyWheelController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\XXX;
use App\Models\Character;
use App\Models\CharacterInventories;
use App\Models\CharacterSkinsPrices;
use App\Models\CharacterSkins;
use Illuminate\Http\Request;
use App\Models\CoinInventories;
use App\Models\DefaultCharacters;
use App\Models\DefaultCoins;
use App\Models\CharacterSkinsInventories;
use App\Models\User;
use App\Models\Skins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{    
    public function login(LoginRequest $request){
        
        
        echo 'ok';
    }
    
    public function loginWithGoogle(LoginRequest $request){
              
        $characterId = 1;

     //   $user = User::where('token_google', $request->token_google)->first();

        //Todas as skins disponíveis para o personagem
        /*$skins = CharacterSkins::where('character_id', $characterId)
        ->with('skins')
        ->where('default', 1)
        ->get();

        echo  $skins;
        return;*/
/*
        $price = CharacterSkinsPrices::where('character_skin_id', 7)->get();

        return response()->json([
            "data" => $price,
        ]);
        return;*/
/*  
        //Skins disponíveis para o personagem
        $skins = CharacterSkins::where('character_id', $characterId)->with('skins')->get();
        
        return response()->json([
            "data" => $skins,
        ]);*/

        /*
        //Preço das skins com base em character_skin_id
        $prices = CharacterSkinsPrices::where('character_skin_id', '=', 1)->get();
        echo $prices;
        return;*/
/*
        $character = $user->characters->where('character_id', $characterId)->first();

        if($character === null){
            
            echo 'character null';
            return;
        }

        //pega as skins do inventário com base no id do personagem
        //$skins = $user->skins->where('character_id', $characterId);   
        $skins = CharacterSkinsInventories::where('user_id', $user ->id)
        ->where('character_id', $characterId)
        ->with('skin')
        ->get();

        return response()->json([
            "data" => $skins,
        ]);
        return;*/
       /* $exp = ExperienceController::getLevelExperience(50);   
        $targetLevel = $request->level;
        $targetExperience = 100 *  pow($targetLevel, 2);
        $reverseLevel = floor(sqrt($targetExperience) / 10);

        echo $targetExperience . ' reverse: ' . $reverseLevel;*/


        $user = User::where('token_google', $request->token_google)->first();
        
        if($user === null && $request->nickname === null){

            $params = [];
            $params[] = [
                'field' => 'nickname',
                'code' => 1,
            ];

           return CallbackController::errorCallback(401, $params, 'Login falhou! Você precisa realizar o registro, passe teu nick.');
            //return response()->json(['data' => ['message'=> 'Login falhou! Você precisa realizar o registro, passe teu nick.']], 401);
        }

        if($user == null){
            $user = $this->registerUserWithGoogleToken($request);
        }
        
        Auth::loginUsingId($user->id);
       
        // Creating a token without scopes...
        $token = $user->createToken('TempToken')->accessToken;
        $coins = $user->coins;
        $coins = CoinController::Format($coins);

        $characters = $user->characters;
        /*$char = $characters[0];
        $skins = $char->skins;
        echo $skins;
*/
        return response()->json([
            "userData" => [
                "nickname" => $user->nickname,
                "enable" => $user->enable,
                "tag" => $user->tag,
            ],            
            "token" => $token,
            "coins" => $coins,
            "characters" => $characters,
        ]);
    }

    //registra o usuário com o token do google
    public function registerUserWithGoogleToken($request) : User{
        
        $user = DB::transaction(function() use ($request){
            
            $n_user = User::create($request->all());

            //pega todas as coins default e que estão ativas
            $default_coins = DefaultCoins::where('enabled', 1)->get();

            //Atribui os coins ao usuário
            foreach ($default_coins as $coin){
                CoinInventories::create([
                    'user_id' => $n_user->id,
                    'coin_id' => $coin->id,
                    'amount'  => $coin->amount,
                ]);
            }

            //Localiza todos os personagens defaults
            $default_characters = DefaultCharacters::where('enabled', 1)->get();

            foreach ($default_characters as $character){

                $target_character_id = $character->id;

                //Localiza todas as skins defaults do personagem
                $default_skins = CharacterSkins::where('character_id', $target_character_id)
                ->with('skins')
                ->where('default', 1)
                ->get();

                //Insere o personagem ao inventário do usuário
                CharacterInventories::create([
                    'user_id' => $n_user->id,
                    'character_id' => $target_character_id,
                ]);

                //Insere todas as skins default do personagem ao inventário do usuário
                foreach($default_skins as $skin){

                    //echo $skin;

                    $skinsss = Skins::all();
                    $xxx = $skinsss[0];
                    
                    CharacterSkinsInventories::create([
                        'user_id' => $n_user->id,
                        'character_id' => $target_character_id,
                        'skin_id' => $xxx->id,    
                    ]);
                }                
            }
                        
            return $n_user;
        });
        
        return $user;
    }
}