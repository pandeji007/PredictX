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
            return response()->json(['error' => 'API Limit reached'], 400);
        }

        // 1. Extract the last 30 days for the chart
        $timeSeries = array_slice($data['Time Series (Daily)'], 0, 30);
        $prices = [];
        foreach ($timeSeries as $date => $values) {
            $prices[] = (float)$values['4. close'];
        }
        
        // Reverse array so oldest is first [Day 1, Day 2 ... Day 30 (Today)]
        $prices = array_reverse($prices);
        $latestPrice = end($prices);

        // ==========================================
        // ENHANCED PREDICTION ALGORITHM
        // ==========================================
        
        // 2. Calculate 10-Day Simple Moving Average (Short-term momentum)
        $recent10Days = array_slice($prices, -10);
        $sma10 = array_sum($recent10Days) / 10;

        // 3. Linear Regression (Optimized to last 14 days for faster reaction)
        $regWindow = array_slice($prices, -14);
        $n = count($regWindow);
        $x_sum = 0; $y_sum = 0; $xy_sum = 0; $x2_sum = 0;

        for ($i = 0; $i < $n; $i++) {
            $y = $regWindow[$i];
            $x = $i + 1;
            $x_sum += $x;
            $y_sum += $y;
            $xy_sum += ($x * $y);
            $x2_sum += ($x * $x);
        }

        // Calculate slope (trend direction) and intercept
        $slope = ($n * $xy_sum - $x_sum * $y_sum) / ($n * $x2_sum - $x_sum * $x_sum);
        $intercept = ($y_sum - $slope * $x_sum) / $n;
        
        // Base prediction for tomorrow (Day 15 in this window)
        $basePrediction = $slope * ($n + 1) + $intercept;

        // 4. Momentum Adjustment (Blend Regression with SMA gap)
        // If the stock is surging above its average, it pulls the prediction up slightly
        $momentumGap = ($latestPrice - $sma10) * 0.15; // 15% weight to recent volatility
        $finalPrediction = $basePrediction + $momentumGap;

        // 5. Advanced Sentiment Classification
        if ($slope > 0 && $latestPrice > $sma10) {
            $trend = 'STRONG BULLISH';
        } elseif ($slope > 0) {
            $trend = 'BULLISH';
        } elseif ($slope < 0 && $latestPrice < $sma10) {
            $trend = 'STRONG BEARISH';
        } else {
            $trend = 'BEARISH';
        }

        return response()->json([
            'symbol' => $symbol,
            'history' => $timeSeries, // Send original data to frontend chart
            'prediction' => round($finalPrediction, 2),
            'trend' => $trend
        ]);
    }
}