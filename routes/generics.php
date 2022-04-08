<?php

use App\Http\Controllers\Generics\LuckyWheelController;
use App\Http\Controllers\Generics\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/luckywheel', [LuckyWheelController::class, 'getLuckyWheels']);
Route::get('/news', [NewsController::class, 'getNews']);