<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan Form Register
    public function showRegisterForm()
    {
        return view('auth.register'); // Sesuaikan jika foldernya berbeda
    }

    // Memproses Register
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_hp' => ['required', 'string', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'peminjam', // Sesuaikan role default jika ada
        ]);

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('peminjam.katalog');
    }

    // Menampilkan Form Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Memproses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect berdasarkan Role sesuai matriks Anda
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role == 'petugas') {
                return redirect()->route('petugas.peminjaman.index');
            } elseif ($user->role == 'peminjam') {
                return redirect()->route('peminjam.katalog');
            }

            Auth::logout();
            return redirect()->route('login')->with('error', 'Role tidak dikenal.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}