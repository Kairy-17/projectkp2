@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
    <header class="h-16 glass flex items-center px-6 z-10 sticky top-0 border-b border-slate-200">
        <a href="{{ route('reports.index') }}" class="text-slate-500 hover:text-emerald-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-xl font-semibold">Buat Laporan Baru</h2>
    </header>

    <div class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-12">
        <div class="max-w-3xl mx-auto glass p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('reports.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tahun</label>
                        <input type="number" name="tahun" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" placeholder="Contoh: 2026" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Klien</label>
                        <input type="text" name="klien" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all" required>
                    </div>
                    <div x-data="{
                        options: {{ json_encode($industris) }},
                        selected: '',
                        async addNew() {
                            let nama = prompt('Masukkan nama Industri baru:');
                            if(nama) {
                                let res = await fetch('{{ route('master-data.industri.store') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({nama: nama})
                                });
                                if(res.ok) {
                                    let data = await res.json();
                                    this.options.push(data);
                                    this.selected = data.nama;
                                }
                            }
                        }
                    }">
                        <label class="block text-sm font-medium text-slate-700 mb-1 flex justify-between items-center">
                            Industri
                            <button type="button" @click="addNew()" class="text-xs text-indigo-600 hover:text-indigo-800 flex items-center font-semibold">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Cepat
                            </button>
                        </label>
                        <select name="industri" x-model="selected" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                            <option value="">-- Pilih Industri --</option>
                            <template x-for="opt in options" :key="opt.id">
                                <option :value="opt.nama" x-text="opt.nama"></option>
                            </template>
                        </select>
                    </div>
                    <div x-data="{
                        options: {{ json_encode($jenisPerusahaans) }},
                        selected: '',
                        async addNew() {
                            let nama = prompt('Masukkan nama Jenis Perusahaan baru:');
                            if(nama) {
                                let res = await fetch('{{ route('master-data.jenis-perusahaan.store') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({nama: nama})
                                });
                                if(res.ok) {
                                    let data = await res.json();
                                    this.options.push(data);
                                    this.selected = data.nama;
                                }
                            }
                        }
                    }">
                        <label class="block text-sm font-medium text-slate-700 mb-1 flex justify-between items-center">
                            Jenis Perusahaan
                            <button type="button" @click="addNew()" class="text-xs text-indigo-600 hover:text-indigo-800 flex items-center font-semibold">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Cepat
                            </button>
                        </label>
                        <select name="jenis_perusahaan" x-model="selected" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                            <option value="">-- Pilih Jenis Perusahaan --</option>
                            <template x-for="opt in options" :key="opt.id">
                                <option :value="opt.nama" x-text="opt.nama"></option>
                            </template>
                        </select>
                    </div>
                    <div x-data="{
                        options: {{ json_encode($layanans) }},
                        selected: '',
                        async addNew() {
                            let nama = prompt('Masukkan nama Layanan baru:');
                            if(nama) {
                                let res = await fetch('{{ route('master-data.layanan.store') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({nama: nama})
                                });
                                if(res.ok) {
                                    let data = await res.json();
                                    this.options.push(data);
                                    this.selected = data.nama;
                                }
                            }
                        }
                    }">
                        <label class="block text-sm font-medium text-slate-700 mb-1 flex justify-between items-center">
                            Layanan
                            <button type="button" @click="addNew()" class="text-xs text-indigo-600 hover:text-indigo-800 flex items-center font-semibold">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Cepat
                            </button>
                        </label>
                        <select name="layanan" x-model="selected" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                            <option value="">-- Pilih Layanan --</option>
                            <template x-for="opt in options" :key="opt.id">
                                <option :value="opt.nama" x-text="opt.nama"></option>
                            </template>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nilai Proyek (Rp)</label>
                        <input type="number" name="nilai_proyek" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Real Income (Rp)</label>
                        <input type="number" name="real_income" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Margin (%)</label>
                        <input type="number" step="0.1" name="margin_persen" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Keterlibatan Puti (%)</label>
                        <input type="number" step="0.1" name="keterlibatan_puti_persen" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Masalah yang diselesaikan</label>
                        <textarea name="masalah_yang_diselesaikan" rows="3" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all"></textarea>
                    </div>
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 mt-6">
                    <a href="{{ route('reports.index') }}" class="px-5 py-2.5 border border-slate-300 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-xl shadow-sm shadow-emerald-200 transition-colors">Simpan Laporan</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
