<?php

use App\Http\Controllers\ChurchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

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

Route::get('/church', [ChurchController::class, 'index']);
Route::get('/church/edit/{id}', [ChurchController::class, 'edit']);
Route::post('/church/create', [ChurchController::class, 'create']);
Route::put('/church/update/{id}', [ChurchController::class, 'update']);
Route::delete('/church/delete/{id}', [ChurchController::class, 'delete']);

Route::get('/members', [MemberController::class, 'index']);
Route::post('/members/create', [MemberController::class, 'create']);
Route::get('/members/edit/{id}', [MemberController::class, 'edit']);
Route::put('/members/update/{id}', [MemberController::class, 'update']);
Route::delete('/members/delete/{id}', [MemberController::class, 'delete']);

