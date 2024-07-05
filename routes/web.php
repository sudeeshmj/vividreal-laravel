<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
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

Route::get('/home', [HomeController::class, 'index'])->name('admin.dashboard');
Route::resource('companies', CompanyController::class)->names([
    'index' => 'companies.index',
    'create' => 'companies.create',
    'store' => 'companies.store',
    'show' => 'companies.show',
    'edit' => 'companies.edit',
    'update' => 'companies.update',
    'destroy' => 'companies.destroy',
]);
Route::resource('employees', EmployeeController::class)->names([
    'index' => 'employees.index',
    'create' => 'employees.create',
    'store' => 'employees.store',
    'show' => 'employees.show',
    'edit' => 'employees.edit',
    'update' => 'employees.update',
    'destroy' => 'employees.destroy',
]);
