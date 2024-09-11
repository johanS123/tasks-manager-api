<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// usuarios
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// las rutas de tasks
require base_path('routes/api/tasks.php');

// las rutas de users
require base_path('routes/api/users.php');

// las rutas de roles
require base_path('routes/api/roles.php');

// Route::get('/users', [usersController::class, 'index']);
// Route::get('/users/{id}', [usersController::class, 'show']);
// Route::post('/users', [usersController::class, 'store']);
// Route::put('/users/{id}', [usersController::class, 'update']);
// Route::patch('/users/{id}', [usersController::class, 'updatePartial']);
// Route::delete('/users/{id}', [usersController::class, 'destroy']); // cambia el estado isActive a false






// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
