<?php
// app/Http/Controllers/PengaturanController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = DB::table('pengaturan')->pluck('nilai', 'kunci');
        
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'email_perusahaan' => 'required|email|max:255',
            'telepon_perusahaan' => 'required|string|max:20',
            'whatsapp_perusahaan' => 'required|string|max:20',
            'alamat_perusahaan' => 'required|string',
            'tentang_kami' => 'required|string',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'area_layanan' => 'required|string',
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:50',
            'nama_rekening' => 'required|string|max:255',
            'logo_perusahaan' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['_token', '_method', 'logo_perusahaan']);

        if ($request->hasFile('logo_perusahaan')) {
            $oldLogo = DB::table('pengaturan')->where('kunci', 'logo_perusahaan')->value('nilai');
            
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            $logoPath = $request->file('logo_perusahaan')->store('logos', 'public');
            $data['logo_perusahaan'] = $logoPath;
        }

        foreach ($data as $kunci => $nilai) {
            DB::table('pengaturan')
                ->where('kunci', $kunci)
                ->update([
                    'nilai' => $nilai,
                    'updated_at' => now()
                ]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function deleteLogo()
    {
        $logo = DB::table('pengaturan')->where('kunci', 'logo_perusahaan')->value('nilai');
        
        if ($logo && Storage::disk('public')->exists($logo)) {
            Storage::disk('public')->delete($logo);
            
            DB::table('pengaturan')
                ->where('kunci', 'logo_perusahaan')
                ->update([
                    'nilai' => null,
                    'updated_at' => now()
                ]);
        }

        return response()->json(['success' => true]);
    }
}