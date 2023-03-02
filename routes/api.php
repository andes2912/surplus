<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function() {
    Route::prefix('category')->group(function() {
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/','index');
            Route::post('/','store');
            Route::get('/{id}','show');
            Route::put('/{id}','update');
            Route::delete('/{id}','destroy');
         });
    });
});
