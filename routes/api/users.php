<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usersController;

Route::middleware(['jwt.auth'])->group(function() {
    Route::get('/users', [usersController::class, 'index']);
});