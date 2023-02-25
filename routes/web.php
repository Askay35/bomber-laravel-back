<?php

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

Route::middleware('admin.guest')->group(function () {
    Route::view('/login', 'login')->name('loginPage');
    Route::view('/register', 'register')->name('registerPage');

    Route::post('/login', [\App\Http\Controllers\AdminController::class, 'login'])->name('login');
    Route::post('/register', [\App\Http\Controllers\AdminController::class, 'register'])->name('register');

});

Route::middleware('admin.auth')->group(function () {
    Route::get('/logout', [\App\Http\Controllers\AdminController::class, 'logout'])->name('logout');



    Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/users/{id?}', [\App\Http\Controllers\UserController::class, 'index'])->name('users');
    Route::get('/deposites/{user_id?}', [\App\Http\Controllers\DepositeController::class, 'index'])->where('user_id', '[0-9]+')->name('deposites');
    Route::get('/withdraws/{user_id?}', [\App\Http\Controllers\WithdrawController::class, 'index'])->where('user_id', '[0-9]+')->name('withdraws');

    Route::get('/bets/{user_id?}', [\App\Http\Controllers\BetController::class, 'index'])->where('user_id', '[0-9]+')->name('bets');


    Route::prefix('deposite')->group(function () {
        Route::get('/delete/{id}', [\App\Http\Controllers\DepositeController::class, 'delete'])->name('deposite.delete');
        Route::get('/accept/{id}', [\App\Http\Controllers\DepositeController::class, 'accept'])->name('deposite.accept');
        Route::get('/reject/{id}', [\App\Http\Controllers\DepositeController::class, 'reject'])->name('deposite.reject');
    });

    Route::prefix('withdraw')->group(function () {
        Route::get('/delete/{id}', [\App\Http\Controllers\WithdrawController::class, 'delete'])->name('withdraw.delete');
        Route::get('/accept/{id}', [\App\Http\Controllers\WithdrawController::class, 'accept'])->name('withdraw.accept');
        Route::get('/reject/{id}', [\App\Http\Controllers\WithdrawController::class, 'reject'])->name('withdraw.reject');
    });

    Route::prefix('bet')->group(function () {
        Route::get('/delete/{id}', [\App\Http\Controllers\BetController::class, 'delete'])->where('id', '[0-9]+')->name('bet.delete');
    });

    Route::prefix('user')->group(function () {
        Route::post('/delete/{id}', [\App\Http\Controllers\UserController::class, 'adminDelete'])->where('id', '[0-9]+')->name('user.delete');
        Route::post('/edit/{id}', [\App\Http\Controllers\UserController::class, 'adminEdit'])->where('id', '[0-9]+')->name('user.edit');
    });

});
