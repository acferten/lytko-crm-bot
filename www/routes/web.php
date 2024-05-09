<?php

use App\Http\Web\Controllers\Auth\LoginController;
use App\Http\Web\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'getForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::resource('orders', OrderController::class);
