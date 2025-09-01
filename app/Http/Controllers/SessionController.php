<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle the authentication request.
     */
    public function authenticate(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ],
            [
                'email.required' => 'Email ini harus diisi.',
                'password.required' => 'Password ini harus diisi.',
                'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
                'email.email' => 'Format email tidak valid.',
            ]
        );
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.',
            ]);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }
        if ($user->expires_at && Carbon::parse($user->expires_at)->isPast() && !$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda sudah kadaluarsa. Silakan daftar ulang.',
            ]);
        }
        if (!$user->is_active) {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akun Anda menunggu persetujuan admin.',
            ]);
        }
        return redirect()->intended('/');
    }

    /**
     * Show the registration form.
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration request.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|confirmed',
            ],
            [
                'name.required' => 'Nama ini harus diisi.',
                'email.required' => 'Email ini harus diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Password ini harus diisi.',
                'password.min' => 'Password harus terdiri dari minimal 6 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_active' => false,
            'expires_at' => now()->addHours(24),
            'first_login_at' => now(),
        ]);
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan menunggu admin konfirmasi.');
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
