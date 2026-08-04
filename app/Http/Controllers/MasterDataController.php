<?php

namespace App\Http\Controllers;

use App\Models\Industri;
use App\Models\JenisPerusahaan;
use App\Models\Layanan;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function index()
    {
        $industris = Industri::orderBy('nama')->get();
        $jenisPerusahaans = JenisPerusahaan::orderBy('nama')->get();
        $layanans = Layanan::orderBy('nama')->get();
        return view('master_data.index', compact('industris', 'jenisPerusahaans', 'layanans'));
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

    public function storeLayanan(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        $layanan = Layanan::firstOrCreate(['nama' => $request->nama]);
        
        if ($request->wantsJson()) {
            return response()->json($layanan);
        }
        
        return back()->with('success', 'Layanan berhasil ditambahkan');
    }

    public function destroyLayanan(Layanan $layanan)
    {
        $layanan->delete();
        return back()->with('success', 'Layanan berhasil dihapus');
    }
}
