<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        // Time filtering
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->filled('bulan')) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->filled('minggu')) {
            $query->where('minggu', $request->minggu);
        }

        $projects = $query->orderBy('created_at', 'desc')->get();
        return view('projects.index', compact('projects'));
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
