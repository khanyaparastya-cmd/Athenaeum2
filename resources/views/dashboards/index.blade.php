@extends('layout.master')

@section('title','Dashboard Utama')

@section('content')

<style>
/* HERO BANNER */
.hero-banner {
    background: linear-gradient(135deg, var(--navy-dark) 0%, rgba(15, 23, 42, 0.8) 100%), url('https://images.unsplash.com/photo-1541963463532-d68292c34b19?auto=format&fit=crop&w=1200&q=80') center/cover;
    border-radius: 20px; padding: 50px 40px; color: var(--white);
    margin-bottom: 40px; position: relative; box-shadow: 0 15px 40px rgba(15, 23, 42, 0.2);
    overflow: hidden; display: flex; justify-content: space-between; align-items: center;
}
.hero-banner::before {
    content: ''; position: absolute; inset: 0; background: radial-gradient(circle at top right, rgba(201, 169, 110, 0.2), transparent);
}
.hero-content { position: relative; z-index: 1; max-width: 600px; }
.hero-content h1 { font-family: 'Inter', serif; font-size: 34px; font-weight: 700; margin-bottom: 14px; letter-spacing: -0.5px; }
.hero-content p { color: rgba(255,255,255,0.8); font-size: 16px; line-height: 1.7; font-weight: 300; }
.hero-date {
    background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);
    padding: 16px 28px; border-radius: 16px; text-align: center; border: 1px solid rgba(255,255,255,0.1);
}
.hero-date b { display: block; font-size: 28px; color: var(--gold); margin-bottom: 4px; }
.hero-date span { font-size: 14px; text-transform: uppercase; letter-spacing: 1.5px; color: #fff; font-weight: 500; }

/* SECTIONS */
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}
@media (max-width: 1024px) {
    .dashboard-grid { grid-template-columns: 1fr; }
}
.section-title {
    font-size: 18px; color: var(--navy-dark); font-weight: 600; margin-bottom: 24px;
    display: flex; align-items: center; gap: 10px; padding-bottom: 14px; border-bottom: 1px solid var(--gray-soft);
}
.section-title i { color: var(--gold); font-size: 22px; }

