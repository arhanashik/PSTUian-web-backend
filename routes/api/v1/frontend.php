<?php

use App\Http\Controllers\Frontend\AccountOptionController;
use App\Http\Controllers\Frontend\DonationsController;
use App\Http\Controllers\Frontend\PingPongController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', [PingPongController::class, 'index']);
Route::apiResource('donations', DonationsController::class)->only(['index', 'store']);
Route::apiResource('accountoptions', AccountOptionController::class)->only(['index']);
