<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PredictX | Market Pulse</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,800" rel="stylesheet" />
    <style>
        body { font-family: 'Instrument Sans', sans-serif; background-color: #faf5ff; background-image: radial-gradient(rgba(168, 85, 247, 0.15) 1px, transparent 1px); background-size: 24px 24px; color: #475569; overflow-x: hidden; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 1); box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.04); }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(0,0,0,0.03); }
    </style>
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
            <a href="{{ route('dashboard') }}" class="hover:text-rose-600 transition-colors pb-1">Terminal</a>
            <a href="{{ route('watchlist') }}" class="hover:text-rose-600 transition-colors pb-1">AI Watchlist</a>
            <a href="{{ route('pulse') }}" class="text-rose-600 border-b-2 border-rose-600 pb-1">Market Pulse</a>
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

    <div class="flex-1 max-w-7xl mx-auto w-full p-6 mt-4">
        
        <div class="mb-8">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Global Market Pulse</h2>
            <p class="text-sm text-slate-500 mt-1">Macro-level sentiment analysis and sector health mapping.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="glass p-8 rounded-[2rem] lg:col-span-2 flex flex-col justify-center items-center text-center">
                <h3 class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-4">Overall AI Sentiment Index</h3>
                <div class="relative w-48 h-48 rounded-full border-[16px] border-slate-100 flex items-center justify-center border-t-emerald-500 border-r-emerald-500 rotate-45 shadow-inner">
                    <div class="-rotate-45 text-center">
                        <span class="text-5xl font-black text-slate-800">68</span>
                        <p class="text-[10px] uppercase text-emerald-500 font-bold mt-1">Bullish Bias</p>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-8 max-w-md">Based on aggregated regression algorithms across top 100 global equities, current market momentum leans positive.</p>
            </div>

            <div class="glass p-8 rounded-[2rem] flex flex-col justify-between">
                <h3 class="text-[10px] uppercase tracking-widest text-slate-400 font-bold mb-6">Sector Health</h3>
                
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-800">Technology</span>
                            <span class="text-emerald-500">+2.4%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2"><div class="bg-emerald-500 h-2 rounded-full" style="width: 75%"></div></div>
                    </div>
                    
                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-800">Finance & Banking</span>
                            <span class="text-emerald-500">+1.1%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2"><div class="bg-emerald-500 h-2 rounded-full" style="width: 55%"></div></div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-800">EV & Auto</span>
                            <span class="text-rose-500">-1.8%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2"><div class="bg-rose-500 h-2 rounded-full" style="width: 35%"></div></div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-bold mb-1">
                            <span class="text-slate-800">Energy</span>
                            <span class="text-slate-400">0.0%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2"><div class="bg-slate-300 h-2 rounded-full" style="width: 50%"></div></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>