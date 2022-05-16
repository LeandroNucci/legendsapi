<?php

namespace App\Http\Controllers\Score;

use App\Http\Controllers\Chest\ChestController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersScores;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function endGame(Request $request){
             
        $game_mode = $request->game_mode;

        $data = [];
        $i = 0;

        foreach($request->users as $userInfo){

            $user = User::where('id', $userInfo['user_id'])->first();
            
            if($user === null) {
                $i++;
                continue;
            }

            //Negativa o score do jogador caso o mesmo tenha ficado offline
            if($userInfo['disconnected']){
                $userInfo['score'] = -5;
            }
                     
            //Procura pelo score do usuário
            $score = ScoreController::getScore($user->id, $game_mode);           

            if($score === null){

                $score = UsersScores::create([
                    'user_id' => $user->id,
                    'amount' => $userInfo['score'] < 0 ? 0 : $userInfo['score'],
                    'type' => $game_mode,
                ]);
            }else{

                $amount = $score->amount + $userInfo['score'];

                if($amount < 0){
                    $amount = 0;
                }

                $score->update([

                    'amount' => $amount,
                ]);
            }

            $chest = ChestController::onEndGame($user->id, $i);

            $data[] = [

                'network_id' => $userInfo['network_id'],
                'score' => $score->amount,
                'chest_id' => $chest,
            ];

            $i++;                        
        }

        
        return response()->json($data);
    }

    //Pega o score do usuário com base em seu 'ID' e no 'tipo de jogo'
    public static function getScore($user_id, $game_mode){

        $score = UsersScores::where('user_id', $user_id)
            ->where('type', $game_mode)
            ->first();

        return $score;
    }
}
