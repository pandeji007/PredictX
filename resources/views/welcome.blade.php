<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PredictX | Terminal</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,800" rel="stylesheet" />
    <style>
        /* NEW: Sober Light Purple Background */
        body { 
            font-family: 'Instrument Sans', sans-serif; 
            background-color: #faf5ff; /* Tailwind purple-50 */
            background-image: radial-gradient(rgba(168, 85, 247, 0.15) 1px, transparent 1px); /* Soft purple dots */
            background-size: 24px 24px;
            color: #475569; 
            overflow-x: hidden; 
        }
        
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 1); box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.04); }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(0,0,0,0.03); }
        
        .sidebar-item { transition: all 0.2s; cursor: pointer; }
        /* NEW: Sober Red hover accent */
        .sidebar-item:hover { background: #fff1f2; border-left: 4px solid #e11d48; }
        input:focus { box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.15); } /* Sober Red focus ring */
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen flex flex-col">
    
    <nav class="glass-nav sticky top-0 z-50 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-rose-600 rounded-xl flex items-center justify-center shadow-md shadow-rose-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tighter uppercase font-mono">Predict<span class="text-rose-600">X</span></h1>
        </div>

      <div class="hidden md:flex gap-8 text-[11px] uppercase tracking-widest font-bold text-slate-500">
    <a href="{{ route('dashboard') }}" class="text-rose-600 border-b-2 border-rose-600 pb-1">Terminal</a>
    <a href="{{ route('watchlist') }}" class="hover:text-rose-600 transition-colors pb-1">AI Watchlist</a>
    <a href="{{ route('pulse') }}" class="hover:text-rose-600 transition-colors pb-1">Market Pulse</a>
