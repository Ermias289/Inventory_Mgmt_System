<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;

Route::get('/test', function(){
    return response()->json(['message' => 'API is working']);
});

Route::prefix('v1') -> group (function(){
    Route::post('/register', 
        [AuthController::class, 'register']
    );

    Route::post('/login', 
        [AuthController::class, 'login']
    );

});
