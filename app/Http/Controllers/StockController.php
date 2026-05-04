<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StockController extends Controller
{
    public function getStockData($symbol)
{
    $key = env('ALPHA_VANTAGE_KEY');
    $response = Http::get("https://www.alphavantage.co/query", [
        'function' => 'TIME_SERIES_DAILY',
        'symbol' => $symbol,
        'apikey' => $key
    ]);

    $data = $response->json();
    if (isset($data['Error Message']) || isset($data['Note'])) {
        return response()->json(['error' => 'Limit reached'], 400);
    }

    $timeSeries = array_slice($data['Time Series (Daily)'], 0, 30);
    $prices = [];
    foreach ($timeSeries as $date => $values) {
        $prices[] = (float)$values['4. close'];
    }

    // --- AI PREDICTION LOGIC (Linear Regression) ---
    $n = count($prices);
    $x_sum = 0; $y_sum = 0; $xy_sum = 0; $x2_sum = 0;

    // We treat dates as 1, 2, 3... n
    for ($i = 0; $i < $n; $i++) {
        $y = $prices[($n - 1) - $i]; // Oldest to newest
        $x = $i + 1;
        $x_sum += $x;
        $y_sum += $y;
        $xy_sum += ($x * $y);
        $x2_sum += ($x * $x);
    }

    $slope = ($n * $xy_sum - $x_sum * $y_sum) / ($n * $x2_sum - $x_sum * $x_sum);
    $intercept = ($y_sum - $slope * $x_sum) / $n;
    
    // Predict next day (n + 1)
    $prediction = $slope * ($n + 1) + $intercept;

    return response()->json([
        'symbol' => $symbol,
        'history' => $timeSeries,
        'prediction' => round($prediction, 2),
        'trend' => $slope > 0 ? 'BULLISH' : 'BEARISH'
    ]);
}
}