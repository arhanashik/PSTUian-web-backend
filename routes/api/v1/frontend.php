<?php

use App\Http\Controllers\Frontend\AccountOptionController;
use App\Http\Controllers\Frontend\DonationsController;
use App\Http\Controllers\Frontend\PingPongController;
use App\Http\Controllers\Frontend\BatchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', [PingPongController::class, 'index']);
Route::apiResource('donations', DonationsController::class)->only(['index', 'store']);

// Batches
Route::apiResource('batches', BatchController::class)->only(['index', 'show']);

// AccountOption (Bikash, Nagod, Rocket)
Route::apiResource('account-options', AccountOptionController::class)->only(['index']);
