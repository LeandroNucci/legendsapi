<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegendsMath extends Controller
{
    //Cria um array com determinado número de colunas ($totalColumns) e distribui o ($amount) de forma randomica entre elas
    public static function GetRandomColumns($amount, $increaseRate, $totalColumns){
        
        $remaining = $amount;

        $data = [];

        for($i = 0; $i < $totalColumns; $i++){
            $data[$i] = 1;
            $remaining--;
        }

        while ($remaining > 0){

            $i = array_rand($data);
            $n = $remaining > $increaseRate ? rand(0, $increaseRate) : $remaining;
            $data[$i] += $n;
            $remaining -= $n;
        }

        return $data;
    }

    public static function GetRandomArrayElements($totalColumns, $elements){
        
        $data = [];

        while(count($data) < $totalColumns){
            $r = rand(0, count($elements)-1);
            $n = $elements[$r];

            if(!in_array($n, $data)){
                $data[] = $n;
            }
        }

        return $data;
    }

    
}
