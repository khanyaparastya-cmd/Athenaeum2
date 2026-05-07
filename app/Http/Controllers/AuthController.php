<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // FORM LOGIN
    public function loginForm()
    {
        return view('users.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Auth attempt sukses, redirect ke dashboard
            return redirect()->intended('/');
        }

        return back()->with('error', 'Email atau password salah');
    }

    // FORM REGISTER
    public function registerForm()
    {
        return view('users.register');
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'email.unique' => 'Email sudah terdaftar. Silakan gunakan email lain atau coba login.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'admin' // atau berikan default role 'user'
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar!');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}