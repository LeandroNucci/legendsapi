<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\NicknameRequest;
use App\Http\Requests\TagRequest;
use App\Models\DailyGift;
use App\Models\DailyGiftReceives;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

//Script tem como objetivo alterar as configurações do jogador
class UserController extends Controller
{
    //Altera o nickname do jogador
    public function changeNickname(NicknameRequest $request){

        $target_nickname = $request->nickname;

        //Atualiza o nickname do jogador
        auth()->user()->update([
            'nickname' => $target_nickname,
        ]);
        
        return response()->json([            
            'nickname' => auth()->user()->nickname,
        ]);
    }

    //Altera a tag do jogador
    public function changeTag(TagRequest $request){

        $target_tag = $request->tag;

        //Atualiza o nickname do jogador
        auth()->user()->update([
            'tag' => $target_tag,
        ]);
        
        return response()->json([            
            'tag' => auth()->user()->tag,
        ]);
    }

    public function dailyGift(User $user){
        
        //pega o dia atual
        $today = Carbon::now()->format("Y-m-d");
        
        //pega o dia anterior
        $yesterday = Carbon::yesterday()->format("Y-m-d");

        //busca pelo registro da recompensa diária do jogador
        $daily_receive = DailyGiftReceives::where('user_id', $user->id)->where('date', $today)->first();

        if($daily_receive !== null) {
            return false;
        }
        //referencia a recompensa do usuáro
        $target_day_index = 0;

        //busca pelo último registro da recompensa diária do jogador
        $last_receive = DailyGiftReceives::where('user_id', $user->id)->where('date', $yesterday)->first();
                
        //mantém o index em 0 caso o jogador não esteja fazendo sequência de dias
        if($last_receive !== null && $last_receive->date == $yesterday)
            $target_day_index = $last_receive->last_received_index;

        $daily_gift = DailyGift::where('day_index', '>', $target_day_index)->first();
                
        //Caso o jogador já tenha passado por todos os index, o contador reseta
        if($daily_gift === null){
            $daily_gift = DailyGift::all()->first();
        }

        //logica de adicionar diamante no cara        
        //
        ////

        //Adicionar as recompensas ao usuário
        $target_day_index = $last_receive !== null ? ($last_receive->index + 1) : 1;

        DailyGiftReceives::create([
            'user_id'               => $user->id, 
            'last_received_index'   => $target_day_index, 
            'date'                  => $today,
        ]);
    }
}
