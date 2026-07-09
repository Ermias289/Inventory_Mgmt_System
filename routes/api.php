<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CategoryController;

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
    
    Route::middleware('auth:api') -> group (function()
    {
        Route::get('/me',
            [AuthController::class, 'me']
        );

        Route::post('/logout',
            [AuthController::class, 'logout']
        );

        Route::post('/refresh',
            [AuthController::class, 'refresh']
        );

        Route::post('/categories',
            [CategoryController::class, 'store']
        )
        ->middleware('permission:categories.create');


    });
});

