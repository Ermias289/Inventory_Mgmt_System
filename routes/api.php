<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\StockController;

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

        Route::get('/categories',
            [CategoryController::class, 'index']
        )
        ->middleware('permission:categories.view');

        Route::get('/categories/{category}',
            [CategoryController::class, 'show']
        )
        ->middleware('permission:categories.view');

        Route::put('/categories/{category}',
            [CategoryController::class, 'update']
        )
        ->middleware('permission:categories.update');

        Route::delete('/categories/{category}',
            [CategoryController::class, 'destroy']
        )
        ->middleware('permission:categories.delete');

        Route::post('/products/{product}/images', 
            [ProductController::class, 'uploadImages']
        );

        Route::post('/products',
            [ProductController::class, 'store']
        )-> middleware('permission:products.create');

        Route::get('/products', 
            [ProductController::class, 'index']
        )->middleware('permission:products.view');

        Route::get('/products/{product}',
            [ProductController::class, 'show']
        )->middleware('permission:products.view');

        Route::put('/products/{product}',
            [ProductController::class, 'update']
        )->middleware('permission:products.update');

        Route::delete('/products/{product}', 
            [ProductController::class, 'destroy']
        )->middleware('permission:products.delete');

        Route::delete('/products/{product}/images/{media}',
            [ProductController::class, 'deleteImages']
        );

        Route::post(
            '/products/{product}/stock/in',
            [StockController::class, 'increase']
        );

        Route::post(
            '/products/{product}/stock/out',
            [StockController::class, 'decrease']
        );
    });
});

