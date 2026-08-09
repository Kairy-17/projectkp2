@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50">
    <header class="h-16 glass flex items-center px-6 z-10 sticky top-0 border-b border-slate-200 justify-between">
        <div class="flex items-center">
            <a href="{{ route('reports.index') }}" class="text-slate-500 hover:text-indigo-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-xl font-semibold">Dokumen: {{ $report->klien }} ({{ $report->tahun }})</h2>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-12">
        <!-- Brankas Dokumen Section -->
        <div class="max-w-4xl mx-auto glass p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200" x-data="{ tab: 'file', search: '', previewModal: false, previewUrl: '', previewType: '', previewTitle: '' }">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    Brankas Dokumen Laporan
                </h3>
            </div>

            <!-- Upload Form -->
            <div class="bg-white p-5 rounded-xl border border-slate-200 mb-6 shadow-sm">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 text-red-600 p-3 rounded-lg text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="mb-4 bg-emerald-50 text-emerald-600 p-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="flex border-b border-slate-200 mb-4">
                    <button type="button" @click="tab = 'file'" :class="tab == 'file' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500'" class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">Upload File (PDF/Word)</button>
                    <button type="button" @click="tab = 'link'" :class="tab == 'link' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-slate-500'" class="px-4 py-2 border-b-2 font-medium text-sm transition-colors">Simpan Link</button>
                </div>

                <form action="{{ route('report-attachments.store') }}" method="POST" enctype="multipart/form-data" x-show="tab == 'file'">
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $report->id }}">
                    <input type="hidden" name="tipe" value="file">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Judul Dokumen</label>
                            <input type="text" name="judul_dokumen" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Pilih File <span class="text-xs text-slate-400 font-normal">(Maks: 2MB)</span></label>
                            <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg" class="w-full rounded-lg border-slate-300 border px-3 py-1.5 text-sm file:mr-4 file:py-1 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm">Upload File</button>
                </form>

                <form action="{{ route('report-attachments.store') }}" method="POST" x-show="tab == 'link'" x-cloak>
                    @csrf
                    <input type="hidden" name="report_id" value="{{ $report->id }}">
                    <input type="hidden" name="tipe" value="link">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Judul Dokumen / Judul Link</label>
                            <input type="text" name="judul_dokumen" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">URL (Tautan)</label>
                            <input type="url" name="url" class="w-full rounded-lg border-slate-300 border px-3 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="https://" required>
                        </div>
                    </div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm">Simpan Link</button>
                </form>
            </div>

            <!-- List Documents -->
            <div class="mb-4 relative flex items-center">
                <svg class="w-5 h-5 text-slate-400 absolute left-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" x-model="search" placeholder="Cari dokumen berdasarkan judul..." class="w-full rounded-xl border-slate-200 border pl-10 pr-4 py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-white/50">
            </div>

            <div class="space-y-3">
                @forelse($report->attachments ?? [] as $attachment)
                <div class="bg-white border border-slate-100 p-4 rounded-xl shadow-sm flex items-center justify-between transition-all hover:shadow-md" x-show="search === '' || '{{ strtolower(addslashes($attachment->judul_dokumen)) }}'.includes(search.toLowerCase())">
                    <div class="flex items-center gap-4 overflow-hidden">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 {{ $attachment->tipe == 'file' ? 'bg-red-50 text-red-500' : 'bg-blue-50 text-blue-500' }}">
                            @if($attachment->tipe == 'file')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            @endif
                        </div>
                        <div class="truncate">
                            <h4 class="font-bold text-slate-800 text-sm truncate">{{ $attachment->judul_dokumen }}</h4>
                            <p class="text-xs text-slate-500 truncate">{{ $attachment->tipe == 'file' ? 'Dokumen / File' : 'Tautan Eksternal' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0 ml-4">
                        @if($attachment->tipe == 'file')
                            @php
                                $ext = strtolower(pathinfo($attachment->path_atau_url, PATHINFO_EXTENSION));
                                $isOffice = in_array($ext, ['doc', 'docx', 'xls', 'xlsx']);
                                $fileUrl = asset(Storage::url($attachment->path_atau_url));
                            @endphp
                            <button type="button" @click="previewUrl = '{{ $isOffice ? 'https://docs.google.com/gview?url=' . urlencode($fileUrl) . '&embedded=true' : $fileUrl }}'; previewType = '{{ $isOffice ? 'office' : 'native' }}'; previewTitle = '{{ addslashes($attachment->judul_dokumen) }}'; previewModal = true" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="{{ __('Preview File') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            <a href="{{ Storage::url($attachment->path_atau_url) }}" download class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="{{ __('Download File') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </a>
                        @else
                            <a href="{{ $attachment->path_atau_url }}" target="_blank" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Buka Tautan">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        @endif
                        
                        <form action="{{ route('report-attachments.destroy', $attachment->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center p-12 bg-white/50 rounded-xl border border-dashed border-slate-300">
                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p class="text-sm text-slate-500 font-medium">Brankas kosong. Belum ada dokumen yang disimpan.</p>
                </div>
                @endforelse
            </div>

            <!-- Preview Modal -->
            <div x-show="previewModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4" x-cloak>
                <div @click.away="previewModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-5xl h-[85vh] flex flex-col overflow-hidden transform transition-all">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-lg truncate pr-4" x-text="previewTitle"></h3>
                        <button @click="previewModal = false" class="text-slate-400 hover:text-slate-700 bg-white hover:bg-slate-200 p-2 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <!-- Modal Body -->
                    <div class="flex-1 bg-slate-100 p-2 relative">
                        <template x-if="previewUrl">
                            <iframe :src="previewUrl" class="w-full h-full rounded-xl shadow-inner border border-slate-200 bg-white" frameborder="0"></iframe>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
