<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTrack - Login</title>
    <link rel="icon" href="{{ asset('icons/logo-new.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.4); }
        @keyframes slideUpFade {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .anim-fade-up { animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 h-screen flex flex-col md:flex-row items-center justify-center overflow-hidden">
    
    <!-- Left Section: Branding -->
    <div class="hidden md:flex flex-col justify-center items-center w-1/2 h-full bg-gradient-to-br from-indigo-600 to-indigo-900 text-white p-12 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-0 w-full h-full opacity-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-white opacity-5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 text-center anim-fade-up">
            <div class="bg-white/10 p-6 rounded-3xl backdrop-blur-md border border-white/20 inline-block mb-8 shadow-2xl">
                <img src="{{ asset('icons/logo-new.png') }}" alt="ProTrack Logo" class="h-32 w-auto object-contain drop-shadow-lg filter brightness-0 invert">
            </div>
            <h1 class="text-4xl font-bold mb-4 tracking-tight">ProTrack<span class="text-indigo-300">.</span></h1>
            <p class="text-indigo-200 text-lg max-w-md mx-auto leading-relaxed">{{ __('Platform manajemen proyek terpadu untuk efisiensi dan transparansi kinerja tim Anda.') }}</p>
        </div>
    </div>

    <!-- Right Section: Login Form -->
    <div class="w-full md:w-1/2 flex items-center justify-center p-6 md:p-12 relative">
        <!-- Mobile Logo -->
        <div class="md:hidden absolute top-8 left-0 right-0 flex justify-center">
            <img src="{{ asset('icons/logo-new.png') }}" alt="ProTrack Logo" class="h-16 w-auto object-contain">
        </div>

        <div class="w-full max-w-md anim-fade-up delay-100">
            <div class="glass p-8 md:p-10 rounded-3xl shadow-xl relative overflow-hidden">
                <div class="flex justify-between items-start mb-8 gap-4">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-800 mb-2 flex items-center flex-wrap gap-2">
                            {{ __('Selamat Datang 👋') }}
                            <span class="w-3 h-3 bg-indigo-500 rounded-full animate-pulse block shrink-0"></span>
                        </h2>
                        <p class="text-slate-500 text-sm">{{ __('Silakan masuk ke akun Anda untuk melanjutkan.') }}</p>
                    </div>

                    <!-- Language Switcher -->
                    <div class="flex items-center bg-slate-100/70 rounded-lg p-1 shadow-inner border border-slate-200 shrink-0 mt-1">
                        <a href="{{ route('lang.switch', 'id') }}" class="px-2.5 py-1 text-[10px] font-bold rounded-md transition-all {{ session('locale', 'id') == 'id' ? 'bg-white shadow-sm text-indigo-600 pointer-events-none' : 'text-slate-400 hover:text-slate-700' }}">ID</a>
                        <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1 text-[10px] font-bold rounded-md transition-all {{ session('locale') == 'en' ? 'bg-white shadow-sm text-indigo-600 pointer-events-none' : 'text-slate-400 hover:text-slate-700' }}">EN</a>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-600 rounded-xl p-4 text-sm flex items-start gap-3">
                        <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-sm font-medium text-slate-700">{{ __('Kata Sandi') }}</label>
                        </div>
                        <input type="password" name="password" id="password" required autofocus
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder:text-slate-400"
                               placeholder="••••••••">
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl py-3.5 transition-all shadow-lg shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-0.5 mt-2">
                        {{ __('Masuk ke Dashboard') }}
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-slate-100 text-sm text-center">
                    @if(request()->cookie('protrack_user_name'))
                        <span class="text-slate-500">{{ __('Perangkat ini dikenali sebagai:') }}</span> <strong class="text-indigo-600 font-semibold">{{ request()->cookie('protrack_user_name') }}</strong>.<br>
                        <button onclick="setName()" class="text-xs text-slate-400 hover:text-indigo-600 mt-1 transition-colors">{{ __('(Ubah / Hapus?)') }}</button>
                    @else
                        <button onclick="setName()" class="text-indigo-600 font-medium hover:text-indigo-800 transition-colors">{{ __('Siapa Anda? (Set Nama Perangkat)') }}</button>
                    @endif
                </div>

                <script>
                    function setName() {
                        let current = "{{ request()->cookie('protrack_user_name') }}";
                        let name = prompt("{{ __('Masukkan nama Anda untuk perangkat ini (Kosongkan jika ingin menghapus memori):') }}", current);
                        if (name !== null) {
                            if (name.trim() === "") {
                                document.cookie = "protrack_user_name=; max-age=0; path=/";
                            } else {
                                document.cookie = "protrack_user_name=" + encodeURIComponent(name) + "; max-age=31536000; path=/";
                            }
                            window.location.reload();
                        }
                    }
                </script>
            </div>
            
            <p class="text-center text-slate-400 text-sm mt-8 anim-fade-up delay-200">
                &copy; {{ date('Y') }} ProTrack Management. All rights reserved.
            </p>
        </div>
    </div>

</body>
</html>


