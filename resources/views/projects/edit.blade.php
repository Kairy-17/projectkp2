@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
    <header class="h-16 glass flex items-center px-6 z-10 sticky top-0 border-b border-slate-200 justify-between">
        <div class="flex items-center">
            <a href="{{ route('projects.index') }}" class="text-slate-500 hover:text-indigo-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-xl font-semibold">Edit Project: {{ $project->project_id }}</h2>
        </div>
        
        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">Hapus Project</button>
        </form>
    </header>

    <div class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-12">
        <div class="max-w-3xl mx-auto glass p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('projects.update', $project->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Project ID</label>
                        <input type="text" name="project_id" value="{{ $project->project_id }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Project</label>
                        <input type="text" name="nama_project" value="{{ $project->nama_project }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="deskripsi_singkat" rows="3" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">{{ $project->deskripsi_singkat }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">PIC (Tim Terlibat)</label>
                        <select name="pic[]" multiple class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white h-24">
                            @php $selectedPics = is_array($project->pic) ? $project->pic : []; @endphp
                            @foreach($teamMembers as $member)
                                <option value="{{ $member->nama }}" {{ in_array($member->nama, $selectedPics) ? 'selected' : '' }}>{{ $member->nama }}</option>
                            @endforeach
                        </select>
                        <p class="text-[10px] text-slate-500 mt-1">Tahan Ctrl/Cmd untuk memilih lebih dari satu.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status Project</label>
                        <select name="status_project" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white">
                            <option value="Not yet" {{ $project->status_project == 'Not yet' ? 'selected' : '' }}>Not yet</option>
                            <option value="On going" {{ $project->status_project == 'On going' ? 'selected' : '' }}>On going</option>
                            <option value="Hold" {{ $project->status_project == 'Hold' ? 'selected' : '' }}>Hold</option>
                            <option value="Done" {{ $project->status_project == 'Done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Priority</label>
                        <select name="priority" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white">
                            <option value="Low" {{ $project->priority == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ $project->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ $project->priority == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Durasi Project</label>
                        <input type="text" name="durasi_project" value="{{ $project->durasi_project }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" value="{{ $project->tanggal_mulai }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Target Selesai (Due Date)</label>
                        <input type="date" name="target_selesai" value="{{ $project->target_selesai }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Progress (%)</label>
                        <input type="number" name="progress" min="0" max="100" value="{{ $project->progress }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 mt-6">
                    <a href="{{ route('projects.index') }}" class="px-5 py-2.5 border border-slate-300 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm shadow-indigo-200 transition-colors">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
