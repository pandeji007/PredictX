<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

// 1. Guest Route (Redirects to Login/Register)
Route::get('/', function () {
    return view('auth.login'); 
});
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Terminal (Your main app)
    Route::get('/dashboard', function () {
        return view('welcome'); 
    })->name('dashboard');

    // 2. AI Watchlist
    Route::get('/watchlist', function () {
        return view('watchlist'); 
    })->name('watchlist');

    // 3. Market Pulse
    Route::get('/pulse', function () {
        return view('pulse'); 
    })->name('pulse');

    // API Route
    Route::get('/api/stock/{symbol}', [StockController::class, 'getStockData']);
});

require __DIR__.'/auth.php';