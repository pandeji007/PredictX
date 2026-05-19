<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PredictX | Secure Authorization</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,600,800" rel="stylesheet" />
    <style>
        /* Lightweight Custom CSS */
        body { 
            font-family: 'Instrument Sans', sans-serif; 
            background-color: #faf5ff; /* Light Sober Purple */
            color: #475569; 
            overflow-x: hidden; 
        }
        
        /* Light Glassmorphism */
        .glass { 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(16px); 
            border: 1px solid #ffffff; 
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.08);
        }
        
        /* Rose Focus Ring */
        input:focus { box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.15); }

        /* Pure CSS Grid Pattern for 4 Corners (Soft Purple) */
        .grid-bg {
            position: absolute;
            width: 300px;
            height: 300px;
            background-image: radial-gradient(rgba(168, 85, 247, 0.15) 1.5px, transparent 1.5px);
            background-size: 24px 24px;
            z-index: -10;
            opacity: 0.6;
            mask-image: radial-gradient(circle, black, transparent 70%);
            -webkit-mask-image: radial-gradient(circle, black, transparent 70%);
        }
        .top-left { top: -50px; left: -50px; }
        .top-right { top: -50px; right: -50px; }
        .bottom-left { bottom: -50px; left: -50px; }
        .bottom-right { bottom: -50px; right: -50px; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center px-6 relative">
    
    <div class="grid-bg top-left"></div>
    <div class="grid-bg top-right"></div>
    <div class="grid-bg bottom-left hidden md:block"></div>
    <div class="grid-bg bottom-right hidden md:block"></div>

    <div class="max-w-md w-full relative z-10 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="flex flex-col items-center gap-3 mb-10 justify-center">
            <div class="w-16 h-16 bg-rose-600 rounded-2xl flex items-center justify-center shadow-lg shadow-rose-500/30 mb-2">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tighter uppercase font-mono">Predict<span class="text-rose-600">X</span></h1>
            <p class="text-[10px] tracking-[0.3em] uppercase text-slate-500 font-bold">Secure Node Authorization</p>
        </div>

        <div class="glass p-8 md:p-10 rounded-[2.5rem]">
            
            <x-auth-session-status class="mb-4 text-emerald-500 text-sm text-center font-bold" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Operator ID (Email)</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full bg-white border border-slate-200 rounded-2xl p-4 text-slate-800 font-mono focus:border-rose-500 outline-none transition-all placeholder:text-slate-400"
                           placeholder="admin@predictx.com">
                    @error('email')
                        <p class="text-rose-500 text-[10px] uppercase tracking-widest mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-[10px] uppercase tracking-widest text-slate-500 font-bold mb-2">Access Key (Password)</label>
                    <input id="password" type="password" name="password" required
                           class="w-full bg-white border border-slate-200 rounded-2xl p-4 text-slate-800 font-mono focus:border-rose-500 outline-none transition-all placeholder:text-slate-400"
                           placeholder="••••••••">
                    @error('password')
                        <p class="text-rose-500 text-[10px] uppercase tracking-widest mt-2 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 bg-white text-rose-600 shadow-sm focus:ring-rose-500">
                        <span class="ms-2 text-[10px] text-slate-500 uppercase tracking-widest font-bold">Keep Connection</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-[10px] text-rose-600 hover:text-rose-800 uppercase tracking-widest font-bold transition-colors" href="{{ route('password.request') }}">
                            Reset Key?
                        </a>
                    @endif
                </div>

                <div class="mt-8 pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold px-8 py-4 rounded-2xl transition-all shadow-md active:scale-95 uppercase tracking-widest flex justify-center items-center gap-2">
                        Initialize Session
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-[10px] text-slate-500 uppercase tracking-widest font-bold">
                    New Operator? 
                    <a href="{{ route('register') }}" class="text-rose-600 hover:text-rose-800 transition-colors ml-1">Register Node</a>
                </p>
            </div>
        </div>
        
        <div class="mt-12 flex justify-center text-[10px] uppercase tracking-[0.2em] font-bold text-slate-400">
            <span class="flex items-center gap-2"><span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse shadow-sm shadow-emerald-500"></span> Authentication Server Active</span>
        </div>
    </div>
</body>
</html>