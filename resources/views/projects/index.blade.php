@extends('layouts.app')

@section('content')
<!-- Sidebar (Desktop) -->
<aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
    <div class="h-16 flex items-center px-6 border-b border-slate-100">
        <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl mr-3">P</div>
        <h1 class="font-bold text-lg tracking-tight">ProTrack.</h1>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard
        </a>
        <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-3 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Project Reminder
        </a>
        <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Reports
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

<!-- Main Content -->
<main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50/50">
    <!-- Topbar -->
    <header class="h-16 glass flex items-center justify-between px-4 sm:px-6 z-10 sticky top-0">
        <div class="flex items-center gap-4">
            <button class="md:hidden p-2 text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-semibold hidden sm:block">Project Reminder</h2>
        </div>
        <div class="flex items-center gap-4">
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full text-sm font-medium shadow-sm shadow-indigo-200 transition-all">+ New Project</button>
        </div>
    </header>

    <!-- Content scrollable -->
    <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="glass p-5 rounded-2xl shadow-sm">
                <p class="text-sm text-slate-500 font-medium mb-1">Total Projects</p>
                <p class="text-3xl font-bold text-slate-800">{{ $projects->count() }}</p>
            </div>
            <div class="glass p-5 rounded-2xl shadow-sm border-l-4 border-amber-400">
                <p class="text-sm text-slate-500 font-medium mb-1">On Going</p>
                <p class="text-3xl font-bold text-slate-800">{{ $projects->where('status_project', 'On going')->count() }}</p>
            </div>
            <div class="glass p-5 rounded-2xl shadow-sm border-l-4 border-slate-400">
                <p class="text-sm text-slate-500 font-medium mb-1">Hold / Not Yet</p>
                <p class="text-3xl font-bold text-slate-800">{{ $projects->whereIn('status_project', ['Hold', 'Not yet'])->count() }}</p>
            </div>
            <div class="glass p-5 rounded-2xl shadow-sm border-l-4 border-emerald-400">
                <p class="text-sm text-slate-500 font-medium mb-1">Done</p>
                <p class="text-3xl font-bold text-slate-800">{{ $projects->where('status_project', 'Done')->count() }}</p>
            </div>
        </div>

        <!-- Table Section (Desktop) -->
        <div class="glass rounded-2xl shadow-sm border border-slate-200 overflow-hidden hidden md:block">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-white/50">
                <h3 class="font-semibold text-lg">Active Reminders</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50/80 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Project</th>
                            <th class="px-6 py-4 font-semibold">PIC</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold">Priority</th>
                            <th class="px-6 py-4 font-semibold">Target</th>
                            <th class="px-6 py-4 text-right font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white/40">
                        @forelse($projects as $project)
                        <tr class="hover:bg-white/80 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $project->nama_project }} ({{ $project->project_id }})</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $project->durasi_project ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">{{ substr($project->pic ?? 'U', 0, 1) }}</div>
                                    <span>{{ $project->pic }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">{{ $project->status_project }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">{{ $project->priority }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $project->target_selesai ? \Carbon\Carbon::parse($project->target_selesai)->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-indigo-600 hover:text-indigo-900 opacity-0 group-hover:opacity-100 transition-opacity">Edit</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada data project.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4 pb-20">
            @forelse($projects as $project)
            <div class="glass p-4 rounded-xl relative">
                <div class="absolute top-4 right-4"><span class="px-2 py-1 bg-slate-100 text-slate-700 text-[10px] font-bold rounded uppercase">{{ $project->priority }}</span></div>
                <h4 class="font-bold text-lg mb-1 pr-12">{{ $project->nama_project }} ({{ $project->project_id }})</h4>
                <p class="text-xs text-slate-500 mb-3">Target: {{ $project->target_selesai ? \Carbon\Carbon::parse($project->target_selesai)->format('d M Y') : '-' }}</p>
                <div class="flex items-center justify-between mt-4">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold">{{ substr($project->pic ?? 'U', 0, 1) }}</div>
                        <span class="text-sm font-medium">{{ $project->pic }}</span>
                    </div>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-700">{{ $project->status_project }}</span>
                </div>
            </div>
            @empty
            <div class="glass p-4 rounded-xl text-center text-slate-500">Belum ada data project.</div>
            @endforelse
        </div>

    </div>
</main>

<!-- Bottom Nav for Mobile -->
<nav class="md:hidden fixed bottom-0 w-full glass border-t border-slate-200 flex justify-around p-3 pb-safe z-50">
    <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 text-slate-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        <span class="text-[10px] font-medium">Home</span>
    </a>
    <a href="{{ route('projects.index') }}" class="flex flex-col items-center gap-1 text-indigo-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        <span class="text-[10px] font-medium">Projects</span>
    </a>
    <a href="{{ route('reports.index') }}" class="flex flex-col items-center gap-1 text-slate-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <span class="text-[10px] font-medium">Reports</span>
    </a>
</nav>
@endsection
