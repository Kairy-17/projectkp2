@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50">
    <header class="h-16 glass flex items-center px-6 z-10 sticky top-0 border-b border-slate-200 justify-between">
        <div class="flex items-center">
            <a href="{{ route('projects.index') }}" class="text-slate-500 hover:text-indigo-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-xl font-semibold">Detail Project</h2>
        </div>
        <div>
            <div class="flex items-center gap-4">
                @include('partials.notifications')
                <a href="{{ route('projects.edit', $project->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">Edit Project</a>
            </div>
        </div>
    </header>

    @php
        function showStatusColor($status) {
            switch($status) {
                case 'Not yet': return 'bg-red-100 text-red-700 border-red-200';
                case 'On going': return 'bg-blue-100 text-blue-700 border-blue-200';
                case 'Hold': return 'bg-yellow-100 text-yellow-700 border-yellow-200';
                case 'Done': return 'bg-green-100 text-green-700 border-green-200';
                default: return 'bg-slate-100 text-slate-700 border-slate-200';
            }
        }
        function showPriorityColor($priority) {
            switch($priority) {
                case 'High': return 'bg-rose-100 text-rose-700 border-rose-200';
                case 'Medium': return 'bg-amber-100 text-amber-700 border-amber-200';
                case 'Low': return 'bg-cyan-100 text-cyan-700 border-cyan-200';
                default: return 'bg-slate-100 text-slate-700 border-slate-200';
            }
        }
    @endphp

    <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        <div class="max-w-4xl mx-auto glass p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-6 pb-6 border-b border-slate-100">
                <div>
                    <div class="text-sm text-slate-500 font-medium mb-1">ID: {{ $project->project_id }}</div>
                    <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $project->nama_project }}</h1>
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ showStatusColor($project->status_project) }}">{{ $project->status_project }}</span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ showPriorityColor($project->priority) }}">{{ $project->priority }} Priority</span>
                    </div>
                </div>
                <div class="flex flex-col sm:items-end gap-1">
                    <div class="text-sm text-slate-500">Tahun: <span class="font-semibold text-slate-700">{{ $project->tahun ?? '-' }}</span></div>
                    <div class="text-sm text-slate-500">Bulan: <span class="font-semibold text-slate-700">{{ $project->bulan ? date('F', mktime(0,0,0,$project->bulan,10)) : '-' }}</span></div>
                    <div class="text-sm text-slate-500">Minggu: <span class="font-semibold text-slate-700">{{ $project->minggu ? 'Minggu ke-'.$project->minggu : '-' }}</span></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kiri -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Singkat</h3>
                        <p class="text-slate-700 leading-relaxed">{{ $project->deskripsi_singkat ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">PIC (Tim Terlibat)</h3>
                        <div class="flex flex-wrap gap-2">
                            @if(is_array($project->pic) && count($project->pic) > 0)
                                @foreach($project->pic as $p)
                                    @php
                                        $memberColorData = $teamMembersData[$p] ?? null;
                                        $bg = $memberColorData->warna_bg ?? '#e0e7ff';
                                        $text = $memberColorData->warna_text ?? '#4f46e5';
                                    @endphp
                                    <div class="flex items-center gap-2 bg-white border px-3 py-1.5 rounded-lg shadow-sm" style="border-color: {{ $bg }}">
                                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" style="background-color: {{ $bg }}; color: {{ $text }};">{{ substr($p, 0, 1) }}</div>
                                        <span class="font-bold text-sm" style="color: {{ $text }};">{{ $p }}</span>
                                    </div>
                                @endforeach
                            @else
                                <span class="text-slate-500 italic text-sm">Belum ada tim yang ditugaskan.</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">Durasi & Timeline</h3>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-3 text-sm">
                            <div class="flex justify-between border-b border-slate-200 pb-2">
                                <span class="text-slate-500">Durasi Project</span>
                                <span class="font-medium text-slate-800">{{ $project->durasi_project ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-200 pb-2">
                                <span class="text-slate-500">Tanggal Mulai</span>
                                <span class="font-medium text-slate-800">{{ $project->tanggal_mulai ? \Carbon\Carbon::parse($project->tanggal_mulai)->format('d M Y') : '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Target Selesai</span>
                                <span class="font-medium text-slate-800">{{ $project->target_selesai ? \Carbon\Carbon::parse($project->target_selesai)->format('d M Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kanan -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">Progress</h3>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-indigo-700">{{ $project->progress ?? 0 }}% Selesai</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2.5">
                            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $project->progress ?? 0 }}%"></div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-2">Informasi Tambahan</h3>
                        <div class="space-y-4">
                            <div>
                                <span class="block text-xs font-medium text-slate-500">Tahap Saat Ini (Milestone)</span>
                                <p class="text-sm text-slate-800 mt-0.5 bg-slate-50 p-2 rounded border border-slate-100">{{ $project->milestone_saat_ini ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-slate-500">Tindakan Selanjutnya (Next Action)</span>
                                <p class="text-sm text-slate-800 mt-0.5 bg-slate-50 p-2 rounded border border-slate-100">{{ $project->next_action ?? '-' }}</p>
                            </div>
                            <div>
                                <span class="block text-xs font-medium text-slate-500">Kendala / Hambatan</span>
                                <p class="text-sm text-red-600 mt-0.5 bg-red-50 p-2 rounded border border-red-100">{{ $project->kendala_issue ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</main>
@endsection
