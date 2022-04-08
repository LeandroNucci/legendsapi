<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoinController extends Controller
{
    //Formata os coins
    public static function Format($inventory){

        $data = [];

        foreach ($inventory as $inventoryElement){

            $data[] = [
                
                'coin_id' => $inventoryElement['pivot']->coin_id,
                'amount' => $inventoryElement['pivot']->amount,
            ];
        }

        return $data;
    }
}
