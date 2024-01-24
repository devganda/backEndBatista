<?php

use App\Http\Controllers\ChurchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


Route::post('/register', [UserController::class, 'create']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/edit/{id}', [UserController::class, 'edit']);
    Route::put('/users/update/{id}', [UserController::class, 'update']);
    Route::delete('/users/delete/{id}', [UserController::class, 'delete']);

    Route::get('/church', [ChurchController::class, 'index']);
    Route::get('/church/edit/{id}', [ChurchController::class, 'edit']);
    Route::post('/church/create', [ChurchController::class, 'create'])
        ->middleware('checkMultiplePermissions:admin,basic');
    Route::put('/church/update/{id}', [ChurchController::class, 'update']);
    Route::delete('/church/delete/{id}', [ChurchController::class, 'delete']);

    Route::get('/members', [MemberController::class, 'index']);
    Route::post('/members/create', [MemberController::class, 'create']);
    Route::get('/members/edit/{id}', [MemberController::class, 'edit']);
    Route::get('/members/show/{id}', [MemberController::class, 'findMembersByChurchID']);
    Route::put('/members/update/{id}', [MemberController::class, 'update']);
    Route::delete('/members/delete/{id}', [MemberController::class, 'delete']);
});



