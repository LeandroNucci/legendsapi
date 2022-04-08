<?php

use App\Http\Controllers\Login\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/loginWithGoogle', [AuthController::class, 'loginWithGoogle']);