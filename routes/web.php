<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CompanyController;
use \App\Mail\MyMail;
use \App\Http\Controllers\Auth\LoginController;
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

    Route::get('ajax-crud-datatable', [CompanyController::class, 'index']);
    Route::post('store-company', [CompanyController::class, 'store']);
    Route::post('edit-company', [CompanyController::class, 'edit']);
    Route::post('delete-company', [CompanyController::class, 'destroy']);

    Route::get('ajax-crud-datatable-employee', [EmployeeController::class, 'index']);
    Route::post('store-employee', [EmployeeController::class, 'store']);
    Route::post('edit-employee', [EmployeeController::class, 'edit']);
    Route::post('delete-employee', [EmployeeController::class, 'destroy']);

    Route::get('send-mail',[MyMail::class,'myMail']);
  //  Route::get('logout',[LoginController::class, 'logout']);
});



