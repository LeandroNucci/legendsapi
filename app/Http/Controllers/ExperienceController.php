<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    //retorna a experiencia necessária para atigir determinado level
    public static function getLevelExperience($targetLevel){
        $previusLevel = $targetLevel -1;
        $targetExperience = ((50 * (pow($previusLevel, 3))) - (150 * (pow($previusLevel, 2))) + (400 * $previusLevel)) /3;
        return $targetExperience;
    }



}
