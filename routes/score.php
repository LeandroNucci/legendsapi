<?php

use App\Http\Controllers\Generics\LuckyWheelController;
use App\Http\Controllers\Generics\NewsController;
use App\Http\Controllers\PatcherController;
use App\Http\Controllers\Score\ScoreController;
use Illuminate\Support\Facades\Route;

//Route::get('/luckywheel', [LuckyWheelController::class, 'getLuckyWheels']);
Route::post('/endGame', [ScoreController::class, 'endGame']);
