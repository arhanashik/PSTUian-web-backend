<?php

use App\Http\Controllers\Backend\AccountOptionController;
use App\Http\Controllers\Backend\DonationsController;
use App\Http\Controllers\Backend\FacultyController;
use Illuminate\Support\Facades\Route;

// Donations
Route::apiResource('donations', DonationsController::class)->only(['index', 'update', 'destroy']);

// AccountOption (Bikash, Nagod, Rocket)
Route::apiResource('account-options', AccountOptionController::class)->only(['index', 'store', 'update', 'destroy']);

// Faculty
Route::apiResource('faculties', FacultyController::class)->only(['index', 'store', 'update', 'destroy']);