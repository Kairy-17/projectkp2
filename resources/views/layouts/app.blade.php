<!DOCTYPE html>
<html lang="{{ Session::get('locale', config('app.locale')) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTrack - Project Management</title>
    <link rel="icon" href="{{ asset('icons/logo-new.png') }}">
    <!-- PWA Setup -->
    <meta name="theme-color" content="#4f46e5">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    
    <!-- Turbo Configuration -->
    <meta name="turbo-cache-control" content="no-cache">
    <meta name="turbo-prefetch" content="true">

    <!-- Scripts and Fonts -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/+esm"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <!-- Compiled Tailwind and App Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.4); }
        
        /* Custom Scrollbar for Windows */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.3); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.5); }
        
        @keyframes slideUpFade {
            0% { opacity: 0; transform: translateY(100%); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .turbo-progress-bar {
            height: 4px;
            background-color: #4f46e5;
        }
        @keyframes splashPremium {
            0% { transform: scale(0.6) translateY(20px); opacity: 0; filter: blur(8px); }
            60% { transform: scale(1.05) translateY(-5px); opacity: 1; filter: blur(0); }
            100% { transform: scale(1) translateY(0); opacity: 1; filter: blur(0); }
        }
        .anim-premium { animation: splashPremium 1s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-indigo-100 selection:text-indigo-900 h-screen overflow-hidden">
    
    <!-- Splash Screen Heboh -->
    <div id="splash-screen" data-turbo-permanent x-data="{ 
            showSplash: !sessionStorage.getItem('splashShown'),
            phase1: false,
            phase2: false,
            init() {
                if(this.showSplash) {
                    setTimeout(() => { this.phase1 = true; }, 1200); // Logo zoom in and fade out
                    setTimeout(() => { this.phase2 = true; }, 1500); // Layers start sliding up
                    setTimeout(() => {
                        this.showSplash = false;
                        sessionStorage.setItem('splashShown', 'true');
                    }, 2000); // Fully hide from DOM
                }
            }
         }" 
         x-show="showSplash"
         class="fixed inset-0 z-[9999] pointer-events-none"
         style="display: none;"
         :class="{ 'block': showSplash }">
         
         <!-- Background Layer 3 (Paling lambat) -->
         <div class="absolute inset-0 bg-slate-100 transition-transform duration-700 ease-[cubic-bezier(0.87,0,0.13,1)]"
              :class="phase2 ? '-translate-y-full' : 'translate-y-0'"
              style="transition-delay: 200ms;"></div>
              
         <!-- Background Layer 2 (Agak lambat) -->
         <div class="absolute inset-0 bg-slate-200 transition-transform duration-700 ease-[cubic-bezier(0.87,0,0.13,1)]"
              :class="phase2 ? '-translate-y-full' : 'translate-y-0'"
              style="transition-delay: 100ms;"></div>

         <!-- Background Layer 1 (Paling Utama) -->
         <div class="absolute inset-0 bg-white transition-transform duration-700 ease-[cubic-bezier(0.87,0,0.13,1)] flex flex-col items-center justify-center overflow-hidden"
              :class="phase2 ? '-translate-y-full' : 'translate-y-0'">

              <!-- Main Logo Container -->
              <div class="relative z-10 transition-all duration-500 ease-in-out flex flex-col items-center"
                   :class="phase1 ? 'scale-[3] opacity-0 blur-md' : 'scale-100 opacity-100 blur-0'">
                  
                  <div class="relative flex items-center justify-center w-36 h-36 mb-6">
                      <img src="{{ asset('icons/logo-new.png') }}" alt="ProTrack Logo" class="w-full h-full object-contain anim-premium opacity-0 drop-shadow-xl">
                  </div>
                  
                  <!-- Text Tracking Reveal -->
                  <div class="overflow-hidden">
                      <h1 class="text-slate-900 text-5xl font-black tracking-tight"
                          style="animation: slideUpFade 1s cubic-bezier(0.16, 1, 0.3, 1) 0.5s forwards; opacity: 0; transform: translateY(100%);">
                          ProTrack<span class="text-indigo-600">.</span>
                      </h1>
                  </div>
                  <p class="text-slate-500 mt-3 text-sm font-bold tracking-[0.3em] uppercase"
                     style="animation: slideUpFade 1s cubic-bezier(0.16, 1, 0.3, 1) 0.7s forwards; opacity: 0; transform: translateY(100%);">
                     Initializing System
                  </p>
              </div>
         </div>
    </div>

    <!-- Page Load Animation Wrapper -->
    <div x-data="{ loaded: false }" 
         x-init="setTimeout(() => loaded = true, 50)" 
         x-show="loaded" 
         x-transition:enter="transition-all ease-out duration-700" 
         x-transition:enter-start="opacity-0 translate-y-4 scale-[0.99]" 
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         style="display: none;"
         class="flex h-full w-full">
        @yield('content')
    </div>
    
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
