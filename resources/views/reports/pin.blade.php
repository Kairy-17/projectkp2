<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keamanan Laporan - Masukkan PIN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">
    
    <div class="max-w-md w-full bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-3xl shadow-2xl relative overflow-hidden">
        
        <!-- Glow effects -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-indigo-500/20 rounded-full blur-3xl"></div>

        <div class="relative z-10">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
            </div>

            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-white mb-2">Laporan Terkunci</h1>
                <p class="text-slate-300 text-sm">Masukkan PIN keamanan untuk melihat data finansial dan laporan kinerja.</p>
            </div>

            <form action="{{ route('report.pin.verify') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <input type="password" name="pin" 
                           class="w-full bg-slate-800/50 border border-slate-600 rounded-xl px-4 py-3 text-center text-2xl tracking-[0.5em] text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder:text-slate-500 placeholder:tracking-normal" 
                           placeholder="••••••"
                           autocomplete="off"
                           autofocus
                           required>
                    
                    @error('pin')
                        <p class="text-rose-400 text-sm text-center mt-3 font-medium flex items-center justify-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('dashboard') }}" class="flex-1 px-4 py-3 bg-slate-800 hover:bg-slate-700 text-slate-300 text-center rounded-xl font-semibold transition-colors">Kembali</a>
                    <button type="submit" class="flex-1 px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-500/30 transition-all">Buka Brankas</button>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
