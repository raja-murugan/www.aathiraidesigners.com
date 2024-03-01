<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PayoffController;
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
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/home/datefilter', [App\Http\Controllers\HomeController::class, 'datefilter'])->name('home.datefilter');
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
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/employee/view/{unique_key}', [EmployeeController::class, 'view'])->name('employee.view');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/employee/datefilter', [EmployeeController::class, 'datefilter'])->name('employee.datefilter');
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
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/attendance/departmentwisefilter', [AttendanceController::class, 'departmentwisefilter'])->name('attendance.departmentwisefilter');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/attendance/dateupdate/{date}', [AttendanceController::class, 'dateupdate'])->name('attendance.dateupdate');
 });


 // ADMIN ATTENDANCE CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/admin_attendance', [AttendanceController::class, 'admin_index'])->name('admin_attendance.admin_index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/admin_attendance/admin_checkinstore', [AttendanceController::class, 'admin_checkinstore'])->name('admin_attendance.admin_checkinstore');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/admin_attendance/admin_checkoutstore', [AttendanceController::class, 'admin_checkoutstore'])->name('admin_attendance.admin_checkoutstore');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/admin_attendance/admin_edit/{attendance_id}', [AttendanceController::class, 'admin_edit'])->name('admin_attendance.admin_edit');
    // LEAVE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/admin_attendance/admin_leaveupdate/{id}', [AttendanceController::class, 'admin_leaveupdate'])->name('admin_attendance.admin_leaveupdate');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/admin_attendance/admin_datefilter', [AttendanceController::class, 'admin_datefilter'])->name('admin_attendance.admin_datefilter');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/admin_attendance/admin_departmentwisefilter', [AttendanceController::class, 'admin_departmentwisefilter'])->name('admin_attendance.admin_departmentwisefilter');
 });

 // DEPARTMENT CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/department', [DepartmentController::class, 'index'])->name('department.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/department/store', [DepartmentController::class, 'store'])->name('department.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/department/edit/{unique_key}', [DepartmentController::class, 'edit'])->name('department.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/department/delete/{unique_key}', [DepartmentController::class, 'delete'])->name('department.delete');
 });


  // CUSTOMER CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/customer', [CustomerController::class, 'index'])->name('customer.index');
    // CREATE
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/customer/create', [CustomerController::class, 'create'])->name('customer.create');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/customer/store', [CustomerController::class, 'store'])->name('customer.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/customer/edit/{unique_key}', [CustomerController::class, 'edit'])->name('customer.edit');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/customer/update/{unique_key}', [CustomerController::class, 'update'])->name('customer.update');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/customer/delete/{unique_key}', [CustomerController::class, 'delete'])->name('customer.delete');
    // CHECK DUPLICATE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/customer/checkduplicate', [CustomerController::class, 'checkduplicate'])->name('customer.checkduplicate');
});

// PRODUCT CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/product', [ProductController::class, 'index'])->name('product.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/product/store', [ProductController::class, 'store'])->name('product.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/product/edit/{unique_key}', [ProductController::class, 'edit'])->name('product.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/product/delete/{unique_key}', [ProductController::class, 'delete'])->name('product.delete');
    // CHECK DUPLICATE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/product/checkduplicate', [ProductController::class, 'checkduplicate'])->name('product.checkduplicate');
    // CHECK DUPLICATE
});


 // BILLING CONTROLLER
 Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/billing', [BillingController::class, 'index'])->name('billing.index');
    // CREATE
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/billing/create', [BillingController::class, 'create'])->name('billing.create');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/billing/store', [BillingController::class, 'store'])->name('billing.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/billing/edit/{unique_key}', [BillingController::class, 'edit'])->name('billing.edit');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/billing/update/{unique_key}', [BillingController::class, 'update'])->name('billing.update');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/billing/delete/{unique_key}', [BillingController::class, 'delete'])->name('billing.delete');
    // DATEFILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/billing/datefilter', [BillingController::class, 'datefilter'])->name('billing.datefilter');
    // PAY BALANCE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/billing/paybalance/{id}', [BillingController::class, 'paybalance'])->name('billing.paybalance');
    // UPDATE DELIVERY STATUS
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/billing/updatedelivery/{unique_key}', [BillingController::class, 'updatedelivery'])->name('billing.updatedelivery');
});


// INCOME CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/income', [IncomeController::class, 'index'])->name('income.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/income/store', [IncomeController::class, 'store'])->name('income.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/income/edit/{unique_key}', [IncomeController::class, 'edit'])->name('income.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/income/delete/{unique_key}', [IncomeController::class, 'delete'])->name('income.delete');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/income/datefilter', [IncomeController::class, 'datefilter'])->name('income.datefilter');
 });


 
// EXPENSE CONTROLLER
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/expense', [ExpenseController::class, 'index'])->name('expense.index');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/expense/store', [ExpenseController::class, 'store'])->name('expense.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/expense/edit/{unique_key}', [ExpenseController::class, 'edit'])->name('expense.edit');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/expense/delete/{unique_key}', [ExpenseController::class, 'delete'])->name('expense.delete');
    // DATAE FILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/expense/datefilter', [ExpenseController::class, 'datefilter'])->name('expense.datefilter');
 });


 // PAYOFF CONTROLLER
 Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // INDEX
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/payoff', [PayoffController::class, 'index'])->name('payoff.index');
    // CREATE
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/payoff/create', [PayoffController::class, 'create'])->name('payoff.create');
    // STORE
    Route::middleware(['auth:sanctum', 'verified'])->post('/zworktechtechnology/payoff/store', [PayoffController::class, 'store'])->name('payoff.store');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->get('/zworktechtechnology/payoff/edit/{id}/{month}/{year}', [PayoffController::class, 'edit'])->name('payoff.edit');
    // EDIT
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/payoff/update/{id}/{month}/{year}', [PayoffController::class, 'update'])->name('payoff.update');
    // DELETE
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/payoff/delete/{unique_key}', [PayoffController::class, 'delete'])->name('payoff.delete');
    // DATEFILTER
    Route::middleware(['auth:sanctum', 'verified'])->put('/zworktechtechnology/payoff/datefilter', [PayoffController::class, 'datefilter'])->name('payoff.datefilter');
});



Route::get('getproducts/', [ProductController::class, 'getproducts']);

Route::get('/getcustomerwiseproducts', [CustomerController::class, 'getcustomerwiseproducts']);
Route::get('/getmeasurementforproduct', [CustomerController::class, 'getmeasurementforproduct']);
Route::get('/gettotal_salary', [PayoffController::class, 'gettotal_salary']);
Route::get('/getEmployeePayoffs', [PayoffController::class, 'getEmployeePayoffs']);
