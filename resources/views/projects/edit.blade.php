@extends('layouts.app')

@section('content')
<main class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50">
    <header class="h-16 glass flex items-center px-6 z-10 sticky top-0 border-b border-slate-200 justify-between">
        <div class="flex items-center">
            <a href="{{ route('projects.index') }}" class="text-slate-500 hover:text-indigo-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-xl font-semibold">{{ __('Edit Project') }}: {{ $project->project_id }}</h2>
        </div>
        
        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus project ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-sm px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors">{{ __('Hapus Project') }}</button>
        </form>
    </header>

    <div class="flex-1 overflow-y-auto p-4 sm:p-6 md:p-12">
        <div class="max-w-3xl mx-auto glass p-6 sm:p-8 rounded-2xl shadow-sm border border-slate-200">
            <form action="{{ route('projects.update', $project->id) }}" method="POST" class="space-y-6" x-data="projectForm()">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Project ID') }}</label>
                        <input type="text" name="project_id" value="{{ $project->project_id }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Nama Project') }}</label>
                        <input type="text" name="nama_project" value="{{ $project->nama_project }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Deskripsi Singkat Project (Opsional)') }}</label>
                        <textarea name="deskripsi_singkat" rows="2" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">{{ $project->deskripsi_singkat }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Durasi Keseluruhan Project') }}</label>
                        <input type="text" name="durasi_project" value="{{ $project->durasi_project }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Tanggal Mulai Project') }}</label>
                        <input type="text" x-data x-init="flatpickr($el, { altInput: true, altFormat: 'd/m/Y', dateFormat: 'Y-m-d' })" name="tanggal_mulai" value="{{ $project->tanggal_mulai }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white cursor-pointer" placeholder="{{ __('hh/bb/tttt') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Target Selesai Project') }}</label>
                        <input type="text" x-data x-init="flatpickr($el, { altInput: true, altFormat: 'd/m/Y', dateFormat: 'Y-m-d' })" name="target_selesai" value="{{ $project->target_selesai }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white cursor-pointer" placeholder="{{ __('hh/bb/tttt') }}">
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg text-slate-800">{{ __('Daftar Pekerjaan (Tasks)') }}</h3>
                        <button type="button" @click="addTask()" class="inline-flex items-center gap-1 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            {{ __('Tambah Task') }}
                        </button>
                    </div>

                    <div class="space-y-6">
                        <template x-for="(task, taskIndex) in tasks" :key="task.id">
                            <div class="p-5 border border-slate-200 rounded-xl bg-slate-50 relative">
                                <!-- Hapus Task Button -->
                                <button type="button" @click="removeTask(taskIndex)" x-show="tasks.length > 1" class="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2 pr-8">
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Nama Task') }}</label>
                                        <input type="text" :name="`tasks[${taskIndex}][nama_task]`" x-model="task.nama_task" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" required placeholder="{{ __('Contoh: Weekly Internal') }}">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-slate-700 mb-2">{{ __('PIC Task Ini') }}</label>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($teamMembers as $member)
                                                <label class="cursor-pointer relative">
                                                    <input type="checkbox" :name="`tasks[${taskIndex}][pic][]`" value="{{ $member->nama }}" x-model="task.pic" class="peer sr-only">
                                                    <div class="px-3 py-1.5 rounded-full border border-slate-200 bg-white text-slate-500 text-xs font-medium transition-all peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 hover:bg-slate-100">
                                                        {{ $member->nama }}
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Status') }}</label>
                                        <select :name="`tasks[${taskIndex}][status_task]`" x-model="task.status_task" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                                            <option value="Not yet">Not yet</option>
                                            <option value="On going">On going</option>
                                            <option value="Hold">Hold</option>
                                            <option value="Done">Done</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Prioritas') }}</label>
                                        <select :name="`tasks[${taskIndex}][priority]`" x-model="task.priority" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                                            <option value="Low">Low</option>
                                            <option value="Medium">Medium</option>
                                            <option value="High">High</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Target Selesai') }}</label>
                                        <input type="date" :name="`tasks[${taskIndex}][target_selesai]`" x-model="task.target_selesai" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Kendala (Opsional)') }}</label>
                                        <input type="text" :name="`tasks[${taskIndex}][kendala_issue]`" x-model="task.kendala_issue" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                                    </div>

                                    <!-- Detail Tasks -->
                                    <div class="md:col-span-2 mt-2 p-4 bg-white rounded-lg border border-slate-200">
                                        <div class="flex items-center justify-between mb-2">
                                            <label class="block text-sm font-medium text-slate-700">{{ __('Detail Pekerjaan') }}</label>
                                        </div>
                                        <div class="space-y-2">
                                            <template x-for="(detail, detailIndex) in task.details" :key="detail.id">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-slate-400 shrink-0"></div>
                                                    <input type="text" :name="`tasks[${taskIndex}][details][]`" x-model="detail.text" placeholder="{{ __('Tulis detail tugas di sini...') }}" class="flex-1 text-sm rounded border-slate-300 border px-3 py-1.5 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                                                    <button type="button" @click="removeDetail(taskIndex, detailIndex)" class="text-slate-400 hover:text-red-500 p-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </div>
                                            </template>
                                        </div>
                                        <button type="button" @click="addDetail(taskIndex)" class="mt-2 text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            {{ __('Tambah Detail Lagi') }}
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <h3 class="font-semibold text-lg text-slate-800 mb-4 mt-8 pb-2 border-b border-slate-100">{{ __('Informasi Tambahan & Progress') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Persentase Progress (%)') }}</label>
                        <input type="number" name="progress" min="0" max="100" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" value="{{ $project->progress ?? 0 }}">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Tahap Saat Ini') }}</label>
                        <input type="text" name="milestone_saat_ini" value="{{ $project->milestone_saat_ini }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">{{ __('Tindakan Selanjutnya') }}</label>
                        <input type="text" name="next_action" value="{{ $project->next_action }}" class="w-full rounded-lg border-slate-300 border px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100 mt-6">
                    <a href="{{ route('projects.index') }}" class="px-5 py-2.5 border border-slate-300 rounded-xl text-slate-700 font-medium hover:bg-slate-50 transition-colors">{{ __('Batal') }}</a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-sm shadow-indigo-200 transition-colors">{{ __('Simpan Perubahan') }}</button>
                </div>
            </form>
        </div>
    </div>
</main>

@php
    $initialTasks = $project->tasks->count() > 0 ? $project->tasks->map(function($task) {
        return [
            'id' => $task->id,
            'nama_task' => $task->nama_task,
            'pic' => is_array($task->pic) ? $task->pic : [],
            'status_task' => $task->status_task,
            'priority' => $task->priority,
            'target_selesai' => $task->target_selesai ? \Carbon\Carbon::parse($task->target_selesai)->format('Y-m-d') : '',
            'kendala_issue' => $task->kendala_issue ?? '',
            'details' => $task->details->count() > 0 ? $task->details->map(function($detail) {
                return ['id' => $detail->id, 'text' => $detail->detail_task];
            })->toArray() : [['id' => rand(1000, 9999), 'text' => '']]
        ];
    })->toArray() : [
        [
            'id' => time(),
            'nama_task' => '',
            'pic' => [],
            'status_task' => 'Not yet',
            'priority' => 'Medium',
            'target_selesai' => '',
            'kendala_issue' => '',
            'details' => [['id' => time() + 1, 'text' => '']]
        ]
    ];
@endphp

<script>
function projectForm() {
    return {
        tasks: @json($initialTasks),
        addTask() {
            this.tasks.push({
                id: Date.now(),
                nama_task: '',
                pic: [],
                status_task: 'Not yet',
                priority: 'Medium',
                target_selesai: '',
                kendala_issue: '',
                details: [
                    { id: Date.now() + 1, text: '' }
                ]
            });
        },
        removeTask(index) {
            this.tasks.splice(index, 1);
        },
        addDetail(taskIndex) {
            this.tasks[taskIndex].details.push({ id: Date.now(), text: '' });
        },
        removeDetail(taskIndex, detailIndex) {
            this.tasks[taskIndex].details.splice(detailIndex, 1);
        }
    }
}
</script>
@endsection


