<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTrack - Project Management</title>
    
    <!-- PWA Setup -->
    <meta name="theme-color" content="#4f46e5">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: { primary: '#4f46e5', secondary: '#1e293b' }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; }
        .glass { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.4); }
        @keyframes slideUpFade {
            0% { opacity: 0; transform: translateY(100%); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-indigo-100 selection:text-indigo-900 h-screen overflow-hidden">
    
    <!-- Splash Screen Heboh -->
    <div x-data="{ 
            showSplash: !sessionStorage.getItem('splashShown'),
            phase1: false,
            phase2: false,
            init() {
                if(this.showSplash) {
                    setTimeout(() => { this.phase1 = true; }, 1800); // Logo zoom in and fade out
                    setTimeout(() => { this.phase2 = true; }, 2000); // Layers start sliding up
                    setTimeout(() => {
                        this.showSplash = false;
                        sessionStorage.setItem('splashShown', 'true');
                    }, 2800); // Fully hide from DOM
                }
            }
         }" 
         x-show="showSplash"
         class="fixed inset-0 z-[9999] pointer-events-none"
         style="display: none;"
         :class="{ 'block': showSplash }">
         
         <!-- Background Layer 3 (Paling lambat) -->
         <div class="absolute inset-0 bg-indigo-200 transition-transform duration-700 ease-[cubic-bezier(0.87,0,0.13,1)]"
              :class="phase2 ? '-translate-y-full' : 'translate-y-0'"
              style="transition-delay: 200ms;"></div>
              
         <!-- Background Layer 2 (Agak lambat) -->
         <div class="absolute inset-0 bg-indigo-400 transition-transform duration-700 ease-[cubic-bezier(0.87,0,0.13,1)]"
              :class="phase2 ? '-translate-y-full' : 'translate-y-0'"
              style="transition-delay: 100ms;"></div>

         <!-- Background Layer 1 (Paling Utama) -->
         <div class="absolute inset-0 bg-slate-900 transition-transform duration-700 ease-[cubic-bezier(0.87,0,0.13,1)] flex flex-col items-center justify-center overflow-hidden"
              :class="phase2 ? '-translate-y-full' : 'translate-y-0'">
              
              <!-- Background Ornaments (Grid or Glows) -->
              <div class="absolute inset-0 bg-[linear-gradient(to_right,#4f46e522_1px,transparent_1px),linear-gradient(to_bottom,#4f46e522_1px,transparent_1px)] bg-[size:40px_40px]"></div>
              
              <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-600/30 rounded-full blur-[100px] animate-pulse"></div>
              <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-600/30 rounded-full blur-[100px] animate-pulse" style="animation-delay: 1s;"></div>

              <!-- Main Logo Container -->
              <div class="relative z-10 transition-all duration-500 ease-in-out flex flex-col items-center"
                   :class="phase1 ? 'scale-[3] opacity-0 blur-md' : 'scale-100 opacity-100 blur-0'">
                  
                  <div class="relative flex items-center justify-center w-32 h-32 mb-6">
                      <!-- Spinners -->
                      <div class="absolute inset-0 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                      <div class="absolute inset-2 border-4 border-purple-500 border-b-transparent rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
                      
                      <!-- Center Icon -->
                      <div class="relative bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl w-20 h-20 flex items-center justify-center shadow-[0_0_40px_rgba(79,70,229,0.5)]">
                          <span class="text-4xl font-black text-white">P</span>
                      </div>
                  </div>
                  
                  <!-- Text Tracking Reveal -->
                  <div class="overflow-hidden">
                      <h1 class="text-white text-5xl font-black tracking-tight"
                          style="animation: slideUpFade 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(100%);">
                          ProTrack<span class="text-indigo-500">.</span>
                      </h1>
                  </div>
                  <p class="text-indigo-300 mt-3 text-sm font-bold tracking-[0.3em] uppercase"
                     style="animation: slideUpFade 1s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards; opacity: 0; transform: translateY(100%);">
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
