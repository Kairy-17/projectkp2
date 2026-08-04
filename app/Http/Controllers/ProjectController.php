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

        $query = Project::query();

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
            $query->where('status_project', $status);
        }

        $projects = $query->orderBy('created_at', 'desc')->get();
        return view('projects.index', compact('projects', 'tahun', 'bulan', 'minggu', 'status'));
    }

    public function create()
    {
        $teamMembers = TeamMember::orderBy('nama')->get();
        return view('projects.create', compact('teamMembers'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if(!isset($data['pic'])) {
            $data['pic'] = [];
        }
        
        $now = now();
        $data['tahun'] = $now->year;
        $data['bulan'] = $now->month;
        $data['minggu'] = ceil($now->day / 7);

        Project::create($data);
        return redirect()->route('projects.index')->with('success', 'Project berhasil ditambahkan.');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $teamMembers = TeamMember::orderBy('nama')->get();
        return view('projects.edit', compact('project', 'teamMembers'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->all();
        if(!isset($data['pic'])) {
            $data['pic'] = [];
        }
        $project->update($data);
        return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus.');
    }
}
