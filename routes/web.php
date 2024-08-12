<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [TaskController::class, 'index']);

Route::get('/show', [TaskController::class, 'show']);

Route::post('/tasks', [TaskController::class, 'store']);

Route::patch('/tasks/{id}/status', [TaskController::class, 'update']);

Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);