<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $members = ['puti', 'marlis', 'adel', 'indah', 'puji', 'joko', 'desi', 'criana', 'adam', 'ilham', 'zaky', 'fandy', 'salsa'];
        foreach($members as $member) {
            \App\Models\TeamMember::create(['nama' => ucfirst($member)]);
        }

        \App\Models\Project::create([
            'project_id' => 'DH',
            'nama_project' => 'Data Hen',
            'pic' => ['Puti', 'Marlis'],
            'tahun' => 2026,
            'bulan' => 7,
            'minggu' => 1,
            'status_project' => 'On going',
            'priority' => 'High',
            'durasi_project' => '3 bulan',
            'target_selesai' => '2026-07-09',
            'progress' => 30,
        ]);

        \App\Models\Project::create([
            'project_id' => 'RM',
            'nama_project' => 'Reksa Madani',
            'pic' => ['Adel'],
            'tahun' => 2026,
            'bulan' => 7,
            'minggu' => 1,
            'status_project' => 'Not yet',
            'priority' => 'Low',
        ]);

        \App\Models\Report::create([
            'klien' => 'Data Hen',
            'tahun' => 2026,
            'industri' => 'IT',
            'nilai_proyek' => 10000000,
            'real_income' => 9500000,
            'margin_persen' => 25.5,
        ]);
        
        \App\Models\Report::create([
            'klien' => 'Reksa Madani',
            'tahun' => 2026,
            'industri' => 'Finance',
            'nilai_proyek' => 25000000,
            'real_income' => 20000000,
            'margin_persen' => 15.0,
        ]);
    }
}
