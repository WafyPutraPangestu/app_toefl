<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserApprovedNotification;
use App\Models\TestSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserManagementController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna atau daftar permintaan ujian ulang,
     * tergantung pada tab yang dipilih di view.
     */
    public function index(Request $request)
    {
        // --- Hitung semua statistik ---
        $stats = [
            'totalUsers' => User::where('role', '!=', 'admin')->count(),
            'activeUsersCount' => User::where('role', '!=', 'admin')->where('is_active', true)->count(),

            // PERBAIKAN 1: Hitung hanya permintaan yang BELUM DISETUJUI
            'pendingRetakeCount' => TestSession::whereNotNull('retake_requested_at')
                ->whereNull('retake_approved_at')
                ->count()
        ];
        $stats['pendingUsersCount'] = $stats['totalUsers'] - $stats['activeUsersCount'];

        // --- LOGIKA UNTUK MENAMPILKAN TAB YANG BERBEDA ---
        if ($request->get('tab') === 'retake_requests') {

            // PERBAIKAN 2: Ambil hanya permintaan yang BELUM DISETUJUI
            $retakeRequests = TestSession::whereNotNull('retake_requested_at')
                ->whereNull('retake_approved_at') // <-- KONDISI PENTING DITAMBAHKAN DI SINI
                ->with(['user', 'testPackage', 'result'])
                ->latest('retake_requested_at')
                ->paginate(15);

            return view('admin.manajemen-user.index', compact('retakeRequests', 'stats'));
        }

        // Logika default untuk menampilkan daftar peserta
        $query = User::where('role', '!=', 'admin');
        if ($request->get('tab') === 'active') {
            $query->where('is_active', true);
        } elseif ($request->get('tab') === 'pending') {
            $query->where('is_active', false);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.manajemen-user.index', compact('users', 'stats'));
    }


    /**
     * Menampilkan detail satu pengguna beserta riwayat ujiannya.
     */
    public function show(User $user)
    {
        $user->load([
            'testSessions' => fn($query) => $query->latest('start_time'),
            'testSessions.result',
            'testSessions.testPackage'
        ]);
        return view('admin.manajemen-user.show', compact('user'));
    }

    /**
     * Method untuk menyetujui AKUN pengguna.
     */
    public function approve(User $user)
    {
        // Cek jika user sudah aktif
        if ($user->is_active) {
            return redirect()->back()->with('info', 'User sudah dalam status aktif.');
        }

        // Update status user menjadi aktif
        $user->update(['is_active' => true]);

        // --- PERUBAHAN 2: Tambahkan blok untuk mengirim email ke user ---
        try {
            // Kirim notifikasi email ke user bahwa akunnya sudah aktif
            Mail::to($user->email)->send(new UserApprovedNotification($user));
        } catch (\Exception $e) {
            // Jika email gagal, proses approval tetap sukses.
            // Catat error dan berikan notifikasi tambahan di UI.
            logger()->error('Gagal mengirim email persetujuan ke user: ' . $e->getMessage());

            // Kembali dengan pesan sukses, namun beri tahu bahwa email gagal dikirim
            return redirect()->back()->with('success', 'User berhasil disetujui. (Notifikasi email gagal dikirim)');
        }
        // --- Akhir dari blok baru ---

        // Kembali dengan pesan sukses penuh
        return redirect()->back()->with('success', 'User berhasil disetujui dan diaktifkan.');
    }

    /**
     * Method untuk menyetujui UJIAN ULANG.
     */
    public function approveRetake(TestSession $testSession)
    {
        // Cek apakah permintaan ada dan belum disetujui
        if ($testSession->retake_requested_at && is_null($testSession->retake_approved_at)) {

            // HANYA UPDATE, TIDAK ADA DELETE!
            $testSession->update([
                'retake_approved_at' => now()
            ]);

            // Kirim notifikasi sukses
            return redirect()->route('manajemen-user.index', ['tab' => 'retake_requests'])
                ->with('success', 'Persetujuan ujian ulang berhasil. Peserta sekarang dapat mengerjakan tes kembali.');
        }

        // Kirim notifikasi jika ada yang salah
        return redirect()->route('manajemen-user.index', ['tab' => 'retake_requests'])
            ->with('error', 'Permintaan ini tidak dapat diproses.');
    }

    /**
     * Menghapus pengguna dari database.
     */
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus user admin.');
        }
        $userName = $user->name;
        $user->delete();
        return redirect()->back()->with('success', "User {$userName} berhasil dihapus.");
    }
}
