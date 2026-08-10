@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50">
    <header class="h-16 glass flex items-center px-6 z-10 sticky top-0 border-b border-slate-200">
        <a href="{{ route('projects.index') }}" class="text-slate-500 hover:text-indigo-600 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h2 class="text-xl font-semibold">{{ __('Buat Project Baru') }}</h2>
    </header>

    <div class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-12">
        <div class="max-w-3xl mx-auto glass p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Project ID') }}</label>
                        <input type="text" name="project_id" value="{{ old('project_id') }}" oninput="this.value = this.value.toUpperCase()" class="uppercase w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all @error('project_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="{{ __('Contoh: GAP') }}" required>
                        @error('project_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Nama Project') }}</label>
                        <input type="text" name="nama_project" value="{{ old('nama_project') }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Deskripsi Singkat') }}</label>
                        <textarea name="deskripsi_singkat" rows="3" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">{{ old('deskripsi_singkat') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('PIC') }}</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($teamMembers as $member)
                                <label class="cursor-pointer relative">
                                    <input type="checkbox" name="pic[]" value="{{ $member->nama }}" class="peer sr-only" {{ in_array($member->nama, old('pic', [])) ? 'checked' : '' }}>
                                    <div class="px-3 py-1.5 rounded-full border border-slate-200 bg-white text-slate-600 text-sm font-medium transition-all peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 hover:bg-slate-50">
                                        {{ $member->nama }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Status Project') }}</label>
                        <select name="status_project" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white">
                            <option value="Not yet" {{ old('status_project') == 'Not yet' ? 'selected' : '' }}>{{ __('Not yet') }}</option>
                            <option value="On going" {{ old('status_project') == 'On going' ? 'selected' : '' }}>{{ __('On going') }}</option>
                            <option value="Hold" {{ old('status_project') == 'Hold' ? 'selected' : '' }}>{{ __('Hold') }}</option>
                            <option value="Done" {{ old('status_project') == 'Done' ? 'selected' : '' }}>{{ __('Done') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Priority') }}</label>
                        <select name="priority" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white">
                            <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>{{ __('Low') }}</option>
                            <option value="Medium" {{ old('priority', 'Medium') == 'Medium' ? 'selected' : '' }}>{{ __('Medium') }}</option>
                            <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>{{ __('High') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Durasi Project') }}</label>
                        <input type="text" name="durasi_project" value="{{ old('durasi_project') }}" placeholder="{{ __('Contoh: 3 bulan') }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Tanggal Mulai') }}</label>
                        <input type="text" value="{{ old('tanggal_mulai') }}" x-data x-init="flatpickr($el, { altInput: true, altFormat: 'd/m/Y', dateFormat: 'Y-m-d' })" name="tanggal_mulai" placeholder="{{ __('hh/bb/tttt') }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Target Selesai') }}</label>
                        <input type="text" value="{{ old('target_selesai') }}" x-data x-init="flatpickr($el, { altInput: true, altFormat: 'd/m/Y', dateFormat: 'Y-m-d' })" name="target_selesai" placeholder="{{ __('hh/bb/tttt') }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white cursor-pointer">
                    </div>
                </div>

                <h3 class="font-semibold text-lg text-slate-800 mb-4 mt-8 pb-2 border-b border-slate-100">{{ __('Informasi Tambahan & Progress') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Persentase Progress (%)') }}</label>
                        <input type="number" name="progress" min="0" max="100" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" value="{{ old('progress', 0) }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Tahap Saat Ini') }}</label>
                        <input type="text" name="milestone_saat_ini" value="{{ old('milestone_saat_ini') }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Tindakan Selanjutnya') }}</label>
                        <input type="text" name="next_action" value="{{ old('next_action') }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Kendala / Hambatan') }}</label>
                        <textarea name="kendala_issue" rows="2" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">{{ old('kendala_issue') }}</textarea>
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 mt-6">
                    <a href="{{ route('projects.index') }}" class="px-5 py-2.5 border border-slate-300 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">{{ __('Batal') }}</a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm shadow-indigo-200 transition-colors">{{ __('Simpan Project') }}</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection


