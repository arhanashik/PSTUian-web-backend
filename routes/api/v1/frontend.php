<?php

use App\Http\Controllers\Frontend\DonationsController;
use App\Http\Controllers\Frontend\PingPongController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', [PingPongController::class, 'index']);

// Donations
Route::get('/donations', [DonationsController::class, 'index']);
