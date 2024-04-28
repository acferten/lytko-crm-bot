<?php

use App\Http\Web\Controllers\Order\OrderController;
use Illuminate\Support\Facades\Route;

Route::resource('orders', OrderController::class);
