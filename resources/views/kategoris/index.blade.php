@extends('layout.master')

@section('title', 'Kategori Koleksi')

@section('content')

@if(session('success'))
    <div style="background:#f0fdf4;color:#15803d;padding:16px 20px;border-radius:12px;margin-bottom:24px;font-size:14.5px;border:1px solid #bbf7d0; display:flex; align-items:center; gap:10px;">
        <i class='bx bx-check-circle' style="font-size:20px;"></i> {{ session('success') }}
    </div>
@endif

<div class="luxury-card" style="padding: 30px;">
    
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:10px;">
        <div>
            <h2 style="color:var(--navy-dark); font-size:22px; font-weight:700; margin-bottom:4px;">Kategori Koleksi</h2>
            <p style="color:var(--gray-text); font-size:14px;">Klasifikasi bidang studi dan genre pustaka akademik.</p>
        </div>
        <a href="{{ route('kategoris.create') }}" class="btn-gold" style="padding: 10px 20px; border-radius:12px;">
            <i class='bx bx-plus' style="font-size:18px;"></i> Tambah Kategori
        </a>
    </div>

    <div style="overflow-x:auto;">
        <table class="luxury-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th style="text-align:right;">Aksi Sistem</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $i => $k)
                <tr>
                    <td style="font-weight: 500; width:80px;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:inline-flex; align-items:center; gap:10px; background:var(--gold-transparent); padding:6px 14px; border-radius:20px;">
                            <i class='bx bx-collection' style="color:var(--gold); font-size:18px;"></i>
                            <span style="color:var(--navy-dark); font-weight:600; font-size:14px;">{{ $k->nama_kategori }}</span>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('kategoris.edit', $k->id) }}" style="color:var(--gold); margin-right:12px; text-decoration:none; display:inline-block; transition:0.2s;" title="Edit" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class='bx bx-edit' style="font-size:20px"></i></a>
                        <form action="{{ route('kategoris.destroy', $k->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus klasifikasi kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;color:var(--danger);cursor:pointer; display:inline-block; transition:0.2s;" title="Hapus" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class='bx bx-trash' style="font-size:20px"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding:60px 20px; text-align:center;">
                        <i class='bx bx-category' style="font-size:48px; color:var(--gray-soft); margin-bottom:12px;"></i>
                        <p style="color:var(--gray-text); font-size:15px;">Belum ada klasifikasi kategori.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection