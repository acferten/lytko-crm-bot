<?php

use App\Http\Web\Controllers\Auth\LoginController;
use App\Http\Web\Controllers\Order\OrderController;
use App\Http\Web\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'getForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('recover-password', function (){})->name('recover-password');

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::resource('orders', OrderController::class);

    Route::resource('users', UserController::class);

    Route::get('/', [OrderController::class, 'index']);

});
