<?php
// app/Http/Controllers/Admin/PengaturanController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::getByGroup();
        
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'pengaturan' => 'required|array',
            'pengaturan.*' => 'nullable|string|max:1000'
        ]);

        foreach ($request->pengaturan as $key => $value) {
            $existing = Pengaturan::where('kunci', $key)->first();
            $type = $existing ? $existing->tipe : 'text';
            
            Pengaturan::set($key, $value, $type);
        }

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }
}