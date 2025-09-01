<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserRegisteredAdminNotification;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @param string $mode 'login' or 'signup'
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle($mode = 'login')
    {
        // Validasi mode
        if (!in_array($mode, ['login', 'signup'])) {
            return redirect('/')->with('error', 'Mode tidak valid.');
        }

        // Simpan mode di session untuk digunakan di callback
        session(['google_auth_mode' => $mode]);

        // PERBAIKAN: Hapus ->stateless() agar session berfungsi dengan benar.
        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account',
                'access_type' => 'offline'
            ])
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            logger()->info('Google User:', (array) $googleUser);

            if (!$googleUser->getId()) {
                return redirect('login')->with('error', 'Gagal mendapatkan data Google. Coba lagi.');
            }

            $mode = session('google_auth_mode', 'login');
            session()->forget('google_auth_mode');

            $user = User::where('google_id', $googleUser->getId())->first()
                ?? User::where('email', $googleUser->getEmail())->first();

            if ($mode === 'signup') {
                return $this->handleSignup($googleUser, $user);
            } else {
                return $this->handleLogin($googleUser, $user);
            }
        } catch (\Exception $e) {
            // PERUBAHAN DEBUG: Tampilkan semua detail error
            // dd($e);

            // Baris di bawah ini tidak akan dijalankan karena dd() menghentikan semuanya
            logger()->error('Google Auth Error: ' . $e->getMessage());
            return redirect('login')->with('error', 'Terjadi kesalahan saat autentikasi Google.');
        }
    }

    /**
     * Handle the signup process.
     *
     * @param \Laravel\Socialite\Contracts\User $googleUser
     * @param \App\Models\User|null $existingUser
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleSignup($googleUser, $existingUser)
    {
        if ($existingUser) {
            if ($existingUser->is_active) {
                return redirect('login')->with('error', 'Email sudah terdaftar dan aktif. Silakan gunakan Login.');
            } else {
                return redirect('login')->with('error', 'Email sudah terdaftar tapi belum diaktivasi. Silakan tunggu konfirmasi admin atau gunakan Login.');
            }
        }

        // Buat user baru
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'password' => bcrypt(Str::random(24)),
            'is_active' => false,
            'expires_at' => now()->addHours(24),
            'first_login_at' => now(),
        ]);

        // Kirim email notifikasi ke admin
        try {
            $adminEmail = env('ADMIN_EMAIL');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new NewUserRegisteredAdminNotification($user));
            }
        } catch (\Exception $e) {
            logger()->error('Gagal mengirim email notifikasi admin: ' . $e->getMessage());
        }

        return redirect('login')->with('success', 'Pendaftaran berhasil! Silakan tunggu konfirmasi admin dalam 24 jam.');
    }

    /**
     * Handle the login process.
     *
     * @param \Laravel\Socialite\Contracts\User $googleUser
     * @param \App\Models\User|null $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function handleLogin($googleUser, $user)
    {
        if (!$user) {
            return redirect('login')->with('error', 'Akun tidak ditemukan. Silakan daftar terlebih dahulu.');
        }

        // Update google_id jika user sebelumnya daftar via email & password
        if (!$user->google_id) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'first_login_at' => $user->first_login_at ?? now()
            ]);
        }

        // Cek apakah akun sudah kadaluarsa
        if ($user->expires_at && Carbon::parse($user->expires_at)->isPast() && !$user->is_active) {
            return redirect('login')->with('error', 'Akun Anda sudah kadaluarsa. Silakan daftar ulang.');
        }

        // Cek apakah akun sudah aktif
        if (!$user->is_active) {
            return redirect('login')->with('error', 'Akun Anda belum diaktivasi. Silakan tunggu konfirmasi admin.');
        }

        // Login berhasil
        Auth::login($user);
        return redirect('/')->with('success', 'Berhasil masuk!');
    }
}
