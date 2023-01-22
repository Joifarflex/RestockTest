<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperasionalController;
use App\Http\Controllers\SuperadminController;
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
    return view('landing_page');
});

Route::get('register', [RegisterController::class, 'register'])->name('register');
Route::post('register/action', [RegisterController::class, 'actionregister'])->name('actionregister');

Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');

Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::get('operasional', [OperasionalController::class, 'operasional'])->name('operasional')->name('operasional');

Route::resource('operasional', OperasionalController::class);
Route::get('operasional/{id}/edit', [OperasionalController::class, 'edit'])->name('operasional.edit');

Route::get('superadmin', [SuperadminController::class, 'superadmin'])->name('superadmin')->name('superadmin');

Route::resource('superadmin', SuperadminController::class);
Route::get('superadmin/{id}/edit', [SuperadminController::class, 'edit'])->name('superadmin.edit');



