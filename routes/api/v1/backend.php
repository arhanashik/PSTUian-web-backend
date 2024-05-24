<?php

use App\Http\Controllers\Backend\AcademicYearController;
use App\Http\Controllers\Backend\AccountOptionController;
use App\Http\Controllers\Backend\BatchController;
use App\Http\Controllers\Backend\BloodDonationController;
use App\Http\Controllers\Backend\BloodDonationRequestController;
use App\Http\Controllers\Backend\CoursesController;
use App\Http\Controllers\Backend\DonationsController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\Backend\FacultyController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Backend\TeacherController;
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
Route::patch('/students/{id}', [StudentController::class, 'patch']);
Route::get('/students/all', [StudentController::class, 'all'])->name('students.all');
Route::apiResource('students', StudentController::class)->only(['index', 'store', 'update', 'destroy', 'show']);


// Teachers
Route::patch('/teachers/{id}', [TeacherController::class, 'patch']);
Route::get('/teachers/all', [TeacherController::class, 'all'])->name('teachers.all');
Route::apiResource('teachers', TeacherController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

// Employees
Route::apiResource('employees', EmployeeController::class);

// AcademicYear
Route::apiResource('academicyears', AcademicYearController::class)->only(['index', 'store', 'update', 'destroy']);

// Blood donation request
Route::apiResource('bloodrequests', BloodDonationRequestController::class)->only(['index','show', 'store', 'update', 'destroy']);
Route::GET('bloodrequests/confirm/{id}', [BloodDonationRequestController::class, 'ChangeConfirmation']);

// Blood donation
Route::apiResource('blooddonations', BloodDonationController::class)->only(['index','show', 'store','destroy']);

