@extends('layout.master')

@section('title', 'Katalog Siswa')

@section('content')

@if(session('success'))
    <div style="background:#f0fdf4;color:#15803d;padding:16px 20px;border-radius:12px;margin-bottom:24px;font-size:14.5px;border:1px solid #bbf7d0; display:flex; align-items:center; gap:10px;">
        <i class='bx bx-check-circle' style="font-size:20px;"></i> {{ session('success') }}
    </div>
@endif

<div class="luxury-card" style="padding: 30px;">
    
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:10px;">
        <div>
            <h2 style="color:var(--navy-dark); font-size:22px; font-weight:700; margin-bottom:4px;">Katalog Cendekiawan</h2>
            <p style="color:var(--gray-text); font-size:14px;">Kelola data mahasiswa/siswa yang terdaftar pada sistem sirkulasi terpusat.</p>
        </div>
        <a href="{{ route('siswas.create') }}" class="btn-gold" style="padding: 10px 20px; border-radius:12px;">
            <i class='bx bx-plus' style="font-size:18px;"></i> Tambah Siswa Baru
        </a>
    </div>

    <div style="overflow-x:auto;">
        <table class="luxury-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Identitas Siswa</th>
                    <th>Nomor Induk</th>
                    <th>Pendidikan</th>
                    <th>Tanggal Registrasi</th>
                    <th style="text-align:right;">Aksi Sistem</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $i => $s)
                <tr>
                    <td style="font-weight: 500;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:36px; height:36px; background:var(--gold-transparent); color:var(--gold); display:flex; align-items:center; justify-content:center; border-radius:50%; font-weight:700; font-size:14px;">
                                {{ substr($s->nama, 0, 1) }}
                            </div>
                            <span style="color:var(--navy-dark); font-weight:600;">{{ $s->nama }}</span>
                        </div>
                    </td>
                    <td><span style="background:var(--gray-soft); color:var(--navy-dark); padding:4px 8px; border-radius:6px; font-size:12.5px; font-weight:600; letter-spacing:1px;">{{ $s->nis }}</span></td>
                    <td>
                        <span style="display:block; color:var(--navy-dark); font-weight:500;">Kelas {{ $s->kelas }}</span>
                        <span style="font-size:12px; color:var(--gray-text);">{{ $s->jurusan }}</span>
                    </td>
                    <td>{{ $s->created_at->format('d M Y') }}</td>
                    <td style="text-align:right;">
                        <a href="{{ route('siswas.edit', $s->id) }}" style="color:var(--gold); margin-right:12px; text-decoration:none; display:inline-block; transition:0.2s;" title="Edit" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class='bx bx-edit' style="font-size:20px"></i></a>
                        <form action="{{ route('siswas.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data cendekiawan ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;color:var(--danger);cursor:pointer; display:inline-block; transition:0.2s;" title="Hapus" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class='bx bx-trash' style="font-size:20px"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:60px 20px; text-align:center;">
                        <i class='bx bx-group' style="font-size:48px; color:var(--gray-soft); margin-bottom:12px;"></i>
                        <p style="color:var(--gray-text); font-size:15px;">Belum ada entri data siswa.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection