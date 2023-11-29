<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('/todos', [TodoController::class, 'index']);
    Route::post('/todo/create', [TodoController::class, 'create']); // Fixed: added forward slash
    Route::get('/todo/{id}', [TodoController::class, 'show']);
    Route::put('/todo/{id}/update', [TodoController::class, 'update']);
    Route::delete('/todo/{id}/delete', [TodoController::class, 'destroy']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthCOntroller::class, 'login']);
