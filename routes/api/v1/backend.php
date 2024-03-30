<?php

use App\Http\Controllers\Backend\DonationsController;
use Illuminate\Support\Facades\Route;

// Donations
Route::apiResource('donations', DonationsController::class)->only(['index', 'update', 'destroy']);