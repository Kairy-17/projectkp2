<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ProTrack - Project Management</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%234f46e5'/><text x='50%' y='50%' font-family='Arial, sans-serif' font-size='65' font-weight='bold' fill='white' dominant-baseline='central' text-anchor='middle'>P</text></svg>">
    <!-- PWA Setup -->
    <meta name="theme-color" content="#4f46e5">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    
    <!-- Turbo Configuration -->
    <meta name="turbo-cache-control" content="no-cache">

    <script src="https://cdn.tailwindcss.com"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/+esm"></script>
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
        .turbo-progress-bar {
            height: 4px;
            background-color: #4f46e5;
        }
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
        <div x-data="{ sidebarOpen: false }" class="flex h-full w-full">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 glass shadow-xl transition-transform duration-300 md:static md:translate-x-0 flex flex-col border-r border-slate-200">
            <div class="p-6 flex items-center justify-between border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 rounded-xl w-8 h-8 flex items-center justify-center shadow-lg shadow-indigo-200">
                        <span class="font-black text-white text-lg">P</span>
                    </div>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight">ProTrack<span class="text-indigo-600">.</span></h1>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-all font-medium {{ request()->routeIs('dashboard') ? 'bg-indigo-50/50 text-indigo-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-all font-medium {{ request()->routeIs('projects.*') ? 'bg-indigo-50/50 text-indigo-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    Projects
                </a>
                <a href="{{ route('team-members.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-all font-medium {{ request()->routeIs('team-members.*') ? 'bg-indigo-50/50 text-indigo-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Kelola Tim
                </a>
                <a href="{{ route('report.pin.show') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-all font-medium {{ request()->is('report*') ? 'bg-indigo-50/50 text-indigo-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Reports
                </a>

                <div class="pt-6 pb-2">
                    <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengaturan</p>
                </div>
                <a href="{{ route('master-data.index') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-all font-medium {{ request()->routeIs('master-data.*') ? 'bg-indigo-50/50 text-indigo-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    Master Data
                </a>
            </nav>
        </aside>
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
