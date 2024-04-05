<?php

use App\Http\Controllers\Backend\AccountOptionController;
use App\Http\Controllers\Backend\CoursesController;
use App\Http\Controllers\Backend\DonationsController;
use App\Http\Controllers\Backend\BatchController;
use App\Http\Controllers\Backend\FacultyController;
use App\Http\Controllers\Backend\SessionController;
use App\Http\Controllers\Backend\StudentController;
use Illuminate\Support\Facades\Route;

// Donations
Route::apiResource('donations', DonationsController::class)->only(['index', 'update', 'destroy']);
// Batches
Route::apiResource('batches', BatchController::class)->only(['index', 'show', 'store', 'update', 'destroy']);

// AccountOption (Bikash, Nagod, Rocket)
Route::apiResource('account-options', AccountOptionController::class)->only(['index', 'store', 'update', 'destroy']);

// Faculty
Route::apiResource('faculties', FacultyController::class)->only(['index', 'store', 'update', 'destroy']);

// Courses
Route::apiResource('courses', CoursesController::class)->only(['index', 'store', 'update', 'destroy']);

// Students
Route::apiResource('students', StudentController::class)->only(['index', 'store', 'update', 'destroy']);
Route::get('/students/all', [StudentController::class, 'all'])->name('students.all');

// Sessions
Route::apiResource('sessions', SessionController::class)->only(['index', 'store', 'update', 'destroy']);
