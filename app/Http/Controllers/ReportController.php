<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Industri;
use App\Models\JenisPerusahaan;
use App\Models\Layanan;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::orderBy('created_at', 'desc')->get();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $industris = Industri::orderBy('nama')->get();
        $jenisPerusahaans = JenisPerusahaan::orderBy('nama')->get();
        $layanans = Layanan::orderBy('nama')->get();
        return view('reports.create', compact('industris', 'jenisPerusahaans', 'layanans'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $numericFields = ['nilai_proyek', 'cost_proyek', 'real_income', 'margin_persen', 'real_margin', 'keterlibatan_puti_persen'];
        foreach ($numericFields as $field) {
            if (empty($data[$field])) {
                $data[$field] = 0;
            }
        }
        
        Report::create($data);
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit(Report $report)
    {
        $industris = Industri::orderBy('nama')->get();
        $jenisPerusahaans = JenisPerusahaan::orderBy('nama')->get();
        $layanans = Layanan::orderBy('nama')->get();
        return view('reports.edit', compact('report', 'industris', 'jenisPerusahaans', 'layanans'));
    }

    public function update(Request $request, Report $report)
    {
        $data = $request->all();
        $numericFields = ['nilai_proyek', 'cost_proyek', 'real_income', 'margin_persen', 'real_margin', 'keterlibatan_puti_persen'];
        foreach ($numericFields as $field) {
            if (empty($data[$field])) {
                $data[$field] = 0;
            }
        }

        $report->update($data);
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
