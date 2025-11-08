<?php

declare(strict_types=1);

use App\Http\Controllers\API\V1\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(static function() {
    // Auth
    Route::prefix('auth')->controller(AuthController::class)->group(static function() {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout')->middleware(['auth:sanctum']);
    });


    // Promocodes
    Route::middleware(['auth:sanctum'])->prefix('promocodes')->group(static function() {

    });
});
