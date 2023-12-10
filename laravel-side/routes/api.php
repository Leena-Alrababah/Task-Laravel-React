<?php

use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/allUsers', [UserController::class, 'getAllUsers']);
Route::get('/allUsers/{id}', [UserController::class, 'getUser']);
Route::post('/addUser', [UserController::class, 'addUser']);
Route::put('/updateUser/{id}', [UserController::class, 'updateUser']);
Route::delete('/destroyUser/{id}', [UserController::class , 'destroyUser']);
