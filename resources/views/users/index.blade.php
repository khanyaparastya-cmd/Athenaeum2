@extends('layout.master')

@section('title', 'Register')

@section('content')
<div style="padding:20px">

    <h2>Register</h2>

    <form method="POST" action="/register">
        @csrf

        <input type="text" name="name" placeholder="Nama" required><br><br>

        <input type="email" name="email" placeholder="Email" required><br><br>

        <input type="password" name="password" placeholder="Password" required><br><br>

        <button type="submit">Daftar</button>
    </form>

    <br>
    <p>Sudah punya akun? <a href="/login">Login</a></p>

</div>
@endsection 