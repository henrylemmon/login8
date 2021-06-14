<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\User\ProfilesController;


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
    return view('index');
});

Route::prefix('user')->name('user.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('profile', ProfilesController::class)->name('profile');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'auth.isAdmin', 'verified'])->group(function () {
    Route::resource('/users', UsersController::class);
});
