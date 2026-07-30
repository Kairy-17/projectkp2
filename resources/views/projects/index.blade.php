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
        <a href="{{ route('team-members.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Kelola Tim
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
            <a href="{{ route('projects.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full text-sm font-medium shadow-sm shadow-indigo-200 transition-all">+ New Project</a>
        </div>
    </header>

    <!-- Content scrollable -->
    <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        
        <div class="glass p-4 rounded-2xl shadow-sm mb-6 flex flex-col sm:flex-row gap-4 items-end">
            <form action="{{ route('projects.index') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-4 items-end">
                <div class="w-full sm:w-auto">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Tahun</label>
                    <select name="tahun" onchange="this.form.submit()" class="w-full sm:w-32 rounded-lg border-slate-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua</option>
                        @for($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Bulan</label>
                    <select name="bulan" onchange="this.form.submit()" class="w-full sm:w-32 rounded-lg border-slate-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Minggu</label>
                    <select name="minggu" onchange="this.form.submit()" class="w-full sm:w-32 rounded-lg border-slate-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Semua</option>
                        @for($w = 1; $w <= 5; $w++)
                            <option value="{{ $w }}" {{ $minggu == $w ? 'selected' : '' }}>Minggu ke-{{ $w }}</option>
                        @endfor
                    </select>
                </div>
            </form>
        </div>

        @php
            function getStatusColor($status) {
                switch($status) {
                    case 'Not yet': return 'bg-red-100 text-red-700 border-red-200';
                    case 'On going': return 'bg-blue-100 text-blue-700 border-blue-200';
                    case 'Hold': return 'bg-yellow-100 text-yellow-700 border-yellow-200';
                    case 'Done': return 'bg-green-100 text-green-700 border-green-200';
                    default: return 'bg-slate-100 text-slate-700 border-slate-200';
                }
            }
            function getPriorityColor($priority) {
                switch($priority) {
                    case 'High': return 'bg-rose-100 text-rose-700 border-rose-200';
                    case 'Medium': return 'bg-amber-100 text-amber-700 border-amber-200';
                    case 'Low': return 'bg-cyan-100 text-cyan-700 border-cyan-200';
                    default: return 'bg-slate-100 text-slate-700 border-slate-200';
                }
            }
        @endphp

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
                            <th class="px-6 py-4 font-semibold">PIC (Tim Terlibat)</th>
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
                                <a href="{{ route('projects.show', $project->id) }}" class="font-bold text-indigo-700 hover:text-indigo-900 block">{{ $project->nama_project }} ({{ $project->project_id }})</a>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $project->durasi_project ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if(is_array($project->pic))
                                        @foreach($project->pic as $p)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-slate-100 text-slate-700">{{ $p }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-slate-500">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ getStatusColor($project->status_project) }}">{{ $project->status_project }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ getPriorityColor($project->priority) }}">{{ $project->priority }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">{{ $project->target_selesai ? \Carbon\Carbon::parse($project->target_selesai)->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('projects.edit', $project->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white rounded-lg text-xs font-bold opacity-0 group-hover:opacity-100 transition-all">Detail / Edit</a>
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
            <div class="glass p-4 rounded-xl relative border border-slate-100">
                <div class="absolute top-4 right-4 flex flex-col gap-1 items-end">
                    <span class="px-2 py-1 {{ getPriorityColor($project->priority) }} text-[10px] font-bold rounded uppercase border">{{ $project->priority }}</span>
                    <span class="px-2 py-1 {{ getStatusColor($project->status_project) }} text-[10px] font-bold rounded border">{{ $project->status_project }}</span>
                </div>
                <a href="{{ route('projects.show', $project->id) }}" class="font-bold text-lg mb-1 pr-20 text-indigo-700 block">{{ $project->nama_project }} ({{ $project->project_id }})</a>
                <p class="text-xs text-slate-500 mb-3">Target: {{ $project->target_selesai ? \Carbon\Carbon::parse($project->target_selesai)->format('d M Y') : '-' }}</p>
                <div class="flex items-center justify-between mt-4">
                    <div class="flex flex-wrap gap-1">
                        @if(is_array($project->pic))
                            @foreach($project->pic as $p)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-slate-100 text-slate-700">{{ $p }}</span>
                            @endforeach
                        @endif
                    </div>
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
    <a href="{{ route('team-members.index') }}" class="flex flex-col items-center gap-1 text-slate-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <span class="text-[10px] font-medium">Team</span>
    </a>
    <a href="{{ route('reports.index') }}" class="flex flex-col items-center gap-1 text-slate-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <span class="text-[10px] font-medium">Reports</span>
    </a>
</nav>
@endsection
