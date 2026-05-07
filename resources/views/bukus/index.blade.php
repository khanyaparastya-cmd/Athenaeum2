@extends('layout.master')

@section('title', 'Katalog Pustaka')

@section('content')

@if(session('success'))
    <div style="background:#f0fdf4;color:#15803d;padding:16px 20px;border-radius:12px;margin-bottom:24px;font-size:14.5px;border:1px solid #bbf7d0; display:flex; align-items:center; gap:10px;">
        <i class='bx bx-check-circle' style="font-size:20px;"></i> {{ session('success') }}
    </div>
@endif

<div class="luxury-card" style="padding: 30px;">
    
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:10px;">
        <div>
            <h2 style="color:var(--navy-dark); font-size:22px; font-weight:700; margin-bottom:4px;">Koleksi Pustaka</h2>
            <p style="color:var(--gray-text); font-size:14px;">Basis data seluruh koleksi buku literatur dan referensi akademik.</p>
        </div>
        <a href="{{ route('bukus.create') }}" class="btn-gold" style="padding: 10px 20px; border-radius:12px;">
            <i class='bx bx-plus' style="font-size:18px;"></i> Tambah Koleksi Buku
        </a>
    </div>
    <!-- Filter Kategori -->
    <div style="display: flex; gap: 10px; margin-bottom: 24px; flex-wrap: wrap;">
        <a href="{{ route('bukus.index') }}" 
           style="padding: 8px 16px; border-radius: 20px; font-size: 13.5px; font-weight: 600; text-decoration: none; transition: 0.2s;
                  {{ empty($kategori_id) ? 'background: var(--navy-dark); color: white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);' : 'background: #f8fafc; color: var(--gray-text); border: 1px solid #e2e8f0;' }}"
           onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            Semua
        </a>
        @foreach($kategoris as $kat)
            <a href="{{ route('bukus.index', ['kategori' => $kat->id]) }}" 
               style="padding: 8px 16px; border-radius: 20px; font-size: 13.5px; font-weight: 600; text-decoration: none; transition: 0.2s;
                      {{ isset($kategori_id) && $kategori_id == $kat->id ? 'background: var(--navy-dark); color: white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);' : 'background: #f8fafc; color: var(--gray-text); border: 1px solid #e2e8f0;' }}"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                {{ $kat->nama_kategori }}
            </a>
        @endforeach
    </div>

    <div style="overflow-x:auto;">
        <table class="luxury-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Detail Buku</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th style="text-align:right;">Aksi Sistem</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bukus as $i => $b)
                <tr>
                    <td style="font-weight: 500;">{{ $i + 1 }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:14px;">
                            @if($b->foto)
                                <img src="{{ asset('uploads/bukus/' . $b->foto) }}" alt="Foto" style="width:40px; height:54px; object-fit:cover; border-radius:6px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                            @else
                                <div style="width:40px; height:54px; background:linear-gradient(135deg, var(--navy-dark), #1e293b); border-radius:6px; display:flex; align-items:center; justify-content:center; color:var(--gold); box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                                    <i class='bx bx-book' style="font-size:20px;"></i>
                                </div>
                            @endif
                            <div>
                                <span style="display:block; color:var(--navy-dark); font-weight:600; font-size:14.5px; margin-bottom:2px;">{{ $b->judul }}</span>
                                <span style="font-size:12.5px; color:var(--gray-text);">Oleh: {{ $b->penulis }}</span>
                            </div>
                        </div>
                    </td>
                    <td>{{ $b->tahun_terbit }}</td>
                    <td>
                        <span style="background:var(--gold-transparent); color:#a38245; padding:4px 10px; border-radius:20px; font-size:11.5px; font-weight:600;">
                            {{ $b->kategori->nama_kategori ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @if($b->stok > 0)
                            <span style="color:#16a34a; font-weight:600; font-size:14px;">{{ $b->stok }} eks</span>
                        @else
                            <span style="color:var(--danger); font-weight:600; font-size:14px;">Habis</span>
                        @endif
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('bukus.edit', $b->id) }}" style="color:var(--gold); margin-right:12px; text-decoration:none; display:inline-block; transition:0.2s;" title="Edit" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class='bx bx-edit' style="font-size:20px"></i></a>
                        <form action="{{ route('bukus.destroy', $b->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin memusnahkan arsip pustaka ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background:none;border:none;color:var(--danger);cursor:pointer; display:inline-block; transition:0.2s;" title="Hapus" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'"><i class='bx bx-trash' style="font-size:20px"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:60px 20px; text-align:center;">
                        <i class='bx bx-library' style="font-size:48px; color:var(--gray-soft); margin-bottom:12px;"></i>
                        <p style="color:var(--gray-text); font-size:15px;">Belum ada entri koleksi buku.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection