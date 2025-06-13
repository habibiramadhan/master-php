<?php
// app/Http/Controllers/PublicController.php
namespace App\Http\Controllers;

use App\Models\Peralatan;
use App\Models\Pesanan;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

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

    public function peralatan()
    {
        $peralatan = Peralatan::where('status', 'tersedia')->paginate(12);
        $kategori = Peralatan::KATEGORI;
        
        return view('public.peralatan.index', compact('peralatan', 'kategori'));
    }

    public function detailPeralatan($id)
    {
        $peralatan = Peralatan::findOrFail($id);
        
        return view('public.peralatan.detail', compact('peralatan'));
    }

    public function booking()
    {
        $peralatan = Peralatan::where('status', 'tersedia')->get();
        
        return view('public.booking.form', compact('peralatan'));
    }

    public function storeBooking(Request $request)
    {
        // Logic untuk menyimpan booking
    }

    public function payment()
    {
        return view('public.payment.form');
    }

    public function uploadPayment(Request $request)
    {
        // Logic untuk upload bukti bayar
    }

    public function track()
    {
        return view('public.track.form');
    }

    public function checkTrack(Request $request)
    {
        // Logic untuk cek tracking
    }

    public function receipt($tracking_id)
    {
        // Logic untuk generate PDF receipt
    }
}