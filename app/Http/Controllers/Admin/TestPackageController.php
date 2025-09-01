<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TestPackage;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all test packages
        $testPackages = TestPackage::latest()->paginate(10);
        return view('admin.test-package.index', compact('testPackages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.test-package.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $ValidasiTest = $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'duration_minutes' => 'required|integer|min:1',
                'passing_score' => 'required|integer|min:0',
            ],
            [
                'title.required' => 'Nama paket tes harus diisi.',
                'title.string' => 'Nama paket tes harus berupa teks.',
                'title.max' => 'Nama paket tes tidak boleh lebih dari 255 karakter.',
                'description.string' => 'Deskripsi harus berupa teks.',
                'duration_minutes.required' => 'Durasi harus diisi.',
                'duration_minutes.integer' => 'Durasi harus berupa angka.',
                'duration_minutes.min' => 'Durasi minimal adalah 1 menit.',
                'passing_score.required' => 'Skor kelulusan harus diisi.',
                'passing_score.integer' => 'Skor kelulusan harus berupa angka.',
                'passing_score.min' => 'Skor kelulusan minimal adalah 0.',
            ]
        );

        TestPackage::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration_minutes' => $request->duration_minutes,
            'passing_score' => $request->passing_score,
            'created_by' => Auth::user()->id, // atau isi sesuai user yang login
        ]);

        return redirect()->route('test-packages.index')->with('success', 'Test package created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testPackage = TestPackage::findOrFail($id);
        return view('admin.test-package.show', compact('testPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $testPackage = TestPackage::findOrFail($id);
        return view('admin.test-package.edit', compact('testPackage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ValidasiTest = $request->validate(
            [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'duration_minutes' => 'required|integer|min:1',
                'passing_score' => 'required|integer|min:0',
            ],
            [
                'title.required' => 'Nama paket tes harus diisi.',
                'title.string' => 'Nama paket tes harus berupa teks.',
                'title.max' => 'Nama paket tes tidak boleh lebih dari 255 karakter.',
                'description.string' => 'Deskripsi harus berupa teks.',
                'duration_minutes.required' => 'Durasi harus diisi.',
                'duration_minutes.integer' => 'Durasi harus berupa angka.',
                'duration_minutes.min' => 'Durasi minimal adalah 1 menit.',
                'passing_score.required' => 'Skor kelulusan harus diisi.',
                'passing_score.integer' => 'Skor kelulusan harus berupa angka.',
                'passing_score.min' => 'Skor kelulusan minimal adalah 0.',
            ]
        );

        $testPackage = TestPackage::findOrFail($id);
        $testPackage->update($request->all());

        return redirect()->route('test-packages.index')->with('success', 'Test package updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testPackage = TestPackage::findOrFail($id);
        $testPackage->delete();

        return redirect()->route('test-packages.index')->with('success', 'Test package deleted successfully.');
    }
}
