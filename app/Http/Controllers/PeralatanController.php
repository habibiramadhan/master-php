<?php
// app/Http/Controllers/PeralatanController.php
namespace App\Http\Controllers;

use App\Models\Peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PeralatanController extends Controller
{
    public function index()
    {
        $peralatan = Peralatan::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.peralatan.index', compact('peralatan'));
    }

    public function create()
    {
        $kategori = Peralatan::KATEGORI;
        return view('admin.peralatan.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kategori' => 'required|in:' . implode(',', Peralatan::KATEGORI),
            'deskripsi' => 'nullable|string',
            'harga_per_hari' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:tersedia,perawatan,disewa'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('peralatan', 'public');
        }

        Peralatan::create($validated);

        return redirect()->route('admin.peralatan.index')
                        ->with('success', 'Peralatan berhasil ditambahkan.');
    }

    public function show(Peralatan $peralatan)
    {
        return view('admin.peralatan.show', compact('peralatan'));
    }

    public function edit(Peralatan $peralatan)
    {
        $kategori = Peralatan::KATEGORI;
        return view('admin.peralatan.edit', compact('peralatan', 'kategori'));
    }

    public function update(Request $request, Peralatan $peralatan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kategori' => 'required|in:' . implode(',', Peralatan::KATEGORI),
            'deskripsi' => 'nullable|string',
            'harga_per_hari' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:tersedia,perawatan,disewa'
        ]);

        if ($request->hasFile('gambar')) {
            if ($peralatan->gambar) {
                Storage::disk('public')->delete($peralatan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('peralatan', 'public');
        }

        $peralatan->update($validated);

        return redirect()->route('admin.peralatan.index')
                        ->with('success', 'Peralatan berhasil diperbarui.');
    }

    public function destroy(Peralatan $peralatan)
    {
        if ($peralatan->gambar) {
            Storage::disk('public')->delete($peralatan->gambar);
        }

        $peralatan->delete();

        return redirect()->route('admin.peralatan.index')
                        ->with('success', 'Peralatan berhasil dihapus.');
    }
}