<?php

namespace App\Http\Controllers;

use App\Models\GeneralAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GeneralAttachmentController extends Controller
{
    public function index()
    {
        $attachments = GeneralAttachment::latest()->get();
        return view('general_attachments.index', compact('attachments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:file,link',
            'judul_dokumen' => 'required|string|max:255',
        ]);

        $data = [
            'tipe' => $request->tipe,
            'judul_dokumen' => $request->judul_dokumen,
        ];

        if ($request->tipe === 'file') {
            $request->validate([
                'file' => 'required|file|max:20480', // 20MB max
            ], [
                'file.required' => 'Anda harus memilih file terlebih dahulu.',
                'file.uploaded' => 'File gagal diunggah. Pastikan ukuran file Anda TIDAK lebih dari 20MB.',
                'file.max' => 'Ukuran file terlalu besar! Maksimal adalah 20MB.'
            ]);
            $path = $request->file('file')->store('general_attachments', 'public');
            $data['path_atau_url'] = $path;
        } else {
            $request->validate([
                'url' => 'required|url',
            ]);
            $data['path_atau_url'] = $request->url;
        }

        GeneralAttachment::create($data);

        return back()->with('success', 'Dokumen berhasil ditambahkan ke Brankas Umum.');
    }

    public function destroy(GeneralAttachment $general_attachment)
    {
        if ($general_attachment->tipe === 'file') {
            Storage::disk('public')->delete($general_attachment->path_atau_url);
        }
        $general_attachment->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
