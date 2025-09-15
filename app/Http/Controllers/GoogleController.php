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
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Two\InvalidStateException;

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

        // Clear any existing Google auth sessions to prevent conflicts
        session()->forget(['google_auth_mode', '_token', 'state']);
        
        // Simpan mode di session untuk digunakan di callback
        session(['google_auth_mode' => $mode]);

        try {
            return Socialite::driver('google')
                ->stateless() // Menggunakan stateless untuk menghindari session conflicts
                ->with([
                    'prompt' => 'select_account',
                    'access_type' => 'offline'
                ])
                ->redirect();
        } catch (\Exception $e) {
            Log::error('Google Redirect Error: ' . $e->getMessage(), [
                'mode' => $mode,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect('login')->with('error', 'Gagal menghubungi Google. Silakan coba lagi.');
        }
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            // Check for error parameter from Google
            if (request()->has('error')) {
                $error = request()->get('error');
                Log::warning('Google OAuth Error Parameter:', ['error' => $error]);
                
                if ($error === 'access_denied') {
                    return redirect('login')->with('error', 'Login dibatalkan oleh pengguna.');
                }
                
                return redirect('login')->with('error', 'Terjadi kesalahan dari Google. Silakan coba lagi.');
            }

            $googleUser = Socialite::driver('google')->stateless()->user();

            Log::info('Google User Data Retrieved:', [
                'id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName()
            ]);

            if (!$googleUser->getId()) {
                Log::error('Google User ID is empty');
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

        } catch (InvalidStateException $e) {
            Log::error('Google OAuth Invalid State Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Auto retry untuk InvalidStateException
            return $this->autoRetryGoogleAuth();
            
        } catch (\Laravel\Socialite\Two\TokenException $e) {
            Log::error('Google OAuth Token Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return $this->autoRetryGoogleAuth();
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::error('Google OAuth Client Exception:', [
                'message' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : 'No response',
                'trace' => $e->getTraceAsString()
            ]);
            
            return $this->autoRetryGoogleAuth();
            
        } catch (\Exception $e) {
            Log::error('Google Auth General Exception:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Untuk debugging, uncomment baris di bawah jika masih ada error
            // dd($e);
            
            return redirect('login')->with('error', 'Terjadi kesalahan saat autentikasi Google. Silakan coba lagi.');
        }
    }

    /**
     * Auto retry Google authentication when certain exceptions occur
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function autoRetryGoogleAuth()
    {
        $retryCount = session('google_retry_count', 0);
        
        if ($retryCount < 2) { // Maksimal 2 kali retry
            session(['google_retry_count' => $retryCount + 1]);
            
            Log::info('Auto retrying Google auth', ['attempt' => $retryCount + 1]);
            
            // Redirect kembali ke Google dengan delay singkat
            return redirect()->route('google.redirect', ['mode' => session('google_auth_mode', 'login')]);
        }
        
        // Reset retry counter dan redirect ke login dengan error
        session()->forget('google_retry_count');
        
        return redirect('login')->with('error', 'Login Google gagal setelah beberapa percobaan. Silakan refresh halaman dan coba lagi.');
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
        // Reset retry counter on successful callback
        session()->forget('google_retry_count');
        
        if ($existingUser) {
            if ($existingUser->is_active) {
                return redirect('login')->with('error', 'Email sudah terdaftar dan aktif. Silakan gunakan Login.');
            } else {
                return redirect('login')->with('error', 'Email sudah terdaftar tapi belum diaktivasi. Silakan tunggu konfirmasi admin atau gunakan Login.');
            }
        }

        try {
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

            Log::info('New user created via Google signup:', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);

            // Kirim email notifikasi ke admin
            try {
                $adminEmail = env('ADMIN_EMAIL');
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new NewUserRegisteredAdminNotification($user));
                    Log::info('Admin notification email sent for user:', ['user_id' => $user->id]);
                }
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email notifikasi admin:', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);
            }

            return redirect('login')->with('success', 'Pendaftaran berhasil! Silakan tunggu konfirmasi admin dalam 24 jam.');
            
        } catch (\Exception $e) {
            Log::error('Error creating user during signup:', [
                'google_id' => $googleUser->getId(),
                'email' => $googleUser->getEmail(),
                'error' => $e->getMessage()
            ]);
            
            return redirect('login')->with('error', 'Gagal membuat akun. Silakan coba lagi.');
        }
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
        // Reset retry counter on successful callback
        session()->forget('google_retry_count');
        
        if (!$user) {
            return redirect('login')->with('error', 'Akun tidak ditemukan. Silakan daftar terlebih dahulu.');
        }

        try {
            // Update google_id jika user sebelumnya daftar via email & password
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'first_login_at' => $user->first_login_at ?? now()
                ]);
                
                Log::info('Updated user with Google ID:', [
                    'user_id' => $user->id,
                    'google_id' => $googleUser->getId()
                ]);
            }

            // Cek apakah akun sudah kadaluarsa
            if ($user->expires_at && Carbon::parse($user->expires_at)->isPast() && !$user->is_active) {
                Log::warning('User account expired:', [
                    'user_id' => $user->id,
                    'expires_at' => $user->expires_at
                ]);
                
                return redirect('login')->with('error', 'Akun Anda sudah kadaluarsa. Silakan daftar ulang.');
            }

            // Cek apakah akun sudah aktif
            if (!$user->is_active) {
                Log::info('User account not active yet:', ['user_id' => $user->id]);
                return redirect('login')->with('error', 'Akun Anda belum diaktivasi. Silakan tunggu konfirmasi admin.');
            }

            // Login berhasil
            Auth::login($user);
            
            Log::info('User logged in successfully:', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
            
            return redirect('/')->with('success', 'Berhasil masuk!');
            
        } catch (\Exception $e) {
            Log::error('Error during login process:', [
                'user_id' => $user->id ?? null,
                'google_id' => $googleUser->getId(),
                'error' => $e->getMessage()
            ]);
            
            return redirect('login')->with('error', 'Terjadi kesalahan saat login. Silakan coba lagi.');
        }
    }
}