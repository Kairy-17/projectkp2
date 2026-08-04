<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        session()->forget('report_pin_verified');
        $members = TeamMember::orderBy('nama')->get();
        return view('team_members.index', compact('members'));
    }

    public function create()
    {
        return view('team_members.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|unique:team_members,nama']);
        TeamMember::create($request->all());
        return redirect()->route('team-members.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('team_members.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $request->validate(['nama' => 'required|string|unique:team_members,nama,'.$teamMember->id]);
        $teamMember->update($request->all());
        return redirect()->route('team-members.index')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->route('team-members.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
