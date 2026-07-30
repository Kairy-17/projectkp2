@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
    <header class="h-16 glass flex items-center px-6 z-10 sticky top-0 border-b border-slate-200">
        <a href="{{ route('projects.index') }}" class="text-slate-500 hover:text-indigo-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-xl font-semibold">Buat Project Baru</h2>
    </header>

    <div class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-12">
        <div class="max-w-3xl mx-auto glass p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Project ID</label>
                        <input type="text" name="project_id" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" placeholder="Contoh: GAP" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Project</label>
                        <input type="text" name="nama_project" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="deskripsi_singkat" rows="3" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">PIC (Tim Terlibat)</label>
                        <select name="pic[]" multiple class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white h-24">
                            @foreach($teamMembers as $member)
                                <option value="{{ $member->nama }}">{{ $member->nama }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-500 mt-1">Tahan tombol Ctrl (Windows) / Cmd (Mac) untuk memilih lebih dari satu.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tahun</label>
                        <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Bulan</label>
                        <select name="bulan" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white" required>
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 10)) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Minggu Ke-</label>
                        <select name="minggu" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status Project</label>
                        <select name="status_project" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white">
                            <option value="Not yet">Not yet</option>
                            <option value="On going">On going</option>
                            <option value="Hold">Hold</option>
                            <option value="Done">Done</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Priority</label>
                        <select name="priority" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white">
                            <option value="Low">Low</option>
                            <option value="Medium" selected>Medium</option>
                            <option value="High">High</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Durasi Project</label>
                        <input type="text" name="durasi_project" placeholder="Contoh: 3 bulan" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Target Selesai (Due Date)</label>
                        <input type="date" name="target_selesai" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 mt-6">
                    <a href="{{ route('projects.index') }}" class="px-5 py-2.5 border border-slate-300 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm shadow-indigo-200 transition-colors">Simpan Project</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
