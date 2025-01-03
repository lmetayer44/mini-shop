<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// ----------------------
// 1) Les routes ouvertes 
// ----------------------
Route::post('/login', [AuthController::class, 'login'])->name('login');

// ---------------------------------
// 2) Les routes protégées par JWT (BackOffice)
// ---------------------------------
Route::group(['middleware' => 'auth:api'], function () {
  // AUTH
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::get('/me', [AuthController::class, 'me']);
  Route::get('/refresh', [AuthController::class, 'refresh']);

  // COMMANDE
  Route::get('/orders', [OrderController::class, 'index']);
  Route::post('/orders', [OrderController::class, 'store']);
  Route::get('/orders/{id}', [OrderController::class, 'show']);
  Route::put('/orders/{id}', [OrderController::class, 'update']);
  Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
});

// ------------------------------------------
// 3) Les routes protégées par un token URL (Bon de Commande)
// ------------------------------------------
Route::group(['middleware' => 'url.token'], function () {

  Route::get('/commande/{id}', [OrderController::class, 'showPublic'])
    ->name('commande.public');
});
