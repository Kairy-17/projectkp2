<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industris = ['IT', 'Kesehatan', 'Keuangan', 'Manufaktur', 'Pendidikan'];
        foreach($industris as $i) {
            \App\Models\Industri::firstOrCreate(['nama' => $i]);
        }

        $jenis = ['BUMN', 'Swasta', 'Multinasional', 'Startup', 'Instansi Pemerintah'];
        foreach($jenis as $j) {
            \App\Models\JenisPerusahaan::firstOrCreate(['nama' => $j]);
        }
    }
}
