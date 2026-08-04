<?php

namespace App\Http\Controllers;

use App\Models\ReportAttachment;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportAttachmentController extends Controller
{
    public function index(Report $report)
    {
        return view('reports.attachments', compact('report'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'tipe' => 'required|in:file,link',
            'judul_dokumen' => 'required|string|max:255',
        ]);

        $data = [
            'report_id' => $request->report_id,
            'tipe' => $request->tipe,
            'judul_dokumen' => $request->judul_dokumen,
        ];

        if ($request->tipe === 'file') {
            // Normal validation continues here
            $request->validate([
                'file' => 'required|file|max:2048', // 2MB max according to php.ini
            ], [
                'file.required' => 'Anda harus memilih file terlebih dahulu.',
                'file.uploaded' => 'File gagal diunggah. Pastikan ukuran file Anda TIDAK lebih dari 2MB.',
                'file.max' => 'Ukuran file terlalu besar! Maksimal adalah 2MB.'
            ]);
            $path = $request->file('file')->store('report_attachments', 'public');
            $data['path_atau_url'] = $path;
        } else {
            $request->validate([
                'url' => 'required|url',
            ]);
            $data['path_atau_url'] = $request->url;
        }

        ReportAttachment::create($data);

        return back()->with('success', 'Dokumen berhasil ditambahkan ke Brankas.');
    }

    public function destroy(ReportAttachment $attachment)
    {
        if ($attachment->tipe === 'file') {
            Storage::disk('public')->delete($attachment->path_atau_url);
        }
        $attachment->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
