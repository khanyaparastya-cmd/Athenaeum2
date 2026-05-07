@extends('layout.master')

@section('title', 'Riwayat Peminjaman')

@section('content')

{{-- Sub-Navbar --}}
<div style="display:flex;gap:8px;margin-bottom:20px;flex-wrap:wrap;">
    <a href="{{ route('peminjamans.index') }}" style="padding:8px 18px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:500;background:#f1f5f9;color:#334155;">
        <i class='bx bx-list-ul'></i> Daftar Sirkulasi
    </a>
    <a href="{{ route('peminjamans.create') }}" style="padding:8px 18px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:500;background:#f1f5f9;color:#334155;">
        <i class='bx bx-plus'></i> Peminjaman Baru
    </a>
    <a href="{{ route('peminjamans.riwayat') }}" style="padding:8px 18px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600;background:linear-gradient(135deg,#1e3a8a,#2563eb);color:white;box-shadow:0 2px 6px rgba(30,58,138,.2);">
        <i class='bx bx-history'></i> Riwayat
    </a>
</div>

<div style="background:white;padding:24px;border-radius:14px;box-shadow:0 2px 8px rgba(0,0,0,.04);">
    <h2 style="color:#0f172a;font-size:20px;font-weight:700;margin-bottom:20px;">Riwayat Peminjaman</h2>

    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;min-width:800px;">
            <thead>
                <tr style="background:#f8fafc;border-bottom:2px solid #e2e8f0;">
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">No</th>
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Siswa</th>
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Buku</th>
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Tgl Pinjam</th>
                    <th style="padding:12px 15px;text-align:left;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Tgl Kembali</th>
                    <th style="padding:12px 15px;text-align:center;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Status</th>
                    <th style="padding:12px 15px;text-align:right;font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.5px;">Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $i => $p)
                <tr style="border-bottom:1px solid #f1f5f9;transition:.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding:12px 15px;font-size:14px;color:#64748b;">{{ $i + 1 }}</td>
                    <td style="padding:12px 15px;font-size:14px;color:#0f172a;font-weight:500;">{{ $p->siswa->nama ?? '-' }}</td>
                    <td style="padding:12px 15px;font-size:14px;color:#475569;">{{ $p->buku->judul ?? '-' }}</td>
                    <td style="padding:12px 15px;font-size:14px;color:#475569;">{{ $p->tanggal_pinjam->format('d M Y') }}</td>
                    <td style="padding:12px 15px;font-size:14px;color:#475569;">{{ $p->tanggal_kembali ? $p->tanggal_kembali->format('d M Y') : '—' }}</td>
                    <td style="padding:12px 15px;text-align:center;">
                        <span style="background:#dcfce7;color:#166534;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;">Dikembalikan</span>
                    </td>
                    <td style="padding:12px 15px;text-align:right;font-size:14px;font-weight:600;color:{{ $p->denda != 0 ? '#dc2626' : '#16a34a' }};">
                        Rp {{ number_format(abs($p->denda), 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:30px;text-align:center;color:#94a3b8;font-size:14px;">
                        <i class='bx bx-info-circle' style="font-size:20px;vertical-align:middle;margin-right:4px;"></i> Belum ada riwayat peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 24px;">
    <h2 style="color:#0f172a;font-size:18px;font-weight:700;margin-bottom:16px;">Statistik & Laporan Denda</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
        
        <!-- Total Pendapatan Denda -->
        <div style="background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.04);position:relative;overflow:hidden;">
            <div style="position:absolute;top:0;left:0;width:4px;height:100%;background:#ef4444;"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <p style="font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;margin-bottom:4px;margin-top:0;">Total Pendapatan</p>
                    <h3 style="font-size:24px;color:#0f172a;font-weight:700;margin:0;">Rp {{ number_format($peminjamans->sum(fn($p) => abs($p->denda)), 0, ',', '.') }}</h3>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;background:#fee2e2;display:flex;align-items:center;justify-content:center;color:#ef4444;">
                    <i class='bx bx-money' style="font-size:24px;"></i>
                </div>
            </div>
        </div>

        <!-- Total Dikembalikan -->
        <div style="background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.04);position:relative;overflow:hidden;">
            <div style="position:absolute;top:0;left:0;width:4px;height:100%;background:#3b82f6;"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <p style="font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;margin-bottom:4px;margin-top:0;">Dikembalikan</p>
                    <h3 style="font-size:24px;color:#0f172a;font-weight:700;margin:0;">{{ $peminjamans->count() }} <span style="font-size:14px;font-weight:500;color:#64748b;">Buku</span></h3>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;background:#dbeafe;display:flex;align-items:center;justify-content:center;color:#3b82f6;">
                    <i class='bx bx-book-bookmark' style="font-size:24px;"></i>
                </div>
            </div>
        </div>

        <!-- Tepat Waktu -->
        <div style="background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.04);position:relative;overflow:hidden;">
            <div style="position:absolute;top:0;left:0;width:4px;height:100%;background:#10b981;"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <p style="font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;margin-bottom:4px;margin-top:0;">Tepat Waktu</p>
                    <h3 style="font-size:24px;color:#0f172a;font-weight:700;margin:0;">{{ $peminjamans->where('denda', 0)->count() }} <span style="font-size:14px;font-weight:500;color:#64748b;">Buku</span></h3>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;background:#d1fae5;display:flex;align-items:center;justify-content:center;color:#10b981;">
                    <i class='bx bx-check-circle' style="font-size:24px;"></i>
                </div>
            </div>
        </div>

        <!-- Terlambat (Denda) -->
        <div style="background:white;padding:20px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.04);position:relative;overflow:hidden;">
            <div style="position:absolute;top:0;left:0;width:4px;height:100%;background:#f59e0b;"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <p style="font-size:13px;color:#64748b;font-weight:600;text-transform:uppercase;margin-bottom:4px;margin-top:0;">Terlambat</p>
                    <h3 style="font-size:24px;color:#0f172a;font-weight:700;margin:0;">{{ $peminjamans->filter(fn($p) => $p->denda != 0)->count() }} <span style="font-size:14px;font-weight:500;color:#64748b;">Buku</span></h3>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;background:#fef3c7;display:flex;align-items:center;justify-content:center;color:#f59e0b;">
                    <i class='bx bx-time-five' style="font-size:24px;"></i>
                </div>
            </div>
        </div>
        
    </div>
</div>

@endsection
