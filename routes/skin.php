<?php

use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\Skin\SkinController;
use Illuminate\Support\Facades\Route;

Route::get('/getCharacterSkins', [SkinController::class, 'getCharacterSkins']);
Route::get('/getCharacterSkinPrice', [SkinController::class, 'getSkinPrices']);
Route::post('/buyCharacterSkin', [SkinController::class, 'buySkin']);