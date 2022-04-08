<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CallbackController extends Controller
{
    public static function errorCallback($httpCode, $params, $message){
        
        return response()->json([
            
                'message'=> $message, 
                'code' =>   $httpCode,
                'errors' => $params,
            ], $httpCode);
    }
}