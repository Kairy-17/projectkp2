<!-- Sidebar (Desktop) -->
<aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col z-10">
    <div class="h-16 flex items-center px-6 border-b border-slate-100">
        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl mr-3">P</div>
        <h1 class="font-bold text-lg tracking-tight">ProTrack.</h1>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        @if(request()->routeIs('projects.*'))
        <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-3 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Project Reminder
        </a>
        @endif
        @if(request()->is('report*') || request()->routeIs('master-data.*') || request()->routeIs('general-attachments.*'))
        <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->is('report*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Reports
        </a>
        @endif
        
        <a href="{{ route('general-attachments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium transition-colors {{ request()->routeIs('general-attachments.*') ? 'bg-amber-50 text-amber-600' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
            Brankas Umum
        </a>
    </nav>
    <div class="p-4 border-t border-slate-100">
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name=Admin+User&background=eff6ff&color=4f46e5" class="w-10 h-10 rounded-full" alt="User">
            <div>
                <p class="text-sm font-semibold">Admin User</p>
                <p class="text-xs text-slate-500">admin@company.com</p>
            </div>
        </div>
    </div>
</aside>
