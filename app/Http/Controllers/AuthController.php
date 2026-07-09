<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // FORM LOGIN
    public function showLogin()
    {
        return view('login');
    }

    // FORM REGISTER
    public function showRegister()
    {
        return view('register');
    }

    // 🔐 PROSES LOGIN
    public function login(Request $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        // ❌ jika user tidak ada → arahkan ke register
        if (!$user) {
            return redirect('/register')
                ->with('error', 'Akun belum terdaftar, silakan registrasi!');
        }

        // ❌ jika password salah
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah, coba lagi!');
        }

        // ✅ login berhasil
        Session::put('user', $user);

        return redirect('/dashboard')
            ->with('success', 'Login berhasil!');
    }

    // 📝 PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4'
        ]);

        DB::table('users')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => now()
        ]);

        return redirect('/login')
            ->with('success', 'Registrasi berhasil, silakan login!');
    }

    // 🚪 LOGOUT
    public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')
        ->with('success', 'Berhasil logout');
}
}