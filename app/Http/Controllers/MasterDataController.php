<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\JenisPerusahaan;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        $industris = Industri::orderBy('nama')->get();
        $jenisPerusahaans = JenisPerusahaan::orderBy('nama')->get();
        return view('master_data.index', compact('industris', 'jenisPerusahaans'));
    }

    public function storeIndustri(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $industri = Industri::firstOrCreate(['nama' => $request->nama]);
        
        if ($request->wantsJson()) {
            return response()->json($industri);
        }
        
        return back()->with('success', 'Industri berhasil ditambahkan');
    }

    public function destroyIndustri(Industri $industri)
    {
        $industri->delete();
        return back()->with('success', 'Industri berhasil dihapus');
    }

    public function storeJenisPerusahaan(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $jenis = JenisPerusahaan::firstOrCreate(['nama' => $request->nama]);
        
        if ($request->wantsJson()) {
            return response()->json($jenis);
        }
        
        return back()->with('success', 'Jenis Perusahaan berhasil ditambahkan');
    }

    public function destroyJenisPerusahaan(JenisPerusahaan $jenisPerusahaan)
    {
        $jenisPerusahaan->delete();
        return back()->with('success', 'Jenis Perusahaan berhasil dihapus');
    }
}
