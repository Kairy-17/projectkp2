@extends('layouts.app')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }
</style>
<main class="flex-1 flex flex-col h-full overflow-hidden bg-gradient-to-br from-slate-50 to-indigo-50/30">
    <!-- Header with Logout -->
    <header class="w-full px-6 py-4 flex justify-between items-center glass border-b border-white/40 z-10 shrink-0">
        <div class="flex items-center gap-3">
            @php
                $userName = request()->cookie('protrack_user_name') ?: 'Tim ProTrack';
            @endphp
            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg shadow-inner">
                {{ substr($userName, 0, 1) }}
            </div>
            <div class="hidden sm:block">
                <p class="text-sm text-slate-500 font-medium leading-tight">{{ __('Selamat datang,') }}</p>
                <p class="text-slate-800 font-semibold">{{ $userName }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <!-- Language Switcher -->
            <div class="flex items-center bg-white/50 rounded-lg p-1 border border-slate-200/60 shadow-sm">
                <a href="{{ route('lang.switch', 'id') }}" class="px-2.5 py-1 text-xs font-medium rounded-md transition-colors {{ session('locale', 'id') == 'id' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">ID</a>
                <a href="{{ route('lang.switch', 'en') }}" class="px-2.5 py-1 text-xs font-medium rounded-md transition-colors {{ session('locale') == 'en' ? 'bg-white shadow-sm text-indigo-600' : 'text-slate-500 hover:text-slate-700' }}">EN</a>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-rose-600 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="hidden sm:inline">{{ __('Logout') }}</span>
                </button>
            </form>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto p-6 md:p-12 flex flex-col items-center relative">
        
        <div class="my-auto w-full max-w-4xl flex flex-col items-center py-4">
            <div class="text-center mb-12 animate-fade-in-up">
                <img src="{{ asset('icons/logo-new.png') }}" alt="ProTrack Logo" class="h-24 w-auto object-contain mx-auto mb-6 drop-shadow-md">
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-2">{{ __('Welcome to ProTrack') }}</h1>
                <p class="text-slate-500">{{ __('Akses fitur ProTrack untuk mengelola proyek dan menganalisis kinerja.') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
            <!-- Project Reminder Module -->
            <a href="{{ route('projects.index') }}" class="animate-fade-in-up delay-100 glass p-8 md:p-10 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden border border-slate-200/60">
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
            <a href="{{ route('reports.index') }}" class="animate-fade-in-up delay-200 glass p-8 md:p-10 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden border border-slate-200/60">
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
    </div>
</main>
@endsection
