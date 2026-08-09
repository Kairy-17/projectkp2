@extends('layouts.app')

@section('content')
@include('partials.sidebar')

<!-- Main Content -->
<main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50/50">
    <!-- Topbar -->
    <header class="h-16 glass flex items-center justify-between px-4 sm:px-6 z-40 sticky top-0">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="md:hidden block shrink-0">
                <img src="{{ asset('icons/logo-new.png') }}" alt="ProTrack Logo" class="h-8 w-auto object-contain">
            </a>
            <h2 class="text-lg sm:text-xl font-semibold">{{ __('Project Reminder') }}</h2>
        </div>
        <div class="flex items-center gap-3">
            @include('partials.notifications')
            <a href="{{ route('team-members.index') }}" class="bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 px-4 py-2 rounded-full text-sm font-medium shadow-sm transition-all hidden sm:flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                {{ __('Kelola Tim') }}
            </a>
            <a href="{{ route('projects.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full text-sm font-medium shadow-sm shadow-indigo-200 transition-all">{{ __('+ New Project') }}</a>
        </div>
    </header>

    <!-- Content scrollable -->
    <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        
        <div class="glass p-4 rounded-2xl shadow-sm mb-6 flex flex-col sm:flex-row gap-4 items-end relative z-30">
            <form action="{{ route('projects.index') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-4 items-end" x-ref="filterForm">
                
                <!-- Custom Dropdown Tahun -->
                <div class="w-full sm:w-auto relative" x-data="{ open: false, selected: '{{ $tahun ?: '' }}', label: '{{ $tahun ?: __('Semua') }}' }">
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Tahun') }}</label>
                    <input type="hidden" name="tahun" x-model="selected">
                    <button type="button" @click="open = !open" @click.away="open = false" 
                            class="w-full sm:w-36 flex items-center justify-between bg-white border border-slate-300 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all hover:border-indigo-400 group">
                        <span x-text="label" class="text-slate-700 group-hover:text-indigo-700 transition-colors"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-hover:text-indigo-500" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" x-cloak 
                         class="absolute z-50 w-full mt-1.5 bg-white border border-slate-100 rounded-xl shadow-xl overflow-hidden py-1">
                        <div @click="selected = ''; label = '{{ __('Semua') }}'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" 
                             class="px-4 py-2.5 text-sm cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors"
                             :class="selected === '' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600'">{{ __('Semua') }}</div>
                        @for($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                            <div @click="selected = '{{ $y }}'; label = '{{ $y }}'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" 
                                 class="px-4 py-2.5 text-sm cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors"
                                 :class="selected === '{{ $y }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600'">{{ $y }}</div>
                        @endfor
                    </div>
                </div>

                <!-- Custom Dropdown Bulan -->
                <div class="w-full sm:w-auto relative" x-data="{ open: false, selected: '{{ $bulan ?: '' }}', label: '{{ $bulan ? __(date('F', mktime(0, 0, 0, $bulan, 10))) : __('Semua') }}' }">
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Bulan') }}</label>
                    <input type="hidden" name="bulan" x-model="selected">
                    <button type="button" @click="open = !open" @click.away="open = false" 
                            class="w-full sm:w-40 flex items-center justify-between bg-white border border-slate-300 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all hover:border-indigo-400 group">
                        <span x-text="label" class="text-slate-700 group-hover:text-indigo-700 transition-colors"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-hover:text-indigo-500" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" x-cloak 
                         class="absolute z-50 w-full mt-1.5 bg-white border border-slate-100 rounded-xl shadow-xl overflow-hidden py-1 max-h-64 overflow-y-auto">
                        <div @click="selected = ''; label = '{{ __('Semua') }}'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" 
                             class="px-4 py-2.5 text-sm cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors"
                             :class="selected === '' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600'">{{ __('Semua') }}</div>
                        @for($m = 1; $m <= 12; $m++)
                            <div @click="selected = '{{ $m }}'; label = '{{ __(date('F', mktime(0, 0, 0, $m, 10))) }}'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" 
                                 class="px-4 py-2.5 text-sm cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors"
                                 :class="selected === '{{ $m }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600'">{{ __(date('F', mktime(0, 0, 0, $m, 10))) }}</div>
                        @endfor
                    </div>
                </div>

                <!-- Custom Dropdown Minggu -->
                <div class="w-full sm:w-auto relative" x-data="{ open: false, selected: '{{ $minggu ?: '' }}', label: '{{ $minggu ? __('Minggu ke-').$minggu : __('Semua') }}' }">
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Minggu') }}</label>
                    <input type="hidden" name="minggu" x-model="selected">
                    <button type="button" @click="open = !open" @click.away="open = false" 
                            class="w-full sm:w-40 flex items-center justify-between bg-white border border-slate-300 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all hover:border-indigo-400 group">
                        <span x-text="label" class="text-slate-700 group-hover:text-indigo-700 transition-colors"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-hover:text-indigo-500" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" x-cloak 
                         class="absolute z-50 w-full mt-1.5 bg-white border border-slate-100 rounded-xl shadow-xl overflow-hidden py-1">
                        <div @click="selected = ''; label = '{{ __('Semua') }}'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" 
                             class="px-4 py-2.5 text-sm cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors"
                             :class="selected === '' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600'">{{ __('Semua') }}</div>
                        @for($w = 1; $w <= 5; $w++)
                            <div @click="selected = '{{ $w }}'; label = '{{ __('Minggu ke-') }}{{ $w }}'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" 
                                 class="px-4 py-2.5 text-sm cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors"
                                 :class="selected === '{{ $w }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600'">{{ __('Minggu ke-') }}{{ $w }}</div>
                        @endfor
                    </div>
                </div>

                <!-- Custom Dropdown Status -->
                <div class="w-full sm:w-auto relative" x-data="{ open: false, selected: '{{ $status ?? '' }}', label: '{{ $status ? __($status) : __('Semua Status') }}' }">
                    <label class="block text-xs font-medium text-slate-500 mb-1">{{ __('Status') }}</label>
                    <input type="hidden" name="status" x-model="selected">
                    <button type="button" @click="open = !open" @click.away="open = false" 
                            class="w-full sm:w-40 flex items-center justify-between bg-white border border-slate-300 px-3 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all hover:border-indigo-400 group">
                        <span x-text="label" class="text-slate-700 group-hover:text-indigo-700 transition-colors"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-hover:text-indigo-500" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-1" x-cloak 
                         class="absolute z-50 w-full mt-1.5 bg-white border border-slate-100 rounded-xl shadow-xl overflow-hidden py-1">
                        <div @click="selected = ''; label = '{{ __('Semua Status') }}'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" 
                             class="px-4 py-2.5 text-sm cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors"
                             :class="selected === '' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600'">{{ __('Semua Status') }}</div>
                        
                        @foreach(['Not yet', 'On going', 'Hold', 'Done'] as $s)
                            <div @click="selected = '{{ $s }}'; label = '{{ __($s) }}'; open = false; setTimeout(() => $el.closest('form').submit(), 50)" 
                                 class="px-4 py-2.5 text-sm cursor-pointer hover:bg-indigo-50 hover:text-indigo-700 transition-colors"
                                 :class="selected === '{{ $s }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600'">{{ __($s) }}</div>
                        @endforeach
                    </div>
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
        <div class="glass rounded-2xl shadow-sm border border-slate-200 overflow-hidden hidden md:block" x-data="{ search: '' }">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-white/50">
                <h3 class="font-semibold text-lg">{{ __('Active Reminders') }}</h3>
                <div class="relative w-64">
                    <input type="text" x-model="search" placeholder="{{ __('Cari nama project...') }}" class="w-full pl-10 pr-4 py-2 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all bg-white">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50/80 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold">{{ __('Project') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('PIC (Tim Terlibat)') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('Status') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('Priority') }}</th>
                            <th class="px-6 py-4 font-semibold">{{ __('Target') }}</th>
                            <th class="px-6 py-4 text-right font-semibold">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white/40">
                        @forelse($projects as $project)
                        <tr class="hover:bg-white/80 transition-colors group" x-show="search === '' || {{ json_encode(strtolower($project->nama_project)) }}.includes(search.toLowerCase())">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-800 block">{{ $project->nama_project }} ({{ $project->project_id }})</span>
                                <div class="text-xs text-slate-500 mt-0.5">{{ $project->durasi_project ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @if(is_array($project->pic))
                                        @foreach($project->pic as $p)
                                            @php
                                                $memberColorData = $teamMembersData[$p] ?? null;
                                                $bg = $memberColorData->warna_bg ?? '#f1f5f9';
                                                $text = $memberColorData->warna_text ?? '#334155';
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold border" style="background-color: {{ $bg }}; color: {{ $text }}; border-color: {{ $bg }};">{{ $p }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-slate-500">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ getStatusColor($project->status_project) }}">{{ __($project->status_project) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ getPriorityColor($project->priority) }}">{{ __($project->priority) }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 font-medium">{{ $project->target_selesai ? \Carbon\Carbon::parse($project->target_selesai)->format('d M Y') : '-' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                    <a href="{{ route('projects.show', $project->id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-lg text-xs font-bold">{{ __('Detail') }}</a>
                                    <a href="{{ route('projects.edit', $project->id) }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 hover:bg-indigo-600 hover:text-white rounded-lg text-xs font-bold">{{ __('Edit') }}</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">{{ __('Belum ada data project.') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile View (Cards) -->
        <div class="md:hidden space-y-4 pb-20" x-data="{ search: '' }">
            <div class="relative w-full mb-4">
                <input type="text" x-model="search" placeholder="{{ __('Cari nama project...') }}" class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all bg-white shadow-sm">
                <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            @forelse($projects as $project)
            <div class="glass p-4 rounded-xl relative border border-slate-100" x-show="search === '' || {{ json_encode(strtolower($project->nama_project)) }}.includes(search.toLowerCase())">
                <div class="absolute top-4 right-4 flex flex-col gap-1 items-end">
                    <span class="px-2 py-1 {{ getPriorityColor($project->priority) }} text-[10px] font-bold rounded uppercase border">{{ __($project->priority) }}</span>
                    <span class="px-2 py-1 {{ getStatusColor($project->status_project) }} text-[10px] font-bold rounded border">{{ __($project->status_project) }}</span>
                </div>
                <a href="{{ route('projects.show', $project->id) }}" class="font-bold text-lg mb-1 pr-20 text-indigo-700 block">{{ $project->nama_project }} ({{ $project->project_id }})</a>
                <p class="text-xs text-slate-500 mb-3">{{ __('Target:') }} {{ $project->target_selesai ? \Carbon\Carbon::parse($project->target_selesai)->format('d M Y') : '-' }}</p>
                <div class="flex items-center justify-between mt-4">
                    <div class="flex flex-wrap gap-1">
                        @if(is_array($project->pic))
                            @foreach($project->pic as $p)
                                @php
                                    $memberColorData = $teamMembersData[$p] ?? null;
                                    $bg = $memberColorData->warna_bg ?? '#f1f5f9';
                                    $text = $memberColorData->warna_text ?? '#334155';
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold border" style="background-color: {{ $bg }}; color: {{ $text }}; border-color: {{ $bg }};">{{ $p }}</span>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="glass p-4 rounded-xl text-center text-slate-500">{{ __('Belum ada data project.') }}</div>
            @endforelse
        </div>

    </div>
</main>

<!-- Bottom Nav for Mobile -->
<nav class="md:hidden fixed bottom-0 w-full glass border-t border-slate-200 flex justify-around p-3 pb-safe z-50">
    <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 text-slate-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span class="text-[10px] font-medium">{{ __('Kembali') }}</span>
    </a>
    <a href="{{ route('projects.index') }}" class="flex flex-col items-center gap-1 text-indigo-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        <span class="text-[10px] font-medium">{{ __('Projects') }}</span>
    </a>
    <a href="{{ route('team-members.index') }}" class="flex flex-col items-center gap-1 text-slate-400">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <span class="text-[10px] font-medium">{{ __('Team') }}</span>
    </a>
</nav>
@endsection
