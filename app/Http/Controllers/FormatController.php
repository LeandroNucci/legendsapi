<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormatController extends Controller
{
    //Formata os coins
    public static function FormatCoins($inventory){

        $data = [];

        foreach ($inventory as $inventoryElement){

            $data[] = [
                
                'id' => $inventoryElement['pivot']->coin_id,
                'amount' => $inventoryElement['pivot']->amount,
            ];
        }

        return $data;
    }

    public static function FormatCards($inventory){

        $data = [];

        foreach ($inventory as $inventoryElement){

            $data[] = [
                
                'id' => $inventoryElement['pivot']->character_id,
                'amount' => $inventoryElement['pivot']->amount,
            ];
        }

        return $data;
    }
}
