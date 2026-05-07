@extends('layout.master')

@section('title', 'Tambah Buku')

@section('content')

<style>
.form-wrapper { display: flex; justify-content: center; align-items: center; min-height: 70vh; padding: 20px 0; }
.form-card {
    background: var(--white); padding: 40px; border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.02);
    width: 100%; max-width: 550px;
}
.form-title { color: var(--navy-dark); font-size: 22px; font-weight: 700; margin-bottom: 24px; text-align: center; }
.form-group { margin-bottom: 20px; }
.form-label { display: block; margin-bottom: 8px; font-size: 13.5px; color: var(--navy-dark); font-weight: 600; }
.form-control {
    width: 100%; padding: 12px 16px; border: 1.5px solid var(--gray-soft); border-radius: 12px;
    font-size: 14px; outline: none; transition: 0.3s; background: #faf9f7; color: var(--navy-dark);
}
.form-control:focus { border-color: var(--gold); background: var(--white); box-shadow: 0 0 0 4px rgba(201, 169, 110, 0.1); }
.form-error { color: var(--danger); font-size: 12px; margin-top: 6px; display: block; font-weight: 500; }
.form-actions { display: flex; gap: 12px; margin-top: 32px; }
.btn-save {
    flex: 1; background: var(--navy-dark); color: var(--white); border: none; padding: 12px;
    border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 14.5px; transition: 0.3s;
    display: inline-flex; justify-content: center; align-items: center; gap: 8px;
}
.btn-save:hover { background: #1e293b; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(15, 23, 42, 0.15); }
.btn-cancel {
    flex: 1; background: var(--gray-soft); color: var(--navy-dark); padding: 12px;
    border-radius: 12px; font-weight: 600; text-decoration: none; font-size: 14.5px;
    display: inline-flex; justify-content: center; align-items: center; gap: 8px; transition: 0.3s;
}
.btn-cancel:hover { background: #d1d5db; }
</style>

<div class="form-wrapper">
    <div class="form-card">
        <h2 class="form-title">Tambah Koleksi Pustaka</h2>

        <form action="{{ route('bukus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Foto Buku (Opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                @error('foto') <span class="form-error"><i class='bx bx-error-circle'></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul') }}" class="form-control" placeholder="Masukkan judul buku" required>
                @error('judul') <span class="form-error"><i class='bx bx-error-circle'></i> {{ $message }}</span> @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Penulis / Pengarang</label>
                    <input type="text" name="penulis" value="{{ old('penulis') }}" class="form-control" placeholder="Nama pengarang" required>
                    @error('penulis') <span class="form-error"><i class='bx bx-error-circle'></i> {{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" class="form-control" placeholder="Contoh: 2024" required>
                    @error('tahun_terbit') <span class="form-error"><i class='bx bx-error-circle'></i> {{ $message }}</span> @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label class="form-label">Kategori Pustaka</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="" disabled {{ old('kategori_id') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id') <span class="form-error"><i class='bx bx-error-circle'></i> {{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Stok Tersedia</label>
                    <input type="number" name="stok" value="{{ old('stok', 1) }}" min="0" class="form-control" placeholder="Jumlah" required>
                    @error('stok') <span class="form-error"><i class='bx bx-error-circle'></i> {{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('bukus.index') }}" class="btn-cancel"><i class='bx bx-x'></i> Batalkan</a>
                <button type="submit" class="btn-save"><i class='bx bx-check-circle'></i> Simpan Buku</button>
            </div>
        </form>
    </div>
</div>
@endsection