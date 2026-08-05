@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-screen overflow-hidden bg-gradient-to-br from-slate-50 to-indigo-50/30">
    <div class="flex-1 overflow-y-auto p-6 md:p-12 flex flex-col items-center justify-center">
        
        <div class="text-center mb-12">
            <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center text-white font-bold text-3xl mx-auto mb-6 shadow-lg shadow-indigo-200">P</div>
            <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-2">{{ __('Welcome to ProTrack') }}</h1>
            <p class="text-slate-500">{{ __('Pilih modul yang ingin Anda buka hari ini.') }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full max-w-4xl">
            <!-- Project Reminder Module -->
            <a href="{{ route('projects.index') }}" class="glass p-8 md:p-10 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden border border-slate-200/60">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-100 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-3 group-hover:text-indigo-600 transition-colors">{{ __('Project Reminder') }}</h2>
                    <p class="text-slate-500 mb-6 line-clamp-2">{{ __('Pantau status, timeline, dan deadline dari seluruh proyek yang sedang berjalan.') }}</p>
                    <div class="flex items-center text-indigo-600 font-medium text-sm">
                        {{ __('Buka Modul') }} <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
            </a>

            <!-- Report Module -->
            <a href="{{ route('reports.index') }}" class="glass p-8 md:p-10 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden border border-slate-200/60">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-100 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-800 mb-3 group-hover:text-emerald-600 transition-colors">{{ __('Laporan Kinerja') }}</h2>
                    <p class="text-slate-500 mb-6 line-clamp-2">{{ __('Lihat data finansial, margin, dan analisis performa dari setiap proyek.') }}</p>
                    <div class="flex items-center text-emerald-600 font-medium text-sm">
                        {{ __('Buka Modul') }} <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</main>
@endsection
