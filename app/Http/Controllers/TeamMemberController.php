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
        $request->validate([
            'nama' => 'required|string|unique:team_members,nama',
            'warna' => 'nullable|string|max:7',
        ]);

        $warna = $request->warna;
        if (!$warna) {
            $colors = ['#dc2626', '#ea580c', '#d97706', '#ca8a04', '#65a30d', '#16a34a', '#059669', '#0d9488', '#0891b2', '#0284c7', '#2563eb', '#4f46e5', '#7c3aed', '#9333ea', '#c026d3', '#db2777', '#e11d48'];
            $warna = $colors[array_rand($colors)];
        }

        TeamMember::create([
            'nama' => $request->nama,
            'warna_text' => $warna,
            'warna_bg' => $warna . '22', // 20% opacity for background
        ]);
        return redirect()->route('team-members.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('team_members.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'nama' => 'required|string|unique:team_members,nama,'.$teamMember->id,
            'warna' => 'nullable|string|max:7',
        ]);
        
        $data = ['nama' => $request->nama];
        if ($request->warna) {
            $data['warna_text'] = $request->warna;
            $data['warna_bg'] = $request->warna . '22';
        }
        
        $teamMember->update($data);
        return redirect()->route('team-members.index')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->route('team-members.index')->with('success', 'Anggota tim berhasil dihapus.');
    }
}
