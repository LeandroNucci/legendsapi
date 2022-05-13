<?php

use App\Http\Controllers\Chest\ChestController;
use Illuminate\Support\Facades\Route;

Route::post('/openChest', [ChestController::class, 'openChest']);
Route::post('/insertChest', [ChestController::class, 'insertChest']);
Route::get('/listChests', [ChestController::class, 'listChests']);
Route::post('/initializeChest', [ChestController::class, 'initializeChest']);