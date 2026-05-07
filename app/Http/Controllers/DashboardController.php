<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalBuku = Buku::count();
        $totalKategori = Kategori::count();
        $totalPeminjaman = Peminjaman::count();
        $bukuDipinjam = Peminjaman::where('status', 'Dipinjam')->count();

        // Data for Luxury Library Dashboard
        $bukuTerbaru = Buku::with('kategori')->orderBy('created_at', 'desc')->take(4)->get();
        $aktivitasTerbaru = Peminjaman::with(['siswa', 'buku'])->orderBy('created_at', 'desc')->take(5)->get();
        $terlambat = Peminjaman::with(['siswa', 'buku'])
                        ->where('status', 'Dipinjam')
                        ->where('batas_kembali', '<', date('Y-m-d'))
                        ->take(4)->get();

        // Chart Data (Loans per month this year)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = Peminjaman::whereMonth('tanggal_pinjam', $i)
                            ->whereYear('tanggal_pinjam', date('Y'))
                            ->count();
        }

        return view('dashboards.index', compact(
            'totalSiswa',
            'totalBuku',
            'totalKategori',
            'totalPeminjaman',
            'bukuDipinjam',
            'bukuTerbaru',
            'aktivitasTerbaru',
            'terlambat',
            'chartData'
        ));
    }
}
