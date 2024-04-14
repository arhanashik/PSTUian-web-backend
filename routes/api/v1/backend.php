<?php

use App\Http\Controllers\Backend\AcademicYearController;
use App\Http\Controllers\Backend\AccountOptionController;
use App\Http\Controllers\Backend\BatchController;
use App\Http\Controllers\Backend\CoursesController;
use App\Http\Controllers\Backend\DonationsController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\FacultyController;
use App\Http\Controllers\Backend\StudentController;
use Illuminate\Support\Facades\Route;

// Donations
Route::apiResource('donations', DonationsController::class)->only(['index', 'update', 'destroy']);
Route::put('donations/confirm/{id}', [DonationsController::class, 'confirm']);
Route::put('donations/unconfirm/{id}', [DonationsController::class, 'unconfirm']);

// Batches
Route::apiResource('batches', BatchController::class);

// AccountOption (Bikash, Nagod, Rocket)
Route::apiResource('account-options', AccountOptionController::class)->only(['index', 'store', 'update', 'destroy']);

// Faculty
Route::apiResource('faculties', FacultyController::class)->only(['index', 'store', 'update', 'destroy']);

// Courses
Route::apiResource('courses', CoursesController::class)->only(['index', 'store', 'update', 'destroy']);

// Students
Route::get('/students/all', [StudentController::class, 'all'])->name('students.all');
Route::apiResource('students', StudentController::class)->only(['index', 'store', 'update', 'destroy', 'show']);


// Employees
Route::apiResource('employees', EmployeeController::class);

// AcademicYear
Route::apiResource('academicyears', AcademicYearController::class)->only(['index', 'store', 'update', 'destroy']);
