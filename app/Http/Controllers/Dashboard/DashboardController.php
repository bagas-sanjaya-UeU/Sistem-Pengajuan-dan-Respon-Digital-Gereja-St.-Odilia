<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\TableauLink; // 1. Tambahkan model TableauLink
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman utama dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $stats = [];
        
        // 2. Ambil semua data visualisasi dari database
        $tableauLinks = TableauLink::latest()->get();

        if ($user->role === 'Admin') {
            // Statistik untuk Admin
            $stats['total_pengajuan'] = Pengajuan::count();
            $stats['pengajuan_menunggu'] = Pengajuan::where('status', 'Menunggu')->count();
            $stats['total_user'] = User::count();
        } else {
            // Statistik untuk User biasa (Pastor, Dewan, Karyawan)
            $stats['total_pengajuan_saya'] = Pengajuan::where('user_id', $user->id)->count();
            $stats['pengajuan_diterima'] = Pengajuan::where('user_id', $user->id)->where('status', 'Diterima')->count();
            $stats['pengajuan_ditolak'] = Pengajuan::where('user_id', $user->id)->where('status', 'Ditolak')->count();
            $stats['pengajuan_menunggu'] = Pengajuan::where('user_id', $user->id)->where('status', 'Menunggu')->count();
            $stats['pengajuan_revisi'] = Pengajuan::where('user_id', $user->id)->where('status', 'Revisi')->count();
        }

        // 3. Kirim data statistik DAN data visualisasi ke view
        // Pastikan nama view ('dashboards.dashboard') sudah benar
        return view('dashboards.dashboard', compact('stats', 'tableauLinks'));
    }
}
