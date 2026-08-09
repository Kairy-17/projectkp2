@extends('layouts.app')

@section('content')
@include('partials.sidebar')

<!-- Main Content -->
<main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50/50">
    <!-- Topbar -->
    <header class="h-16 glass flex items-center justify-between px-4 sm:px-6 z-40 sticky top-0">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="md:hidden block shrink-0">
                <img src="{{ asset('icons/logo-new.png') }}" alt="ProTrack Logo" class="h-8 w-auto object-contain">
            </a>
            <h2 class="text-lg sm:text-xl font-semibold">{{ __('Laporan Kinerja') }}</h2>
        </div>
        <div class="flex items-center gap-4">
            @include('partials.notifications')
            <a href="{{ route('general-attachments.index') }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 p-2 sm:px-4 sm:py-2 rounded-full text-sm font-medium transition-all flex items-center gap-1" title="{{ __('Brankas Umum') }}">
                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                <span class="hidden sm:inline">{{ __('Brankas Umum') }}</span>
            </a>
            <a href="{{ route('master-data.index') }}" class="bg-amber-100 hover:bg-amber-200 text-amber-700 p-2 sm:px-4 sm:py-2 rounded-full text-sm font-medium transition-all flex items-center gap-1" title="{{ __('Master Data') }}">
                <svg class="w-5 h-5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="hidden sm:inline">{{ __('Master Data') }}</span>
            </a>
            <a href="{{ route('reports.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white p-2 sm:px-4 sm:py-2 rounded-full text-sm font-medium shadow-sm shadow-emerald-200 transition-all flex items-center justify-center min-w-[36px] min-h-[36px]" title="{{ __('+ New Report') }}">
                <span class="sm:hidden font-bold leading-none text-lg">+</span>
                <span class="hidden sm:inline">{{ __('+ New Report') }}</span>
            </a>
        </div>
    </header>

    <!-- Content scrollable -->
    <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        
        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="glass p-5 rounded-2xl shadow-sm">
                <p class="text-sm text-slate-500 font-medium mb-1">{{ __('Total Reports') }}</p>
                <p class="text-3xl font-bold text-slate-800">{{ $reports->count() }}</p>
            </div>
            <div class="glass p-5 rounded-2xl shadow-sm border-l-4 border-emerald-400">
                <p class="text-sm text-slate-500 font-medium mb-1">{{ __('Avg Margin') }}</p>
                <p class="text-3xl font-bold text-slate-800">{{ number_format($reports->avg('margin_persen'), 1) }}%</p>
            </div>
            <div class="glass p-5 rounded-2xl shadow-sm border-l-4 border-emerald-500">
                <p class="text-sm text-slate-500 font-medium mb-1">{{ __('Total Nilai Proyek') }}</p>
                <p class="text-2xl font-bold text-slate-800 text-emerald-600">Rp {{ number_format($reports->sum('nilai_proyek'), 0, ',', '.') }}</p>
            </div>
            <div class="glass p-5 rounded-2xl shadow-sm border-l-4 border-blue-500">
                <p class="text-sm text-slate-500 font-medium mb-1">{{ __('Total Real Income') }}</p>
                <p class="text-2xl font-bold text-slate-800 text-blue-600">Rp {{ number_format($reports->sum('real_income'), 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Table Section (Desktop) -->
        <div class="glass rounded-2xl shadow-sm border border-slate-200 overflow-hidden hidden md:block" x-data="{ search: '' }">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-white/50">
                <h3 class="font-semibold text-lg">{{ __('Data Laporan Proyek') }}</h3>
                <div class="relative w-64">
                    <input type="text" x-model="search" placeholder="{{ __('Cari nama klien...') }}" class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all bg-white">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50/80 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold">{{ __('Klien / Tahun') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('Industri') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('Nilai Proyek') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('Real Income') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('Margin (%)') }}</th>
                            <th class="px-6 py-4 text-right font-semibold">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white/40">
                        @forelse($reports as $report)
                        <tr class="hover:bg-white/80 transition-colors group" x-show="search === '' || {{ json_encode(strtolower($report->klien)) }}.includes(search.toLowerCase())">
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
                            <td class="px-6 py-4 text-right flex justify-end gap-2">
                                <a href="{{ route('reports.attachments.index', $report->id) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white rounded-lg text-xs font-bold opacity-0 group-hover:opacity-100 transition-all">{{ __('Dokumen') }} ({{ $report->attachments->count() }})</a>
                                <a href="{{ route('reports.edit', $report->id) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 hover:bg-emerald-600 hover:text-white rounded-lg text-xs font-bold opacity-0 group-hover:opacity-100 transition-all">{{ __('Detail / Edit') }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">{{ __('Belum ada data laporan.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4 pb-20" x-data="{ search: '' }">
            <div class="relative w-full mb-4">
                <input type="text" x-model="search" placeholder="{{ __('Cari nama klien...') }}" class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all bg-white shadow-sm">
                <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            @forelse($reports as $report)
            <div class="glass p-4 rounded-xl relative" x-show="search === '' || {{ json_encode(strtolower($report->klien)) }}.includes(search.toLowerCase())">
                <div class="absolute top-4 right-4"><span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded">{{ number_format($report->margin_persen, 1) }}% {{ __('Margin') }}</span></div>
                <h4 class="font-bold text-lg mb-1 pr-24">{{ $report->klien }}</h4>
                <p class="text-xs text-slate-500 mb-3">{{ $report->tahun }} • {{ $report->industri }}</p>
                
                <div class="grid grid-cols-2 gap-2 mt-4 text-sm">
                    <div class="bg-slate-50 p-2 rounded">
                        <p class="text-[10px] text-slate-500 uppercase">{{ __('Nilai Proyek') }}</p>
                        <p class="font-medium text-slate-700">Rp {{ number_format($report->nilai_proyek/1000000, 1, ',', '.') }} {{ __('Juta') }}</p>
                    </div>
                    <div class="bg-blue-50 p-2 rounded">
                        <p class="text-[10px] text-blue-500 uppercase">{{ __('Real Income') }}</p>
                        <p class="font-medium text-blue-700">Rp {{ number_format($report->real_income/1000000, 1, ',', '.') }} {{ __('Juta') }}</p>
                    </div>
                </div>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('reports.attachments.index', $report->id) }}" class="flex-1 text-center py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors rounded text-xs font-bold">{{ __('Dokumen') }} ({{ $report->attachments->count() }})</a>
                    <a href="{{ route('reports.edit', $report->id) }}" class="flex-1 text-center py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors rounded text-xs font-bold">{{ __('Detail / Edit') }}</a>
                </div>
            </div>
            @empty
            <div class="glass p-4 rounded-xl text-center text-slate-500">{{ __('Belum ada data laporan.') }}</div>
            @endforelse
    </div>
</main>

<!-- Bottom Nav for Mobile -->
<nav class="md:hidden fixed bottom-0 w-full glass border-t border-slate-200 flex justify-around p-3 pb-safe z-50">
    <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 text-slate-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span class="text-[10px] font-medium">{{ __('Kembali') }}</span>
    </a>
    <a href="{{ route('reports.index') }}" class="flex flex-col items-center gap-1 text-emerald-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        <span class="text-[10px] font-medium">{{ __('Reports') }}</span>
    </a>
</nav>
@endsection
