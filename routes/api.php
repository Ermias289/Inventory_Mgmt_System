<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Api\v1\Controllers\AuthController;

Route::prefix('v1') -> group (fucntion(){
    Route::post('/register', 
        [AuthController::class, 'register']
    );

    Route::post('/login', 
        [AuthController::class, 'login']
    );

});
