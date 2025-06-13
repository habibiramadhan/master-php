<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Peralatan;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_peralatan' => Peralatan::count(),
            'total_pesanan' => Pesanan::count(),
            'pesanan_menunggu' => Pesanan::where('status', 'menunggu_pembayaran')->count(),
            'pesanan_verifikasi' => Pesanan::where('status', 'bukti_bayar_diupload')->count(),
            'pesanan_aktif' => Pesanan::whereIn('status', ['terverifikasi', 'sedang_disewa'])->count(),
            'pendapatan_bulan_ini' => Pesanan::whereIn('status', ['terverifikasi', 'sedang_disewa', 'selesai'])
                ->whereMonth('created_at', now()->month)
                ->sum('total_harga'),
        ];

        $peralatan_tersedia = Peralatan::where('status', 'tersedia')->count();
        $peralatan_disewa = Peralatan::where('status', 'disewa')->count();
        $peralatan_perawatan = Peralatan::where('status', 'perawatan')->count();

        return view('admin.dashboard', compact('stats', 'peralatan_tersedia', 'peralatan_disewa', 'peralatan_perawatan'));
    }

    public function verifikasiPembayaran()
    {
        $stats = [
            'peralatan_tersedia' => Peralatan::where('status', 'tersedia')->count(),
            'peralatan_disewa' => Peralatan::where('status', 'disewa')->count(),
            'peralatan_perawatan' => Peralatan::where('status', 'perawatan')->count(),
        ];

        $pesanan = Pesanan::with('peralatan')
            ->where('status', 'bukti_bayar_diupload')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.verifikasi', compact('pesanan', 'stats'));
    }

    public function verifikasiApprove(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        $pesanan->update([
            'status' => 'terverifikasi',
            'catatan_admin' => $request->catatan_admin,
            'tanggal_verifikasi' => now()
        ]);

        $pesanan->peralatan->update(['status' => 'disewa']);

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi');
    }

    public function verifikasiReject(Request $request, $id)
    {
        $validated = $request->validate([
            'catatan_admin' => 'required|string|max:500'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        
        $pesanan->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_admin']
        ]);

        return redirect()->back()->with('success', 'Pembayaran ditolak');
    }
}