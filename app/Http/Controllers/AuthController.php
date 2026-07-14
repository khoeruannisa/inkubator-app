<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ─── FORM LOGIN ───────────────────────────────────────────────
    public function showLogin()
    {
        // Jika sudah login, langsung ke dashboard
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('login');
    }

    // ─── FORM REGISTER ────────────────────────────────────────────
    // Bisa diakses admin yang sudah login untuk menambah user baru
    public function showRegister()
    {
        return view('register');
    }

    // ─── PROSES LOGIN ─────────────────────────────────────────────
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah user terdaftar
        $userExists = DB::table('users')->where('email', $request->email)->exists();

        if (!$userExists) {
            return redirect('/register')
                ->with('error', 'Akun belum terdaftar, silakan registrasi!');
        }

        // Autentikasi menggunakan Auth facade (benar & aman)
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect('/dashboard')
                ->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Password salah, coba lagi!');
    }

    // ─── PROSES REGISTER ──────────────────────────────────────────
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:4',
        ]);

        DB::table('users')->insert([
            'name'       => $request->name,   // Kolom 'name' sesuai migration
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/login')
            ->with('success', 'Registrasi berhasil, silakan login!');
    }

    // ─── LOGOUT (POST) ────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Berhasil logout');
    }
}