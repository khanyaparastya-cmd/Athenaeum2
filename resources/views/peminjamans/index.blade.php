@extends('layout.master')

@section('title', 'Peminjaman')

@section('content')

{{-- Sub-Navbar --}}
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
    <a href="{{ route('peminjamans.index') }}" style="padding:8px 18px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600;background:linear-gradient(135deg,#1e3a8a,#2563eb);color:white;box-shadow:0 2px 6px rgba(30,58,138,.2);">
        <i class='bx bx-list-ul'></i> Daftar Sirkulasi
    </a>
    <a href="{{ route('peminjamans.create') }}" style="padding:8px 18px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:500;background:#f1f5f9;color:#334155;">
        <i class='bx bx-plus'></i> Peminjaman Baru
    </a>
    <a href="{{ route('peminjamans.riwayat') }}" style="padding:8px 18px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:500;background:#f1f5f9;color:#334155;">
        <i class='bx bx-history'></i> Riwayat
    </a>
</div>

<div style="background:white;padding:24px;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,.04);">

    @if(session('success'))
        <div style="background:#f0fdf4;color:#15803d;padding:12px 16px;border-radius:10px;margin-bottom:18px;font-size:14px;border:1px solid #bbf7d0;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
        <h2 style="color:#0f172a;font-size:20px;font-weight:700;">Daftar Peminjaman Aktif</h2>
    </div>

    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;min-width:950px;">
            <thead>
                <tr style="background:#f8fafc;border-bottom:2px solid #e2e8f0;">
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">No</th>
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Siswa</th>
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Buku</th>
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Tgl Pinjam</th>
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Batas</th>
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Tgl Kembali</th>
                    <th style="padding:12px 15px;text-align:center;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Status</th>
                    <th style="padding:12px 15px;text-align:right;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Denda</th>
                    <th style="padding:12px 15px;text-align:center;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $i => $p)
                <tr style="border-bottom:1px solid #f1f5f9;transition:.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding:12px 15px;font-size:14px;color:#64748b;">{{ $i + 1 }}</td>
                    <td style="padding:12px 15px;font-size:14px;color:#0f172a;font-weight:500;">{{ $p->siswa->nama ?? '-' }}</td>
                    <td style="padding:12px 15px;font-size:14px;color:#475569;">{{ $p->buku->judul ?? '-' }}</td>
                    <td style="padding:12px 15px;font-size:14px;color:#475569;">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                    <td style="padding:12px 15px;font-size:14px;color:#475569;">
                        @php
                            $isLate = \Carbon\Carbon::today()->gt(\Carbon\Carbon::parse($p->batas_kembali));
                        @endphp
                        @if($p->status === 'Dipinjam' && $isLate)
                            <span style="color:#dc2626; font-weight:600;">{{ $p->batas_kembali->format('d M Y') }}</span>
                        @else
                            {{ $p->batas_kembali->format('d M Y') }}
                        @endif
                    </td>
                    <td style="padding:12px 15px;font-size:14px;color:#475569;">{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d M Y') : '—' }}</td>
                    <td style="padding:12px 15px;text-align:center;">
                        @if($p->status === 'Dipinjam')
                            <span style="background:#fef3c7;color:#92400e;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">Dipinjam</span>
                        @else
                            <span style="background:#dcfce7;color:#166534;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">Dikembalikan</span>
                        @endif
                    </td>
                    <td style="padding:12px 15px;text-align:right;font-size:14px;font-weight:700;color:#dc2626;">
                        Rp {{ number_format($p->denda, 0, ',', '.') }}
                    </td>
                    <td style="padding:12px 15px;text-align:center;white-space:nowrap;">
                        @if($p->status === 'Dipinjam')
                            <form action="{{ route('peminjamans.kembalikan', $p->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Kembalikan buku ini dan hitung otomatis dendanya?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" style="background:none;border:none;color:#16a34a;cursor:pointer;" title="Kembalikan Buku"><i class='bx bx-check-circle' style="font-size:22px"></i></button>
                            </form>
                            <a href="{{ route('peminjamans.edit', $p->id) }}" style="color:#3b82f6;margin:0 4px;text-decoration:none;" title="Edit"><i class='bx bx-edit' style="font-size:20px"></i></a>
                        @endif
                        <form action="{{ route('peminjamans.destroy', $p->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data peminjaman ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;color:#ef4444;cursor:pointer;" title="Hapus"><i class='bx bx-trash' style="font-size:20px"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="padding:30px;text-align:center;color:#94a3b8;font-size:14px;">
                        <i class='bx bx-info-circle' style="font-size:20px;vertical-align:middle;margin-right:4px;"></i> Belum ada data peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection