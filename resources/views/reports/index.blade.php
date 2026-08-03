@extends('layouts.app')

@section('content')
<!-- Sidebar (Desktop) -->
<aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
    <div class="h-16 flex items-center px-6 border-b border-slate-100">
        <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-bold text-xl mr-3">P</div>
        <h1 class="font-bold text-lg tracking-tight">ProTrack.</h1>
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">

        <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Project Reminder
        </a>
        <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 bg-emerald-50 text-emerald-600 rounded-xl font-medium transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Reports
        </a>
    </nav>
    <div class="p-4 border-t border-slate-100">
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name=Admin+User&background=ecfdf5&color=059669" class="w-10 h-10 rounded-full" alt="User">
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
    <header class="h-16 glass flex items-center justify-between px-4 sm:px-6 z-40 sticky top-0">
        <div class="flex items-center gap-4">
            <button class="md:hidden p-2 text-slate-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h2 class="text-xl font-semibold hidden sm:block">Laporan Kinerja</h2>
        </div>
        <div class="flex items-center gap-4">
            @include('partials.notifications')
            <a href="{{ route('reports.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-full text-sm font-medium shadow-sm shadow-emerald-200 transition-all">+ New Report</a>
        </div>
    </header>

    <!-- Content scrollable -->
    <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="glass p-5 rounded-2xl shadow-sm">
                <p class="text-sm text-slate-500 font-medium mb-1">Total Reports</p>
                <p class="text-3xl font-bold text-slate-800">{{ $reports->count() }}</p>
            </div>
            <div class="glass p-5 rounded-2xl shadow-sm border-l-4 border-emerald-400">
                <p class="text-sm text-slate-500 font-medium mb-1">Avg Margin</p>
                <p class="text-3xl font-bold text-slate-800">{{ number_format($reports->avg('margin_persen'), 1) }}%</p>
            </div>
            <div class="glass p-5 rounded-2xl shadow-sm border-l-4 border-emerald-500">
                <p class="text-sm text-slate-500 font-medium mb-1">Total Nilai Proyek</p>
                <p class="text-2xl font-bold text-slate-800 text-emerald-600">Rp {{ number_format($reports->sum('nilai_proyek'), 0, ',', '.') }}</p>
            </div>
            <div class="glass p-5 rounded-2xl shadow-sm border-l-4 border-blue-500">
                <p class="text-sm text-slate-500 font-medium mb-1">Total Real Income</p>
                <p class="text-2xl font-bold text-slate-800 text-blue-600">Rp {{ number_format($reports->sum('real_income'), 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Table Section (Desktop) -->
        <div class="glass rounded-2xl shadow-sm border border-slate-200 overflow-hidden hidden md:block">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-white/50">
                <h3 class="font-semibold text-lg">Data Laporan Proyek</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50/80 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Klien / Tahun</th>
                            <th class="px-6 py-4 font-semibold">Industri</th>
                            <th class="px-6 py-4 font-semibold">Nilai Proyek</th>
                            <th class="px-6 py-4 font-semibold">Real Income</th>
                            <th class="px-6 py-4 font-semibold">Margin (%)</th>
                            <th class="px-6 py-4 text-right font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white/40">
                        @forelse($reports as $report)
                        <tr class="hover:bg-white/80 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-900">{{ $report->klien }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $report->tahun }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">{{ $report->industri ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-slate-700">Rp {{ number_format($report->nilai_proyek, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 font-medium text-blue-600">Rp {{ number_format($report->real_income, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-emerald-600 font-bold">{{ number_format($report->margin_persen, 1) }}%</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('reports.edit', $report->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-lg text-xs font-bold opacity-0 group-hover:opacity-100 transition-all">Detail / Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">Belum ada data laporan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4 pb-20">
            @forelse($reports as $report)
            <div class="glass p-4 rounded-xl relative">
                <div class="absolute top-4 right-4"><span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded">{{ number_format($report->margin_persen, 1) }}% Margin</span></div>
                <h4 class="font-bold text-lg mb-1 pr-24">{{ $report->klien }}</h4>
                <p class="text-xs text-slate-500 mb-3">{{ $report->tahun }} • {{ $report->industri }}</p>
                
                <div class="grid grid-cols-2 gap-2 mt-4 text-sm">
                    <div class="bg-slate-50 p-2 rounded">
                        <p class="text-[10px] text-slate-500 uppercase">Nilai Proyek</p>
                        <p class="font-medium text-slate-700">Rp {{ number_format($report->nilai_proyek/1000000, 1, ',', '.') }} Juta</p>
                    </div>
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-[10px] text-blue-500 uppercase">Real Income</p>
                        <p class="font-medium text-blue-700">Rp {{ number_format($report->real_income/1000000, 1, ',', '.') }} Juta</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="glass p-4 rounded-xl text-center text-slate-500">Belum ada data laporan.</div>
            @endforelse
        </div>

    </div>
</main>

<!-- Bottom Nav for Mobile -->
<nav class="md:hidden fixed bottom-0 w-full glass border-t border-slate-200 flex justify-around p-3 pb-safe z-50">

    <a href="{{ route('projects.index') }}" class="flex flex-col items-center gap-1 text-slate-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        <span class="text-[10px] font-medium">Projects</span>
    </a>
    <a href="{{ route('reports.index') }}" class="flex flex-col items-center gap-1 text-emerald-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <span class="text-[10px] font-medium">Reports</span>
    </a>
</nav>
@endsection
