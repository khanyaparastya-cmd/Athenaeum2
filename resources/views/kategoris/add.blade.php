@extends('layout.master')

@section('title', 'Tambah Kategori')

@section('content')

<style>
.form-wrapper { display: flex; justify-content: center; align-items: center; min-height: 50vh; padding: 20px 0; }
.form-card {
    background: var(--white); padding: 40px; border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.02);
    width: 100%; max-width: 500px;
}
.form-title { color: var(--navy-dark); font-size: 22px; font-weight: 700; margin-bottom: 24px; text-align: center; }
.form-group { margin-bottom: 24px; }
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
        <h2 class="form-title">Tambah Kategori</h2>

        <form action="{{ route('kategoris.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="form-control" placeholder="Contoh: Fiksi, Sejarah, Sains" required>
                @error('nama_kategori') <span class="form-error"><i class='bx bx-error-circle'></i> {{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('kategoris.index') }}" class="btn-cancel"><i class='bx bx-x'></i> Batalkan</a>
                <button type="submit" class="btn-save"><i class='bx bx-check-circle'></i> Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection