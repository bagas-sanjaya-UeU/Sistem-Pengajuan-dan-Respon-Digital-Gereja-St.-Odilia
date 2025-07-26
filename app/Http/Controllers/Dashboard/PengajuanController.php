<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    /**
     * Menampilkan daftar pengajuan.
     * Admin melihat semua, user melihat miliknya sendiri.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'Admin') {
            // UBAH DARI paginate() MENJADI get()
            $pengajuans = Pengajuan::with('user')->latest()->get();
        } else {
            // UBAH DARI paginate() MENJADI get()
            $pengajuans = Pengajuan::where('user_id', $user->id)->latest()->get();
        }
        return view('dashboards.pengajuans.index', compact('pengajuans'));
    }

    /**
     * Menampilkan form untuk membuat pengajuan baru.
     */
    public function create()
    {
        return view('dashboards.pengajuans.create');
    }

    /**
     * Menyimpan pengajuan baru ke database.
     */
    public function store(Request $request)
    {
        // Date jakarta
        date_default_timezone_set('Asia/Jakarta');

        $request->validate([
            'jenis_pengajuan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran-pengajuan', 'public');
        }
        
        // Membuat nomor pengajuan unik
        $nomorPengajuan = 'PENG-' . date('Ymd') . '-' . strtoupper(uniqid());

        // created_at
        $createdAt = now();

        Pengajuan::create([
            'user_id' => Auth::id(),
            'nomor_pengajuan' => $nomorPengajuan,
            'jenis_pengajuan' => $request->jenis_pengajuan,
            'deskripsi' => $request->deskripsi,
            'lampiran' => $lampiranPath,
            'status' => 'Menunggu',
            'created_at' => $createdAt,
            'updated_at' => $createdAt, // Set updated_at sama dengan created_at
        ]);

        return redirect()->route('dashboard.pengajuans.index')->with('success', 'Pengajuan berhasil dibuat.');
    }

    /**
     * Menampilkan detail dari sebuah pengajuan.
     */
    public function show(Pengajuan $pengajuan)
    {
        // Pastikan user hanya bisa melihat pengajuannya sendiri, kecuali admin
        if (Auth::user()->role !== 'Admin' && $pengajuan->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }
        
        // Eager load relasi respon dan user dari respon
        $pengajuan->load('respon.user');

        return view('dashboards.pengajuans.show', compact('pengajuan'));
    }

    /**
     * [BARU] Memperbarui pengajuan yang direvisi oleh user.
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        // Date jakarta
        date_default_timezone_set('Asia/Jakarta');
        // Otorisasi: Hanya user pemilik yang bisa merevisi jika statusnya 'Revisi'
        if ($pengajuan->user_id !== Auth::id() || $pengajuan->status !== 'Revisi') {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        $request->validate([
            'jenis_pengajuan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $dataToUpdate = $request->only(['jenis_pengajuan', 'deskripsi']);

        // Jika ada lampiran baru, hapus yang lama dan upload yang baru
        if ($request->hasFile('lampiran')) {
            // Hapus lampiran lama jika ada
            if ($pengajuan->lampiran) {
                Storage::disk('public')->delete($pengajuan->lampiran);
            }
            // Simpan lampiran baru
            $dataToUpdate['lampiran'] = $request->file('lampiran')->store('lampiran-pengajuan', 'public');
        }

        // Set status kembali ke 'Menunggu'
        $dataToUpdate['status'] = 'Menunggu';

        // updated_at
        $dataToUpdate['updated_at'] = now();
        

        $pengajuan->update($dataToUpdate);

        return redirect()->route('dashboard.pengajuans.show', $pengajuan->id)->with('success', 'Pengajuan berhasil direvisi dan dikirim ulang.');
    }

    /**
     * Menghapus pengajuan.
     */
    public function destroy(Pengajuan $pengajuan)
    {
        // Pastikan user hanya bisa menghapus pengajuannya sendiri, kecuali admin
        if (Auth::user()->role !== 'Admin' && $pengajuan->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Hapus file lampiran jika ada
        if ($pengajuan->lampiran) {
            Storage::disk('public')->delete($pengajuan->lampiran);
        }

        $pengajuan->delete();

        return redirect()->route('dashboard.pengajuans.index')->with('success', 'Pengajuan berhasil dihapus.');
    }
}
