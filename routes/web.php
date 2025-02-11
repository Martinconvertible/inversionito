<?php

use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
 });



Route::get('/stock/{symbol}', [StockController::class, 'show']);