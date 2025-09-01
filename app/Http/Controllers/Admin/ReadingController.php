<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReadingPassage; // Panggil model yang sesuai
use App\Models\TestPackage;    // Panggil model TestPackage untuk dropdown
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReadingController extends Controller
{
    /**
     * Menampilkan daftar semua teks bacaan.
     */
    public function index(Request $request)
    {
        // Ambil semua data passage dengan relasi ke testPackage untuk ditampilkan
        // dan gunakan paginasi
        $query = ReadingPassage::with('testPackage')->latest();

        // Fitur pencarian sederhana berdasarkan judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $passages = $query->paginate(10)->withQueryString();

        return view('admin.manajemen-reading.index', compact('passages'));
    }

    /**
     * Menampilkan formulir untuk membuat teks bacaan baru.
     */
    public function create()
    {
        // Ambil semua test package untuk ditampilkan di dropdown
        $testPackages = TestPackage::orderBy('title')->get();
        return view('admin.manajemen-reading.create', compact('testPackages'));
    }

    /**
     * Menyimpan teks bacaan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'test_package_id' => 'required|exists:test_packages,id',
            'title' => 'required|string|max:255',
            'passage_text' => 'required|string',
        ]);

        // Buat data baru di database
        ReadingPassage::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('manajemen-reading.index')
            ->with('success', 'Teks bacaan baru berhasil dibuat.');
    }

    /**
     * Menampilkan detail satu teks bacaan beserta soal-soal terkait.
     */
    public function show(ReadingPassage $manajemen_reading) // Gunakan Route Model Binding
    {
        // Load relasi ke soal-soal yang menggunakan passage ini
        $manajemen_reading->load('questions');
        return view('admin.manajemen-reading.show', compact('manajemen_reading'));
    }

    /**
     * Menampilkan formulir untuk mengedit teks bacaan.
     */
    public function edit(ReadingPassage $manajemen_reading) // Gunakan Route Model Binding
    {
        $testPackages = TestPackage::orderBy('title')->get();
        return view('admin.manajemen-reading.edit', compact('manajemen_reading', 'testPackages'));
    }

    /**
     * Mengupdate data teks bacaan di database.
     */
    public function update(Request $request, ReadingPassage $manajemen_reading) // Gunakan Route Model Binding
    {
        // Validasi input
        $validatedData = $request->validate([
            'test_package_id' => 'required|exists:test_packages,id',
            'title' => 'required|string|max:255',
            'passage_text' => 'required|string',
        ]);

        // Update data di database
        $manajemen_reading->update($validatedData);

        return redirect()->route('manajemen-reading.index')
            ->with('success', 'Teks bacaan berhasil diperbarui.');
    }

    /**
     * Menghapus teks bacaan dari database.
     */
    public function destroy(ReadingPassage $manajemen_reading) // Gunakan Route Model Binding
    {
        // Hapus data
        // Karena di migrasi onDelete('set null'), soal-soal tidak akan terhapus,
        // hanya foreign key-nya yang akan menjadi NULL. Ini aman.
        $manajemen_reading->delete();

        return redirect()->route('manajemen-reading.index')
            ->with('success', 'Teks bacaan berhasil dihapus.');
    }
}
