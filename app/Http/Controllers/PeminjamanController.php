<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Models\Buku;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['siswa', 'buku'])->latest()->get();
        return view('peminjamans.index', compact('peminjamans'));
    }

    public function create()
    {
        $siswas = Siswa::orderBy('nama')->get();
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->get();
        return view('peminjamans.add', compact('siswas', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'batas_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        Peminjaman::create([
            'siswa_id' => $request->siswa_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'batas_kembali' => $request->batas_kembali,
            'status' => 'Dipinjam',
            'denda' => 0,
        ]);

        // Kurangi stok buku
        $buku = Buku::find($request->buku_id);
        if ($buku && $buku->stok > 0) {
            $buku->decrement('stok');
        }

        return redirect()->route('peminjamans.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::with(['siswa', 'buku'])->findOrFail($id);
        $siswas = Siswa::orderBy('nama')->get();
        $bukus = Buku::orderBy('judul')->get();
        return view('peminjamans.edit', compact('peminjaman', 'siswas', 'bukus'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'batas_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($request->only(['siswa_id', 'buku_id', 'tanggal_pinjam', 'batas_kembali']));

        return redirect()->route('peminjamans.index')
            ->with('success', 'Peminjaman berhasil diperbarui.');
    }

    /**
     * Kembalikan buku — hitung denda otomatis
     */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $tanggalKembali = Carbon::today();
        $batasKembali = Carbon::parse($peminjaman->batas_kembali);

        $denda = 0;
        if ($tanggalKembali->gt($batasKembali)) {
            $selisih = abs($tanggalKembali->diffInDays($batasKembali));
            $denda = $selisih * 2000; // Rp 2.000 per hari
        }

        $peminjaman->update([
            'tanggal_kembali' => $tanggalKembali,
            'status' => 'Dikembalikan',
            'denda' => $denda,
        ]);

        // Kembalikan stok buku
        $buku = Buku::find($peminjaman->buku_id);
        if ($buku) {
            $buku->increment('stok');
        }

        $dendaFormatted = 'Rp ' . number_format($denda, 0, ',', '.');
        return redirect()->route('peminjamans.index')
            ->with('success', "Buku berhasil dikembalikan. Denda: {$dendaFormatted}");
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Jika masih dipinjam, kembalikan stok
        if ($peminjaman->status === 'Dipinjam') {
            $buku = Buku::find($peminjaman->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }
        }

        $peminjaman->delete();

        return redirect()->route('peminjamans.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function riwayat()
    {
        $peminjamans = Peminjaman::with(['siswa', 'buku'])
            ->where('status', 'Dikembalikan')
            ->latest()
            ->get();
        return view('peminjamans.riwayat', compact('peminjamans'));
    }
}
