<?php

use Illuminate\Support\Facades\Route;
use Modules\Services\Http\Controllers\ServiceController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('services', ServiceController::class)->names('services');
});
