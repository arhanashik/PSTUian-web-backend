<?php

use App\Http\Controllers\Backend\AccountOptionController;
use App\Http\Controllers\Backend\DonationsController;
use Illuminate\Support\Facades\Route;

// Donations
Route::apiResource('donations', DonationsController::class)->only(['index', 'update', 'destroy']);

// AccountOption (Bikash, Nagod, Rocket)
Route::apiResource('AccountOptions', AccountOptionController::class)->only(['index', 'store', 'update', 'destroy']);