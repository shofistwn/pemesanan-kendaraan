<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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

Route::controller(AuthController::class)->group(function () {
  Route::get('/', 'loginForm')->name('login')->middleware('guest');
  Route::post('/login', 'login')->name('login.submit');
  Route::get('/logout', 'logout')->name('logout');
});

Route::get('/dashboard', function () {
  $userRole = auth()->user()->role;

  if ($userRole === 'admin') {
    return redirect()->route('admin.index');
  }
})->middleware('auth');

Route::middleware('role:admin')->prefix('admin')->name('admin')->group(function () {
  Route::get('/', [AdminController::class, 'index'])->name('.index');

  Route::prefix('bookings')->name('.bookings')->controller(BookingController::class)->group(function () {
    Route::get('/', 'index')->name('.index');
    Route::get('/search', 'search')->name('.search');
    Route::post('/', 'store')->name('.store');
    Route::get('/create', 'create')->name('.create');
    Route::get('/{booking_id}', 'show')->name('.show');
    Route::get('/{booking_id}/edit', 'edit')->name('.edit');
    Route::post('/{booking_id}/update', 'update')->name('.update');
    Route::get('/{booking_id}/delete', 'delete')->name('.delete');
  });
});