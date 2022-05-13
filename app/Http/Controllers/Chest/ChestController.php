<?php

namespace App\Http\Controllers\Chest;

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FormatController;
use App\Http\Controllers\LegendsMath;
use App\Models\Character;
use App\Models\CharacterCardsInventories;
use App\Models\Chests;
use App\Models\ChestsInventories;
use App\Models\ChestsLootCards;
use App\Models\ChestsLootCoins;
use App\Models\CoinInventories;
use App\Models\Coins;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChestController extends Controller
{
    //Initializa o cronometro do chest
    public function initializeChest(Request $request){

        $chestInventory = ChestsInventories::where('user_id', auth()->user()->id)
        ->where('code', $request->code)
        ->with('chest')
        ->first();

        //Verifica se o báu existe
        if($chestInventory === null){

            $params[] = [
                'field' => 'chest',
                'code' => 3,
            ];

           return CallbackController::errorCallback(401, $params, 'Báu não encontrado');
        }

        if($chestInventory !== null && $chestInventory->open_at !== null){

            $params[] = [
                'field' => 'chest',
                'code' => 4,
            ];

           return CallbackController::errorCallback(401, $params, 'Báu já está aberto');
        }

        $now = Carbon::now();
        $chestInventory->update([
            'open_at' => $now,
        ]);

        $chests = $this->listChests();
        return response()->json($chests);

    }

    ///retorna uma caixa com base no score do jogador
    public static function getChest($index){

        if($index >= 2){
            $chest = Chests::where('rarity_id', 1)->first();   
            return $chest;
        }

        $probability = $index == 0 ? 50 : 25;
        $golden_chest = rand(1, 100) <= $probability;
        $chest_index = $golden_chest == 1 ? 2 : 1;

        $chest = Chests::where('rarity_id', $chest_index)->first(); 
        return $chest;  


    }

    public static function onEndGame($user_id, $index){
        
        //$target_chest = 1;
        //$chest = Chests::where('rarity_id', $target_chest)->first();   
        $chest = ChestController::getChest($index);
        $chestInventories = ChestsInventories::where('user_id', $user_id)->get();

        //Verifica se o número máximo de báus já foi atingido
        if(count($chestInventories) >= 3){
            
            $params[] = [
                'field' => 'chest',
                'code' => 2,
            ];

           return 0;
        }

        //Cria um código randomico para o baú
        $randomCode = Str::random(6);

        $element = DB::transaction(function() use ($user_id, $chest, $randomCode)
        {
            //Insere o baú no banco de dados
            $inventory_chest = ChestsInventories::create([
                'user_id' => $user_id,
                'chest_id' => $chest->id,
                'boosts' => 0,
                'code' => $randomCode,
            ]);

            return $inventory_chest->chest_id;
        });        

        return $element;
    }

    //Insere um novo chest no inventário do usuário
    public function insertChest(Request $request){

        $chest = Chests::where('rarity_id', $request->chest_id)->first();   

        //Verifica se o báu existe
        if($chest === null){

            $params[] = [
                'field' => 'chest',
                'code' => 1,
            ];

           return CallbackController::errorCallback(401, $params, 'Báu não encontrado');
        }

        $chestInventories = ChestsInventories::where('user_id', auth()->user()->id)->get();

        //Verifica se o número máximo de báus já foi atingido
        if(count($chestInventories) >= 3){
            
            $params[] = [
                'field' => 'chest',
                'code' => 2,
            ];

           return CallbackController::errorCallback(401, $params, 'Número máximo de baús atingido');
        }

        //Cria um código randomico para o baú
        $randomCode = Str::random(6);

        //Pega a hora atual
        $now = Carbon::now();

        DB::transaction(function() use ($chest, $randomCode)
        {
            //Insere o baú no banco de dados
            ChestsInventories::create([
                'user_id' => auth()->user()->id,
                'chest_id' => $chest->id,
                'boosts' => 0,
                'code' => $randomCode,
            ]);
        });        

        //Pega todos os báus do usuário e retorna
        $chestInventories = ChestsInventories::where('user_id', auth()->user()->id)
        ->with('chest')
        ->get();

        $chests = $this->listChests();

        return response()->json($chests);
    }

    //Retorna todos os baús do usuário
    public function listChests(){
        
        //Pega todos os báus do usuário e retorna
        $chestInventories = ChestsInventories::where('user_id', auth()->user()->id)
        ->with('chest')
        ->get();

        $data = [];

        foreach($chestInventories as $element){
           
            //$created = $element->created_at;
            
            //Progresso do baú
            $progress = 1;

            //Tempo base para abrir
            $timeToOpen = $element->chest->minutes;

            $minutesLeft = $element->chest->minutes;
            //Referencia os segundos
            $seconds = 0;

            //Pega a hora atual
            $now = Carbon::now();

            //Caso já tenha aberto
            if($element->open_at !== null){
                
                $baseTime = $element->open_at;

                //Calcula os boots de tempo do jogador
                $minutesToIncrease= $element->chest->minutes - ($element->boosts * 30);

                //Calcula a quantidade de tempo que já passou
                $timeToOpen = $baseTime->addMinutes($minutesToIncrease);

                $minutesLeft = $now->diffInMinutes($timeToOpen);
                
                //Verifica se o baú já pode ser aberto
                $timeFinished = $now->gt($timeToOpen);

                if($timeFinished){
                    $progress = 3;

                }else {                                
                    $progress = 2;

                    //Pega os segundos restantes do minuto atual
                    $seconds = $now->diff($timeToOpen)->format('%S');
                }
            }                     
            
            $data[] = [
                'chest_id' => $element->chest->id,
                'time_left' => $progress == 3 ? 0 : $minutesLeft,
                'seconds' => (int)$seconds,
                'code' => $element->code,
                'progress' => $progress,
            ];
        }
        
        return $data;
    }

    public function openChest(Request $request){
                   
        $chestInventory = ChestsInventories::where('user_id', auth()->user()->id)
        ->where('code', $request->code)
        ->with('chest')
        ->first();

        //Verifica se o báu existe
        if($chestInventory === null){

            $params[] = [
                'field' => 'chest',
                'code' => 3,
            ];

           return CallbackController::errorCallback(401, $params, 'Báu não encontrado');
        }

        $lootCards = $this->getLootCards($chestInventory->chest);
        $lootCoins = $this->getLootCoins($chestInventory->chest);

        //Efetiva a inserção de cards
        $inventory = DB::transaction((function() use ($lootCards, $lootCoins){


            //Insere o loot no inventário do usuário
            foreach ($lootCards as $loot){

                //procura pelo registro do item no inventário
                $card_inventory = auth()->user()->cards()
                ->where('id', $loot['id'])
                ->first();        
                
                if($card_inventory == null){
                    CharacterCardsInventories::create([
                        'user_id' => auth()->user()->id,
                        //'character_id' => $loot['character']->id,
                        'character_id' => $loot['id'],
                        'amount' => $loot['amount'],
                    ]);
                }else{
                    $card_inventory->pivot->update([
                        'amount' => $card_inventory->pivot->amount + $loot['amount'],
                    ]);  
                }
            }            

            //Insere os coins ao usuário
            foreach($lootCoins as $loot){

                $coin_inventory = auth()->user()->coins()
                ->where('id', $loot['id'])
                ->first();
                
              if($coin_inventory == null){

                    CoinInventories::create([
                        'user_id' => auth()->user()->id,
                        'coin_id' => $loot['id'],
                        'amount' => $loot['amount'],
                    ]);

                }else{
                    $coin_inventory->pivot->update([
                        'amount' => $coin_inventory->pivot->amount + $loot['amount'],
                    ]);
                }
            }

            $data = [];
            return $data; 
        }));
        

        $coins = FormatController::FormatCoins(auth()->user()->coins);
        $cards = FormatController::FormatCards(auth()->user()->cards);

        //deleta o baú
        //$chestInventory->delete();
        return response()->json([
            'loot_cards' => $lootCards,
            'loot_coins' => $lootCoins,
            'inventory_cards' => $cards,
            'inventory_coins' => $coins,
        ]);
        
    }
   
    //Retorna a premiação do tipo 'card'
    private function getLootCards(Chests $chest){

        $chest_rarity_id = $chest->rarity_id;
             
        $chestLoots = ChestsLootCards::where('chest_id', $chest->id)->get();
        
        $data = [];
        
        //16,2,4
        foreach ($chestLoots as $loot){
            
            //Verifica se o jogador receberá o loot
            $hasLoot = rand(1, 100);
            $hasLoot = $hasLoot <= $loot->probability;
            
            if($hasLoot == null){
                continue;
            }

            //Sorteia o número de recompensas que o baú dará
            $number_of_characters_that_will_receive_prize = rand($loot->min_different_drop, $loot->max_different_drop);

            $randomPrizes = LegendsMath::GetRandomColumns(
                rand($loot->min_drop, $loot->max_drop),
                2,
                $number_of_characters_that_will_receive_prize
            );

            //Pega os personagens compatíveis com a premiação
            $characters = Character::select('id')->where('character_rarity_id', $loot->character_rarity_id)->pluck('id');
            //$characters = Character::where('character_rarity_id', $loot->character_rarity_id)->get();
            
            //Sorteia os personagens que receberão as recompensas
            $sortCharacters = LegendsMath::GetRandomArrayElements(3, $characters);

            //Formata os prêmios
            for($i = 0; $i < count($randomPrizes); $i++){
                
                $data[] = [
                    'id' => $sortCharacters[$i],
                    'amount' => $randomPrizes[$i],
                ];
            }            
        }

        return $data;
    }

     //Retorna a premiação do tipo 'coin'
     private function getLootCoins(Chests $chest){

        $loots = ChestsLootCoins::where('chest_id', $chest->id)->get();
        
        $data = [];

        foreach ($loots as $loot){

            //Verifica se o jogador receberá o loot
            $hasLoot = rand(1, 100);
            $hasLoot = $hasLoot <= $loot->probability;
            
            if($hasLoot == null){
                continue;
            }

            $amount = rand($loot->min_drop, $loot->max_drop);
            $data[] = [
                'id' => $loot->coin_id,
                'amount' => $amount,
            ];

        }

        return $data;
    }
}
