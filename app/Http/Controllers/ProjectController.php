<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        session()->forget('report_pin_verified');
        if ($request->has('tahun') || $request->has('bulan') || $request->has('minggu') || $request->has('status')) {
            session([
                'filter_tahun' => $request->tahun,
                'filter_bulan' => $request->bulan,
                'filter_minggu' => $request->minggu,
                'filter_status' => $request->status,
            ]);
        }

        $tahun = session('filter_tahun');
        $bulan = session('filter_bulan');
        $minggu = session('filter_minggu');
        $status = session('filter_status');

        $query = Project::with(['tasks' => function($q) {
            $q->orderBy('created_at', 'asc')->with('details');
        }]);

        if ($tahun) {
            $query->where('tahun', $tahun);
        }
        if ($bulan) {
            $query->where('bulan', $bulan);
        }
        if ($minggu) {
            $query->where('minggu', $minggu);
        }
        if ($status) {
            $query->whereHas('tasks', function ($q) use ($status) {
                $q->where('status_task', $status);
            })->with(['tasks' => function ($q) use ($status) {
                $q->where('status_task', $status)->orderBy('created_at', 'asc')->with('details');
            }]);
        }

        $projects = $query->orderBy('created_at', 'desc')->get();
        $teamMembersData = TeamMember::get()->keyBy('nama');
        return view('projects.index', compact('projects', 'tahun', 'bulan', 'minggu', 'status', 'teamMembersData'));
    }

    public function create()
    {
        $teamMembers = TeamMember::orderBy('nama')->get();
        return view('projects.create', compact('teamMembers'));
    }

    public function store(Request $request)
    {
        if ($request->has('project_id')) {
            $request->merge(['project_id' => strtoupper($request->project_id)]);
        }

        // Ambil tanggal dari input user, jika kosong gunakan waktu saat ini
        if ($request->has('tanggal_mulai') && !empty($request->tanggal_mulai)) {
            $date = \Carbon\Carbon::parse($request->tanggal_mulai);
        } else {
            $date = now();
        }

        $tahun = $date->year;
        $bulan = $date->month;
        $minggu = ceil($date->day / 7);

        $request->validate([
            'project_id' => [
                'required',
                \Illuminate\Validation\Rule::unique('projects')->where(function ($query) use ($tahun, $minggu) {
                    return $query->where('tahun', $tahun)
                                 ->where('minggu', $minggu);
                })
            ],
        ], [
            'project_id.unique' => 'Project ID ini sudah digunakan pada minggu ini. Silakan gunakan ID lain atau buat di minggu depan.'
        ]);

        $data = $request->except('tasks');
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;
        $data['minggu'] = $minggu;

        $project = Project::create($data);

        if ($request->has('tasks') && is_array($request->tasks)) {
            foreach ($request->tasks as $taskData) {
                $task = $project->tasks()->create([
                    'nama_task' => $taskData['nama_task'] ?? '-',
                    'pic' => $taskData['pic'] ?? [],
                    'status_task' => $taskData['status_task'] ?? 'Not yet',
                    'priority' => $taskData['priority'] ?? 'Medium',
                    'target_selesai' => $taskData['target_selesai'] ?? null,
                    'kendala_issue' => $taskData['kendala_issue'] ?? null,
                ]);

                if (isset($taskData['details']) && is_array($taskData['details'])) {
                    foreach ($taskData['details'] as $detailText) {
                        if (!empty(trim($detailText))) {
                            $task->details()->create(['detail_task' => trim($detailText)]);
                        }
                    }
                }
            }
        }

        // Update filter session agar user langsung melihat proyek yang baru dibuat
        session([
            'filter_tahun' => $tahun,
            'filter_bulan' => $bulan,
            'filter_minggu' => $minggu,
            'filter_status' => '',
        ]);

        return redirect()->route('projects.index')->with('success', 'Project dan Task berhasil ditambahkan.');
    }

    public function show(Project $project)
    {
        $teamMembersData = TeamMember::get()->keyBy('nama');
        return view('projects.show', compact('project', 'teamMembersData'));
    }

    public function edit(Project $project)
    {
        $project->load('tasks.details');
        $teamMembers = TeamMember::orderBy('nama')->get();
        return view('projects.edit', compact('project', 'teamMembers'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->except('tasks');
        $project->update($data);

        // Delete existing tasks and recreate them (simplest approach for dynamic forms)
        $project->tasks()->delete();

        if ($request->has('tasks') && is_array($request->tasks)) {
            foreach ($request->tasks as $taskData) {
                $task = $project->tasks()->create([
                    'nama_task' => $taskData['nama_task'] ?? '-',
                    'pic' => $taskData['pic'] ?? [],
                    'status_task' => $taskData['status_task'] ?? 'Not yet',
                    'priority' => $taskData['priority'] ?? 'Medium',
                    'target_selesai' => $taskData['target_selesai'] ?? null,
                    'kendala_issue' => $taskData['kendala_issue'] ?? null,
                ]);

                if (isset($taskData['details']) && is_array($taskData['details'])) {
                    foreach ($taskData['details'] as $detailText) {
                        if (!empty(trim($detailText))) {
                            $task->details()->create(['detail_task' => trim($detailText)]);
                        }
                    }
                }
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project beserta Task berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus.');
    }
}
