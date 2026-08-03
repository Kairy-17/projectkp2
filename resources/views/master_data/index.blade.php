@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
    <header class="h-16 glass flex items-center px-6 z-10 sticky top-0 border-b border-slate-200">
        <h2 class="text-xl font-semibold">Master Data</h2>
    </header>

    <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        <div class="max-w-6xl mx-auto space-y-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Industri -->
                <div class="glass rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Kategori Industri</h3>
                        <form action="{{ route('master-data.industri.store') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="nama" placeholder="Tambah baru..." class="rounded-lg border-slate-300 border px-3 py-1.5 text-sm focus:ring-indigo-500 focus:border-indigo-500 outline-none" required>
                            <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium">Tambah</button>
                        </form>
                    </div>
                    
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @forelse($industris as $item)
                        <div class="flex items-center justify-between bg-white px-4 py-3 rounded-xl border border-slate-100">
                            <span class="font-medium text-slate-700">{{ $item->nama }}</span>
                            <form action="{{ route('master-data.industri.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                        @empty
                        <div class="text-center py-4 text-slate-500 text-sm">Belum ada data industri.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Jenis Perusahaan -->
                <div class="glass rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-4 pb-4 border-b border-slate-100">
                        <h3 class="text-lg font-bold text-slate-800">Jenis Perusahaan</h3>
                        <form action="{{ route('master-data.jenis-perusahaan.store') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="nama" placeholder="Tambah baru..." class="rounded-lg border-slate-300 border px-3 py-1.5 text-sm focus:ring-indigo-500 focus:border-indigo-500 outline-none" required>
                            <button type="submit" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium">Tambah</button>
                        </form>
                    </div>
                    
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @forelse($jenisPerusahaans as $item)
                        <div class="flex items-center justify-between bg-white px-4 py-3 rounded-xl border border-slate-100">
                            <span class="font-medium text-slate-700">{{ $item->nama }}</span>
                            <form action="{{ route('master-data.jenis-perusahaan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                        @empty
                        <div class="text-center py-4 text-slate-500 text-sm">Belum ada data jenis perusahaan.</div>
                        @endforelse
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</main>
@endsection
