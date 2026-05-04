<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PredictX | AI Market Terminal</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,800" rel="stylesheet" />
    <style>
        body { font-family: 'Instrument Sans', sans-serif; background: #050505; color: #9ca3af; overflow-x: hidden; }
        .glass { background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.08); }
        .glow { box-shadow: 0 0 80px -20px rgba(79, 70, 229, 0.3); }
        .stat-card { transition: all 0.3s ease; }
        .stat-card:hover { background: rgba(255, 255, 255, 0.05); transform: translateY(-2px); }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen py-12 px-6">
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-indigo-950/20 to-transparent -z-10"></div>

    <div class="max-w-6xl mx-auto w-full">
        <div class="flex flex-col md:flex-row items-center justify-between mb-12 gap-6">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-xl shadow-indigo-500/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-white tracking-tighter uppercase font-mono">Predict<span class="text-indigo-500">X</span></h1>
                    <p class="text-[10px] tracking-[0.3em] uppercase text-gray-500">Neural Market Engine</p>
                </div>
            </div>

            <div class="flex gap-2 w-full md:w-auto">
                <input type="text" id="tickerInput" placeholder="SYMBOL (e.g. AAPL)" 
                       class="w-full md:w-64 bg-white/5 border border-white/10 rounded-2xl p-4 text-white font-mono focus:border-indigo-500 outline-none uppercase transition-all">
                <button onclick="runAnalysis()" id="analyzeBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-8 rounded-2xl transition-all shadow-lg active:scale-95 whitespace-nowrap">
                    Analyze
                </button>
            </div>
        </div>

        <div id="resultArea" class="hidden space-y-6 animate-in fade-in slide-in-from-bottom-6 duration-700">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-1 glass p-8 rounded-[2rem] flex flex-col justify-center">
                    <p class="text-xs uppercase tracking-widest text-gray-500 font-bold mb-2">Live Market Price</p>
                    <h2 id="resSymbol" class="text-xl font-bold text-indigo-400 uppercase">---</h2>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span id="resPrice" class="text-6xl font-black text-white">$0.00</span>
                    </div>
                </div>

                <div class="glass p-8 rounded-[2rem] border-l-4 border-indigo-500">
                    <div class="flex justify-between items-start">
                        <p class="text-xs uppercase tracking-widest text-gray-500 font-bold">AI Projected Target</p>
                        <span class="bg-indigo-500/10 text-indigo-400 text-[10px] px-2 py-1 rounded-md font-bold">NEXT 24H</span>
                    </div>
                    <h4 id="predPrice" class="text-5xl font-black text-white mt-4">$0.00</h4>
                    <p class="text-xs text-gray-500 mt-2 italic">*Based on linear regression trend analysis</p>
                </div>

                <div class="glass p-8 rounded-[2rem] border-l-4" id="trendBorder">
                    <p class="text-xs uppercase tracking-widest text-gray-500 font-bold">Market Sentiment</p>
                    <h4 id="predTrend" class="text-5xl font-black mt-4">---</h4>
                    <p id="trendDesc" class="text-xs text-gray-500 mt-2">Analyzing momentum...</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <div class="lg:col-span-3 glass p-8 rounded-[2.5rem] glow">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-white font-bold uppercase tracking-widest text-sm">30-Day Historical Trend</h3>
                        <div class="flex gap-2">
                            <span class="w-3 h-3 bg-indigo-500 rounded-full"></span>
                            <span class="text-[10px] text-gray-500 uppercase font-bold">Close Price</span>
                        </div>
                    </div>
                    <div class="h-80 w-full">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-4">
                    <div class="glass p-6 rounded-2xl stat-card">
                        <p class="text-[10px] uppercase text-gray-500 font-bold">Day High</p>
                        <p id="statHigh" class="text-2xl font-bold text-white mt-1">$0.00</p>
                    </div>
                    <div class="glass p-6 rounded-2xl stat-card">
                        <p class="text-[10px] uppercase text-gray-500 font-bold">Day Low</p>
                        <p id="statLow" class="text-2xl font-bold text-white mt-1">$0.00</p>
                    </div>
                    <div class="glass p-6 rounded-2xl stat-card">
                        <p class="text-[10px] uppercase text-gray-500 font-bold">Volume</p>
                        <p id="statVol" class="text-2xl font-bold text-white mt-1">0</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 flex justify-center gap-12 text-[10px] uppercase tracking-[0.2em] font-bold text-gray-600">
            <span class="flex items-center gap-2"><span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Terminal Live</span>
            <span>● XAMPP Environment</span>
            <span>● Alpha Vantage API</span>
        </div>
    </div>

    <script>
    let myChart = null;

    async function runAnalysis() {
        const symbol = document.getElementById('tickerInput').value.trim();
        if(!symbol) return alert('Please enter a symbol');

        const btn = document.getElementById('analyzeBtn');
        btn.innerText = 'Syncing...';

        try {
            const response = await fetch(`api/stock/${symbol}`);
            const data = await response.json();

            if(data.history) {
                document.getElementById('resultArea').classList.remove('hidden');
                
                const dates = Object.keys(data.history).reverse();
                const prices = dates.map(date => data.history[date]['4. close']);
                const latestDate = Object.keys(data.history)[0];
                const latestData = data.history[latestDate];

                // Update UI Components
                document.getElementById('resSymbol').innerText = data.symbol;
                document.getElementById('resPrice').innerText = '$' + parseFloat(latestData['4. close']).toFixed(2);
                document.getElementById('statHigh').innerText = '$' + parseFloat(latestData['2. high']).toFixed(2);
                document.getElementById('statLow').innerText = '$' + parseFloat(latestData['3. low']).toFixed(2);
                document.getElementById('statVol').innerText = parseInt(latestData['5. volume']).toLocaleString();

                // Update Predictions
                document.getElementById('predPrice').innerText = '$' + data.prediction;
                const predTrend = document.getElementById('predTrend');
                const trendBorder = document.getElementById('trendBorder');
                const trendDesc = document.getElementById('trendDesc');

                predTrend.innerText = data.trend;
                if(data.trend === 'BULLISH') {
                    predTrend.className = 'text-5xl font-black mt-4 text-green-400';
                    trendBorder.style.borderColor = '#4ade80';
                    trendDesc.innerText = 'Positive momentum detected.';
                } else {
                    predTrend.className = 'text-5xl font-black mt-4 text-red-400';
                    trendBorder.style.borderColor = '#f87171';
                    trendDesc.innerText = 'Downside pressure observed.';
                }

                renderChart(dates, prices);
            }
        } catch (e) {
            alert('API Limit or Connection Error');
        } finally {
            btn.innerText = 'Analyze';
        }
    }

    function renderChart(labels, data) {
        const ctx = document.getElementById('stockChart').getContext('2d');
        if(myChart) myChart.destroy();

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.4)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    borderColor: '#6366f1',
                    borderWidth: 4,
                    pointBackgroundColor: '#6366f1',
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: {
                        grid: { color: 'rgba(255,255,255,0.05)', drawBorder: false },
                        ticks: { color: '#4b5563', font: { size: 10 } }
                    }
                }
            }
        });
    }
    </script>
</body>
</html>