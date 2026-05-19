<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PredictX | AI Watchlist</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,800" rel="stylesheet" />
    <style>
        body { font-family: 'Instrument Sans', sans-serif; background-color: #faf5ff; background-image: radial-gradient(rgba(168, 85, 247, 0.15) 1px, transparent 1px); background-size: 24px 24px; color: #475569; overflow-x: hidden; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 1); box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.04); }
        .glass-nav { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(0,0,0,0.03); }
        .hover-card:hover { transform: translateY(-3px); box-shadow: 0 15px 35px -5px rgba(0,0,0,0.08); }
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
            <a href="{{ route('watchlist') }}" class="text-rose-600 border-b-2 border-rose-600 pb-1">AI Watchlist</a>
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

    <div class="flex-1 max-w-7xl mx-auto w-full p-6 mt-4">
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Operator Watchlist</h2>
                <p class="text-sm text-slate-500 mt-1">Saved neural predictions and active monitoring nodes.</p>
            </div>
            <button class="bg-white border border-slate-200 text-slate-600 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-50 transition-colors">
                + Add Ticker
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <div class="glass p-6 rounded-[2rem] border-l-4 border-emerald-500 hover-card transition-all cursor-pointer">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800">IBM</h3>
                        <p class="text-[10px] uppercase tracking-widest text-slate-400">Tech</p>
                    </div>
                    <span class="bg-emerald-100 text-emerald-600 text-[10px] px-2 py-1 rounded font-black uppercase tracking-widest">Bullish</span>
                </div>
                <div class="mt-6 flex justify-between items-end">
                    <div>
                        <p class="text-[10px] uppercase text-slate-400 font-bold">Current</p>
                        <p class="text-3xl font-black text-slate-800">$184.20</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase text-slate-400 font-bold">AI Target</p>
                        <p class="text-xl font-bold text-emerald-500">$189.50</p>
                    </div>
                </div>
            </div>

            <div class="glass p-6 rounded-[2rem] border-l-4 border-rose-500 hover-card transition-all cursor-pointer">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800">TSLA</h3>
                        <p class="text-[10px] uppercase tracking-widest text-slate-400">EV Auto</p>
                    </div>
                    <span class="bg-rose-100 text-rose-600 text-[10px] px-2 py-1 rounded font-black uppercase tracking-widest">Bearish</span>
                </div>
                <div class="mt-6 flex justify-between items-end">
                    <div>
                        <p class="text-[10px] uppercase text-slate-400 font-bold">Current</p>
                        <p class="text-3xl font-black text-slate-800">$172.10</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase text-slate-400 font-bold">AI Target</p>
                        <p class="text-xl font-bold text-rose-500">$165.80</p>
                    </div>
                </div>
            </div>

            <div class="glass p-6 rounded-[2rem] border-l-4 border-emerald-500 hover-card transition-all cursor-pointer">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-800">TCS.BSE</h3>
                        <p class="text-[10px] uppercase tracking-widest text-slate-400">BSE India</p>
                    </div>
                    <span class="bg-emerald-100 text-emerald-600 text-[10px] px-2 py-1 rounded font-black uppercase tracking-widest">Bullish</span>
                </div>
                <div class="mt-6 flex justify-between items-end">
                    <div>
                        <p class="text-[10px] uppercase text-slate-400 font-bold">Current</p>
                        <p class="text-3xl font-black text-slate-800">₹3920.00</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] uppercase text-slate-400 font-bold">AI Target</p>
                        <p class="text-xl font-bold text-emerald-500">₹4010.50</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>