<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Proses login siswa/pelatih/admin
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Regenerasi session
            $request->session()->regenerate();

            // Simpan username ke cookie jika Remember Me dicentang
            if ($remember) {
                Cookie::queue('remember_username', $request->username, 60 * 24 * 30); // 30 hari
            } else {
                Cookie::queue(Cookie::forget('remember_username'));
            }

            // Redirect sesuai role
            $user = Auth::user();
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'pelatih':
                    return redirect()->route('pelatih.dashboard');
                case 'siswa':
                    return redirect()->route('siswa.dashboard');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors([
                        'username' => 'Role akun tidak dikenali.',
                    ]);
            }
        }

        // Login gagal
        return back()->withErrors([
            'username' => 'Login gagal, cek username dan password.',
        ])->onlyInput('username');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}