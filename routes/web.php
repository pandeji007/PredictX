<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

Route::get('/', function () {
    return view('welcome');
});

// This must match the fetch URL exactly
Route::get('/api/stock/{symbol}', [StockController::class, 'getStockData']);