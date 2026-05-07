@extends('layout.auth')

@section('title', 'Login')

@section('content')
<div class="auth-card">
    <h2>Masuk Akun</h2>
    <p class="subtitle">Silakan login untuk melanjutkan</p>

    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan password" required>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn-primary">
            <i class='bx bx-log-in'></i> Login
        </button>
    </form>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
    </div>
</div>
@endsection