/* RECENT BOOKS */
.books-list { display: grid; gap: 16px; }
.book-item {
    display: flex; align-items: center; gap: 20px; padding: 20px; border-radius: 16px;
    border: 1px solid var(--gray-soft); transition: 0.3s; background: var(--white);
}
.book-item:hover { transform: translateX(8px); border-color: var(--gold); box-shadow: 0 8px 30px rgba(0,0,0,0.03); }
.book-cover {
    width: 60px; height: 80px; background: linear-gradient(135deg, var(--navy-dark), #1e293b); border-radius: 8px; display: flex; align-items: center; justify-content: center;
    color: var(--gold); font-size: 28px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); flex-shrink: 0;
}
.book-cover-img {
    width: 60px; height: 80px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); flex-shrink: 0;
}
.book-info h4 { font-size: 16px; color: var(--navy-dark); font-weight: 600; margin-bottom: 6px; }
.book-info p { font-size: 13.5px; color: var(--gray-text); line-height: 1.5; }
.book-badge { margin-left: auto; background: var(--gold-transparent); color: #a38245; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; }

/* ACTIVITY LOG */
.activity-box { padding: 30px; background: var(--white); border-radius: 20px; border: 1px solid rgba(0,0,0,0.02); box-shadow: 0 8px 30px rgba(0,0,0,0.03); height: 100%; }
.activity-list { position: relative; padding-left: 20px; margin-top: 10px; }
.activity-list::before {
    content: ''; position: absolute; left: 6px; top: 0; bottom: 0; width: 2px; background: var(--gray-soft);
}
.activity-item { position: relative; margin-bottom: 30px; }
.activity-item:last-child { margin-bottom: 0; }
.activity-item::before {
    content: ''; position: absolute; left: -22px; top: 4px; width: 14px; height: 14px;
    border-radius: 50%; background: var(--gold); border: 3px solid var(--white); box-shadow: 0 0 0 1px var(--gray-soft);
}
.act-time { font-size: 12px; color: var(--gray-text); font-weight: 500; margin-bottom: 6px; display: block; letter-spacing: 0.5px; }
.act-desc { font-size: 14.5px; color: var(--navy-dark); line-height: 1.6; }
.act-desc b { font-weight: 600; color: var(--navy-dark); }
.act-status { display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 11.5px; font-weight: 600; margin-top: 8px; }
.status-pinjam { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
.status-kembali { background: rgba(34, 197, 94, 0.1); color: #16a34a; }

/* OVERDUE ALERTS */
.alert-box {
    background: linear-gradient(to right, #fef2f2, var(--white)); border-left: 4px solid var(--danger);
    padding: 24px; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.05);
}
.alert-box h4 { color: var(--danger); font-size: 16px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px; font-weight: 600; }
.alert-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px dashed var(--gray-soft); }
.alert-item:last-child { border-bottom: none; padding-bottom: 0; }
.alert-info span { display: block; font-size: 15px; color: var(--navy-dark); font-weight: 600; margin-bottom: 2px; }
.alert-info small { font-size: 13px; color: var(--gray-text); }
.alert-due { font-size: 13.5px; color: var(--danger); font-weight: 600; background: rgba(239, 68, 68, 0.1); padding: 6px 12px; border-radius: 8px; }
</style>

<div class="hero-banner">
    <div class="hero-content">
        <h1>Sistem Informasi Perpustakaan</h1>
        <p>Selamat datang di platform tata kelola pustaka eksklusif. Temukan koleksi literatur terbaru dan pantau arus sirkulasi secara menyeluruh.</p>
    </div>
    <div class="hero-date">
        <b>{{ date('d') }}</b>
        <span>{{ date('M Y') }}</span>
    </div>
</div>

@if(isset($terlambat) && count($terlambat) > 0)
<div class="alert-box">
    <h4><i class='bx bx-error-circle'></i> Peringatan Keterlambatan Pengembalian ({{ count($terlambat) }})</h4>
    @foreach($terlambat as $telat)
        <div class="alert-item">
            <div class="alert-info">
                <span>{{ $telat->siswa->nama ?? 'Siswa' }}</span>
                <small>{{ $telat->buku->judul ?? 'Buku Dihapus' }}</small>
            </div>
            <div class="alert-due">Jatuh Tempo: {{ date('d M Y', strtotime($telat->batas_kembali)) }}</div>
        </div>
    @endforeach
</div>
@endif

<div class="dashboard-grid">
    
    <div class="grid-left">
        <h3 class="section-title"><i class='bx bx-book-heart'></i> Akuisisi Buku Terbaru</h3>
        <div class="books-list">
            @forelse($bukuTerbaru as $buku)
                <div class="book-item">
                    @if($buku->foto)
                        <img src="{{ asset('uploads/bukus/' . $buku->foto) }}" alt="Cover Buku" class="book-cover-img">
                    @else
                        <div class="book-cover"><i class='bx bx-book'></i></div>
                    @endif
                    <div class="book-info">
                        <h4>{{ $buku->judul }}</h4>
                        <p>{{ $buku->penulis }} &bull; {{ $buku->tahun_terbit }}</p>
                    </div>
                    <div class="book-badge">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</div>
                </div>
            @empty
                <div style="background:var(--white); padding:30px; border-radius:16px; border:1px solid var(--gray-soft); text-align:center;">
                    <i class='bx bx-info-circle' style="font-size:32px; color:var(--gray-text); margin-bottom:10px;"></i>
                    <p style="color:var(--gray-text); font-size:14.5px;">Belum ada koleksi pustaka ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="grid-right">
        <div class="activity-box">
            <h3 class="section-title"><i class='bx bx-history'></i> Aktivitas Sirkulasi Terkini</h3>
            
            <div class="activity-list">
                @forelse($aktivitasTerbaru as $log)
                    <div class="activity-item">
                        <span class="act-time">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</span>
                        <div class="act-desc">
                            <b>{{ $log->siswa->nama ?? 'Siswa' }}</b> 
                            {{ $log->status == 'Dikembalikan' ? 'telah mengembalikan buku' : 'telah meminjam buku' }}
                            <i>"{{ $log->buku->judul ?? 'Tidak diketahui' }}"</i>
                        </div>
                        <span class="act-status {{ $log->status == 'Dikembalikan' ? 'status-kembali' : 'status-pinjam' }}">
                            {{ $log->status }}
                        </span>
                    </div>
                @empty
                    <div style="text-align:center; padding:30px 0;">
                        <i class='bx bx-sleepy' style="font-size:32px; color:var(--gray-text); margin-bottom:10px;"></i>
                        <p style="color:var(--gray-text); font-size:14.5px;">Tidak ada aktivitas terbaru saat ini.</p>
                    </div>
                @endforelse
            </div>
            
            <a href="{{ route('peminjamans.index') }}" class="btn-gold" style="width:100%; justify-content:center; margin-top:34px; padding:12px;">
                Eksplorasi Seluruh Sirkulasi <i class='bx bx-right-arrow-alt' style="font-size:18px;"></i>
            </a>
        </div>
    </div>

</div>

@endsection