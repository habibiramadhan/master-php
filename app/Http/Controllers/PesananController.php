<?php
// app/Http/Controllers/PesananController.php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Peralatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with('peralatan')->orderBy('created_at', 'desc');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_pesanan', 'like', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('kode_tracking', 'like', "%{$search}%");
            });
        }
        
        $pesanan = $query->paginate(10);
        
        return view('admin.pesanan.index', compact('pesanan'));
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load('peralatan', 'diverifikasiOleh');
        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function edit(Pesanan $pesanan)
    {
        return view('admin.pesanan.edit', compact('pesanan'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu_pembayaran,bukti_bayar_diupload,terverifikasi,sedang_disewa,selesai,dibatalkan',
            'catatan_admin' => 'nullable|string'
        ]);

        $pesanan->update($validated);

        return redirect()->route('admin.pesanan.index')
                        ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu_pembayaran,bukti_bayar_diupload,terverifikasi,sedang_disewa,selesai,dibatalkan'
        ]);

        $pesanan->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui'
        ]);
    }

    public function destroy(Pesanan $pesanan)
    {
        if ($pesanan->bukti_bayar) {
            Storage::disk('public')->delete($pesanan->bukti_bayar);
        }

        $pesanan->delete();

        return redirect()->route('admin.pesanan.index')
                        ->with('success', 'Pesanan berhasil dihapus.');
    }
}