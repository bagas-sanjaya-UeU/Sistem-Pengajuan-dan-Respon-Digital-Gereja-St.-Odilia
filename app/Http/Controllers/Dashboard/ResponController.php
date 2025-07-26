<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\Respon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResponController extends Controller
{
    /**
     * Menyimpan respon baru ke database.
     */
    public function store(Request $request, Pengajuan $pengajuan)
    {
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak,Revisi',
            'catatan' => 'nullable|string',
            'lampiran_respon' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Gunakan transaksi untuk memastikan data konsisten
        DB::transaction(function () use ($request, $pengajuan) {
            $lampiranPath = null;
            if ($request->hasFile('lampiran_respon')) {
                $lampiranPath = $request->file('lampiran_respon')->store('lampiran-respon', 'public');
            }

            // Buat atau perbarui respon
            Respon::updateOrCreate(
                ['pengajuan_id' => $pengajuan->id],
                [
                    'user_id' => Auth::id(),
                    'catatan' => $request->catatan,
                    'lampiran_respon' => $lampiranPath,
                ]
            );

            // Update status di tabel pengajuan
            $pengajuan->update(['status' => $request->status]);
        });
        
        return redirect()->route('dashboard.pengajuans.show', $pengajuan->id)->with('success', 'Respon berhasil dikirim.');
    }
}
