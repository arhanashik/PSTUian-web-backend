<?php

use App\Http\Controllers\Backend\FacultyController;
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

// AccountOption (Bikash, Nagod, Rocket)
Route::apiResource('account-options', AccountOptionController::class)->only(['index']);

// Faculty
Route::apiResource('faculties', FacultyController::class)->only(['index']);
Route::get('/faculties/{id}', [FacultyController::class, 'showFacultyById'])->name('faculties.showFacultyById');