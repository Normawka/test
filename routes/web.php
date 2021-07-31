<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CompanyController;
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
Route::redirect('/', '/login');


Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']],function () {
    Route::resource('company',CompanyController::class);
    Route::resource('employees',EmployeeController::class);

});
