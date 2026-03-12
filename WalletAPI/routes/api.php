<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/wallets', [WalletController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/wallets', [WalletController::class, 'index']);
    Route::get('/wallets/{id}', [WalletController::class, 'show']);
    Route::post('/wallets/{id}/deposit',[TransactionController::class,'deposit']);
    Route::post('/wallets/{id}/withdraw',[TransactionController::class,'withdraw']);


    
});
