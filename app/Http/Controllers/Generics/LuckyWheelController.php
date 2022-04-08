<?php

namespace App\Http\Controllers\Generics;

use App\Http\Controllers\Controller;
use App\Models\LuckyWheels;
use Illuminate\Http\Request;

class LuckyWheelController extends Controller
{
    //Retorna todas as wheels ativas
    public static function getLuckyWheels(){
        $wheels = LuckyWheels::where('enabled', 1)->get();
        return $wheels;
    }
}
