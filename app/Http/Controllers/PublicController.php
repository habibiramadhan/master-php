<?php
// app/Http/Controllers/PublicController.php
namespace App\Http\Controllers;

use App\Models\Peralatan;
use App\Models\Pesanan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicController extends Controller
{
    public function index()
    {
        $peralatan = Peralatan::where('status', 'tersedia')
                              ->latest()
                              ->take(6)
                              ->get();
                              
        $pengaturan = Pengaturan::getAll();
        
        return view('public.welcome', compact('peralatan', 'pengaturan'));
    }

    public function peralatan(Request $request)
    {
        $query = Peralatan::where('status', 'tersedia');
        
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        
        switch ($request->sort) {
            case 'nama':
                $query->orderBy('nama', 'asc');
                break;
            case 'harga_rendah':
                $query->orderBy('harga_per_hari', 'asc');
                break;
            case 'harga_tinggi':
                $query->orderBy('harga_per_hari', 'desc');
                break;
            default:
                $query->latest();
                break;
        }
        
        $peralatan = $query->paginate(12);
        $kategori = Peralatan::KATEGORI;
        $pengaturan = Pengaturan::getAll();
        
        return view('public.peralatan.index', compact('peralatan', 'kategori', 'pengaturan'));
    }

    public function detailPeralatan($id)
    {
        $peralatan = Peralatan::findOrFail($id);
        $pengaturan = Pengaturan::getAll();
        
        $peralatanSejenis = Peralatan::where('status', 'tersedia')
                                   ->where('kategori', $peralatan->kategori)
                                   ->where('id', '!=', $peralatan->id)
                                   ->take(4)
                                   ->get();
        
        return view('public.peralatan.detail', compact('peralatan', 'pengaturan', 'peralatanSejenis'));
    }

    public function booking()
    {
        $peralatan = Peralatan::where('status', 'tersedia')->orderBy('nama')->get();
        $pengaturan = Pengaturan::getAll();
        
        return view('public.booking.form', compact('peralatan', 'pengaturan'));
    }

    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'peralatan_id' => 'required|exists:peralatan,id',
            'nama_pelanggan' => 'required|string|max:255',
            'email_pelanggan' => 'required|email|max:255',
            'telepon_pelanggan' => 'required|string|max:20',
            'alamat_pelanggan' => 'required|string',
            'tanggal_mulai' => 'required|date|after:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'catatan' => 'nullable|string'
        ]);

        $peralatan = Peralatan::findOrFail($validated['peralatan_id']);
        
        $tanggalMulai = Carbon::parse($validated['tanggal_mulai']);
        $tanggalSelesai = Carbon::parse($validated['tanggal_selesai']);
        $jumlahHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;
        $totalHarga = $jumlahHari * $peralatan->harga_per_hari;

        $pesanan = Pesanan::create([
            'peralatan_id' => $peralatan->id,
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'email_pelanggan' => $validated['email_pelanggan'],
            'telepon_pelanggan' => $validated['telepon_pelanggan'],
            'alamat_pelanggan' => $validated['alamat_pelanggan'],
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'jumlah_hari' => $jumlahHari,
            'harga_per_hari' => $peralatan->harga_per_hari,
            'total_harga' => $totalHarga,
            'catatan' => $validated['catatan'],
            'status' => 'menunggu_pembayaran'
        ]);

        return redirect()->route('payment.form')->with([
            'success' => 'Booking berhasil! Silakan lakukan pembayaran.',
            'kode_pesanan' => $pesanan->kode_pesanan,
            'total_harga' => $totalHarga
        ]);
    }

    public function payment()
    {
        $pengaturan = Pengaturan::getAll();
        return view('public.payment.form', compact('pengaturan'));
    }

    public function uploadPayment(Request $request)
    {
        $validated = $request->validate([
            'kode_pesanan' => 'required|string|exists:pesanan,kode_pesanan',
            'jumlah_transfer' => 'required|numeric|min:0',
            'nama_pengirim' => 'required|string|max:255',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $pesanan = Pesanan::where('kode_pesanan', $validated['kode_pesanan'])->first();

        if ($pesanan->status !== 'menunggu_pembayaran') {
            return back()->withErrors(['kode_pesanan' => 'Pesanan ini sudah diproses atau tidak valid.']);
        }

        $buktiPath = $request->file('bukti_bayar')->store('bukti-bayar', 'public');
        $trackingId = 'TRK-' . strtoupper(uniqid());

        $pesanan->update([
            'bukti_bayar' => $buktiPath,
            'kode_tracking' => $trackingId,
            'waktu_upload_bayar' => now(),
            'status' => 'bukti_bayar_diupload',
            'nama_pengirim' => $validated['nama_pengirim'],
            'jumlah_transfer' => $validated['jumlah_transfer']
        ]);

        return redirect()->route('track.form')->with([
            'success' => 'Bukti pembayaran berhasil diupload! Gunakan tracking ID untuk cek status.',
            'tracking_id' => $trackingId,
            'kode_pesanan' => $pesanan->kode_pesanan
        ]);
    }

    public function track()
    {
        $pengaturan = Pengaturan::getAll();
        return view('public.track.form', compact('pengaturan'));
    }

    public function checkTrack(Request $request)
    {
        $validated = $request->validate([
            'search_code' => 'required|string'
        ]);

        $searchCode = trim($validated['search_code']);
        
        $pesanan = Pesanan::with(['peralatan', 'diverifikasiOleh'])
                          ->where(function($query) use ($searchCode) {
                              $query->where('kode_pesanan', $searchCode)
                                    ->orWhere('kode_tracking', $searchCode);
                          })
                          ->first();

        $pengaturan = Pengaturan::getAll();

        if (!$pesanan) {
            return view('public.track.form', [
                'pengaturan' => $pengaturan,
                'error' => 'Kode pesanan atau tracking ID tidak ditemukan.'
            ]);
        }

        return view('public.track.form', compact('pesanan', 'pengaturan'));
    }

    public function receipt($tracking_id)
    {
        $pesanan = Pesanan::with('peralatan')
                          ->where('kode_tracking', $tracking_id)
                          ->whereIn('status', ['terverifikasi', 'sedang_disewa', 'selesai'])
                          ->first();

        if (!$pesanan) {
            abort(404, 'Receipt tidak ditemukan atau pesanan belum terverifikasi.');
        }

        $pengaturan = Pengaturan::getAll();

        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('public.receipt-pdf', compact('pesanan', 'pengaturan'));
        
        // Set paper size (thermal receipt style)
        $pdf->setPaper([0, 0, 226.77, 566.93], 'portrait'); // 80mm x 200mm
        
        $filename = 'Receipt-' . $pesanan->kode_pesanan . '.pdf';
        
        return $pdf->download($filename);
    }
}