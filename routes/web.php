<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\AdminController;
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

Route::prefix('admin')->name('admin')->group(function () {
  Route::get('/', [AdminController::class, 'index'])->name('.index');

  Route::prefix('bookings')->name('.bookings')->controller(BookingController::class)->group(function () {
    Route::get('/', 'index')->name('.index');
    Route::get('/create', 'create')->name('.create');
    Route::get('/show', 'show')->name('.show');
    Route::get('/edit', 'edit')->name('.edit');
  });
});

Route::get('/', function () {
  return view('pages.auth.login');
});