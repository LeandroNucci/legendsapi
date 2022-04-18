<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/changeNickname', [UserController::class, 'changeNickname']);
Route::post('/changeTag', [UserController::class, 'changeTag']);