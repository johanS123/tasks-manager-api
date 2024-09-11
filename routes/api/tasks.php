<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\tasksController;

Route::middleware(['jwt.auth', 'role:1,3'])->group(function () {
    Route::get('/tasks', [tasksController::class, 'index']);
    Route::get('/tasks/search', [tasksController::class, 'search']);
    Route::post('/tasks', [tasksController::class, 'store']);
    Route::put('/tasks/{id}', [tasksController::class, 'update']);
    Route::patch('/tasks/{id}', [tasksController::class, 'updatePartial']);
    Route::delete('/tasks/{id}', [tasksController::class, 'destroy']);
});