<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form login.
     */
    public function showLoginForm()
    {
        // Cukup kembalikan view untuk login
        return view('auths.login');
    }

    /**
     * Menangani permintaan login dari user.
     */
    public function login(Request $request): RedirectResponse
    {
        // Validasi input dari form
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Mencoba untuk mengautentikasi user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect ke halaman dashboard setelah berhasil login
            return redirect()->intended('dashboard');
        }

        // Jika autentikasi gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang diberikan tidak cocok.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan halaman form registrasi.
     */
    public function showRegistrationForm()
    {
        // Cukup kembalikan view untuk registrasi
        return view('auths.register');
    }

    /**
     * Menangani permintaan registrasi dari user.
     */
    public function register(Request $request): RedirectResponse
    {
        // Validasi input dari form registrasi
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Jika validasi berhasil, buat user baru
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Redirect ke halaman login setelah registrasi berhasil
        return redirect('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * Menangani proses logout user.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirect ke halaman utama atau halaman login setelah logout
        return redirect('/');
    }
}
