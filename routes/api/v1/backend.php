<?php

use App\Http\Controllers\Backend\AccountOptionController;
use App\Http\Controllers\Backend\DonationsController;
use App\Http\Controllers\Backend\BatchController;
use Illuminate\Support\Facades\Route;

// Donations
Route::apiResource('donations', DonationsController::class)->only(['index', 'update', 'destroy']);
// Batches
Route::apiResource('batches', BatchController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

// AccountOption (Bikash, Nagod, Rocket)
Route::apiResource('account-options', AccountOptionController::class)->only(['index', 'store', 'update', 'destroy']);
