<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan.
     * Hanya mengambil pengajuan yang sudah memiliki status (bukan 'Menunggu').
     */
    public function index(Request $request)
    {
        // Mulai query untuk mengambil data
        $query = Pengajuan::with(['user', 'respon.user'])
                            ->where('status', '!=', 'Menunggu');

        // Filter berdasarkan rentang tanggal jika ada input
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $laporans = $query->latest()->get();

        return view('dashboards.laporan.index', compact('laporans'));
    }

    public function cetak(Request $request)
    {
        // 1. Mengambil data laporan (logikanya sama persis dengan halaman utama)
        $query = Pengajuan::with(['user', 'respon.user'])
                            ->where('status', '!=', 'Menunggu');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $laporans = $query->latest()->get();

        // 2. Mengembalikan view KHUSUS untuk cetak
        return view('dashboards.laporan.cetak', compact('laporans'));
    }
}
