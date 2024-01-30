<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // DASHBOARD
    Route::middleware(['auth:sanctum', 'verified'])->get('/home', [HomeController::class, 'index'])->name('home');

    // DASHBOARD FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktech-anandtraders/home/datefilter', [App\Http\Controllers\HomeController::class, 'datefilter'])->name('home.datefilter');
});



// EMPLOYEE CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/employee', [EmployeeController::class, 'index'])->name('employee.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/employee/store', [EmployeeController::class, 'store'])->name('employee.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/employee/edit/{unique_key}', [EmployeeController::class, 'edit'])->name('employee.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/employee/delete/{unique_key}', [EmployeeController::class, 'delete'])->name('employee.delete');
    // CHECK DUPLICATE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/employee/checkduplicate', [EmployeeController::class, 'checkduplicate'])->name('employee.checkduplicate');
 });

// ATTENDANCE CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/attendance/checkinstore', [AttendanceController::class, 'checkinstore'])->name('attendance.checkinstore');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/attendance/checkoutstore', [AttendanceController::class, 'checkoutstore'])->name('attendance.checkoutstore');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/attendance/edit/{attendance_id}', [AttendanceController::class, 'edit'])->name('attendance.edit');
    // LEAVE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/attendance/leaveupdate/{id}', [AttendanceController::class, 'leaveupdate'])->name('attendance.leaveupdate');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/attendance/datefilter', [AttendanceController::class, 'datefilter'])->name('attendance.datefilter');
 });
