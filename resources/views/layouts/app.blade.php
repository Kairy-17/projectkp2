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
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-indigo-100 selection:text-indigo-900 h-screen overflow-hidden">
    
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
