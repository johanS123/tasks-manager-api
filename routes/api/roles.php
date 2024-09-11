<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\rolesController;

Route::middleware(['jwt.auth', 'role:1,3'])->group(function () {
    Route::get('/roles', [rolesController::class, 'index']);
    Route::post('/roles', [rolesController::class, 'store']);
    Route::put('/roles/{id}', [rolesController::class, 'update']);
    Route::patch('/roles/{id}', [rolesController::class, 'updatePartial']);
    Route::delete('/roles/{id}', [rolesController::class, 'destroy']);
});