</div>

        @auth
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-extrabold text-slate-800">{{ auth()->user()->name }}</p> 
            </div>
            <div class="w-9 h-9 bg-rose-100 rounded-full flex items-center justify-center text-rose-700 font-black border border-rose-200 uppercase">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="text-[10px] font-bold text-slate-400 hover:text-rose-600 uppercase tracking-widest transition-colors cursor-pointer">Logout</button>
            </form>
        </div>
        @endauth
    </nav>

    <div class="flex-1 max-w-7xl mx-auto w-full flex flex-col md:flex-row gap-6 p-6">
        
        <aside class="w-full md:w-72 glass rounded-[2rem] p-6 h-fit md:sticky md:top-24">
            <h3 class="text-xs uppercase tracking-widest text-slate-400 font-bold mb-4 px-2">Global Markets</h3>
            <div class="space-y-1">
                <div onclick="document.getElementById('tickerInput').value='IBM'; runAnalysis();" class="sidebar-item flex justify-between items-center p-3 rounded-xl">
                    <div>
                        <p class="font-bold text-slate-800">IBM</p>
                        <p class="text-[10px] text-slate-500 uppercase">Tech</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
                <div onclick="document.getElementById('tickerInput').value='RELIANCE.BSE'; runAnalysis();" class="sidebar-item flex justify-between items-center p-3 rounded-xl">
                    <div>
                        <p class="font-bold text-slate-800">RELIANCE</p>
                        <p class="text-[10px] text-slate-500 uppercase">BSE India</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
                <div onclick="document.getElementById('tickerInput').value='TCS.BSE'; runAnalysis();" class="sidebar-item flex justify-between items-center p-3 rounded-xl">
                    <div>
                        <p class="font-bold text-slate-800">TCS</p>
                        <p class="text-[10px] text-slate-500 uppercase">BSE India</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
                <div onclick="document.getElementById('tickerInput').value='TSLA'; runAnalysis();" class="sidebar-item flex justify-between items-center p-3 rounded-xl">
                    <div>
                        <p class="font-bold text-slate-800">TSLA</p>
                        <p class="text-[10px] text-slate-500 uppercase">EV Auto</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
        </aside>

        <main class="flex-1 space-y-6">
            
            <div class="flex gap-2 w-full shadow-sm rounded-2xl">
                <input type="text" id="tickerInput" placeholder="SEARCH GLOBAL TICKER..." 
                       class="flex-1 bg-white border border-rose-100 rounded-2xl p-4 text-slate-800 font-mono focus:border-rose-500 outline-none uppercase transition-all placeholder:text-slate-400">
                <button onclick="runAnalysis()" id="analyzeBtn" class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-8 rounded-2xl transition-all shadow-md active:scale-95 whitespace-nowrap cursor-pointer">
                    Analyze
                </button>
            </div>

            <div id="emptyState" class="glass p-12 rounded-[2.5rem] text-center border-dashed border-2 border-slate-200">
                <svg class="w-16 h-16 text-rose-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                <h3 class="text-xl font-bold text-slate-700">Awaiting Terminal Input</h3>
                <p class="text-sm text-slate-500 mt-2">Search for a ticker or select a company from the sidebar to initialize the AI engine.</p>
            </div>

            <div id="resultArea" class="hidden space-y-6">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="glass p-8 rounded-[2rem]">
                        <p class="text-xs uppercase tracking-widest text-slate-500 font-bold mb-2">Live Market Price</p>
                        <h2 id="resSymbol" class="text-xl font-bold text-rose-600 uppercase">---</h2>
                        <span id="resPrice" class="text-5xl font-black text-slate-800">$0.00</span>
                    </div>

                    <div class="glass p-8 rounded-[2rem] border-l-4 border-rose-500" id="trendBorder">
                        <div class="flex justify-between items-start">
                            <p class="text-xs uppercase tracking-widest text-slate-500 font-bold">24H AI Projection</p>
                            <span id="predTrend" class="text-xs font-black uppercase text-rose-600">---</span>
                        </div>
                        <h4 id="predPrice" class="text-5xl font-black text-slate-800 mt-2">$0.00</h4>
                    </div>
                </div>

                <div class="glass p-8 rounded-[2.5rem]">
                    <div class="h-72 w-full">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    let myChart = null;

    async function runAnalysis() {
        const symbol = document.getElementById('tickerInput').value.trim();
        if(!symbol) return alert('Please enter a symbol');

        const btn = document.getElementById('analyzeBtn');
        btn.innerText = 'Syncing...';
        
        document.getElementById('emptyState').classList.add('hidden');

        try {
            const response = await fetch(`../api/stock/${symbol}`);
            const data = await response.json();

            if(data.history) {
                document.getElementById('resultArea').classList.remove('hidden');
                
                const dates = Object.keys(data.history).reverse();
                const prices = dates.map(date => data.history[date]['4. close']);
                const latestDate = Object.keys(data.history)[0];
                const latestData = data.history[latestDate];

                document.getElementById('resSymbol').innerText = data.symbol;
                document.getElementById('resPrice').innerText = '$' + parseFloat(latestData['4. close']).toFixed(2);
                document.getElementById('predPrice').innerText = '$' + data.prediction;
                
                const predTrend = document.getElementById('predTrend');
                const trendBorder = document.getElementById('trendBorder');

                predTrend.innerText = data.trend;
                
                // Bullish (Green/Emerald), Bearish (Red/Rose) - kept standard financial colors for logic
                if(data.trend === 'BULLISH') {
                    predTrend.className = 'text-xs font-black uppercase text-emerald-500';
                    trendBorder.style.borderColor = '#10b981'; 
                } else {
                    predTrend.className = 'text-xs font-black uppercase text-rose-600';
                    trendBorder.style.borderColor = '#e11d48'; 
                }

                renderChart(dates, prices);
            }
        } catch (e) {
            alert('API Limit or Connection Error');
            document.getElementById('emptyState').classList.remove('hidden');
            document.getElementById('resultArea').classList.add('hidden');
        } finally {
            btn.innerText = 'Analyze';
        }
    }

    function renderChart(labels, data) {
        const ctx = document.getElementById('stockChart').getContext('2d');
        if(myChart) myChart.destroy();

        // Updated chart gradient to match the new Sober Red theme
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(225, 29, 72, 0.2)'); /* Rose-600 */
        gradient.addColorStop(1, 'rgba(225, 29, 72, 0)');

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    borderColor: '#e11d48', /* Rose-600 */
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#e11d48',
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
                    y: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { color: '#64748b' } }
                }
            }
        });
    }
    </script>
</body>
</html>