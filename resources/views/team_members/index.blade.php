@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50">
    <header class="h-16 glass flex items-center justify-between px-6 z-10 sticky top-0 border-b border-slate-200">
        <div class="flex items-center">
            <a href="{{ route('projects.index') }}" class="text-slate-500 hover:text-indigo-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-xl font-semibold">Kelola Anggota Tim (PIC)</h2>
        </div>
        <div>
            @include('partials.notifications')
        </div>
    </header>

    <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        <div class="max-w-2xl mx-auto glass p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            
            <!-- Add New Form -->
            <div class="mb-8 p-4 bg-white rounded-xl border border-slate-100 shadow-sm">
                <h3 class="font-semibold text-lg mb-4 text-slate-800">Tambah Anggota Baru</h3>
                <form action="{{ route('team-members.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    @php
                        $randomColors = ['#dc2626', '#ea580c', '#d97706', '#ca8a04', '#65a30d', '#16a34a', '#059669', '#0d9488', '#0891b2', '#0284c7', '#2563eb', '#4f46e5', '#7c3aed', '#9333ea', '#c026d3', '#db2777', '#e11d48'];
                        $defaultColor = $randomColors[array_rand($randomColors)];
                    @endphp
                    <div class="flex gap-3 flex-1">
                        <input type="color" name="warna" value="{{ $defaultColor }}" class="h-[42px] w-[42px] p-0.5 rounded-lg border-slate-300 border bg-white cursor-pointer shrink-0" title="Pilih Warna Profil">
                        <input type="text" name="nama" class="flex-1 w-full min-w-0 rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" placeholder="Nama panggilan..." required>
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm shadow-indigo-200 transition-colors shrink-0">Tambah</button>
                </form>
                @error('nama')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- List Members -->
            <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50/80 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Nama Anggota</th>
                            <th class="px-6 py-4 text-right font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white/40">
                        @forelse($members as $member)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-800">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold" style="background-color: {{ $member->warna_bg ?? '#e0e7ff' }}; color: {{ $member->warna_text ?? '#4f46e5' }};">{{ substr($member->nama, 0, 1) }}</div>
                                    {{ $member->nama }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('team-members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus nama ini dari daftar?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-slate-500">Belum ada anggota tim.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection


