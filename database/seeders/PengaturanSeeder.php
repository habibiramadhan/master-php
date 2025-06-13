<?php
// database/seeders/PengaturanSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengaturanSeeder extends Seeder
{
    public function run()
    {
        $pengaturan = [
            // Info Perusahaan
            ['kunci' => 'nama_perusahaan', 'nilai' => 'CV Sewa Alat Berat', 'tipe' => 'text'],
            ['kunci' => 'email_perusahaan', 'nilai' => 'info@sewaalatberat.com', 'tipe' => 'email'],
            ['kunci' => 'telepon_perusahaan', 'nilai' => '08123456789', 'tipe' => 'text'],
            ['kunci' => 'whatsapp_perusahaan', 'nilai' => '628123456789', 'tipe' => 'text'],
            ['kunci' => 'alamat_perusahaan', 'nilai' => 'Jl. Industri No. 123, Jakarta', 'tipe' => 'textarea'],
            ['kunci' => 'logo_perusahaan', 'nilai' => null, 'tipe' => 'image'],
            
            // Konten Footer
            ['kunci' => 'tentang_kami', 'nilai' => 'Penyedia layanan sewa alat berat terpercaya dengan pengalaman lebih dari 10 tahun.', 'tipe' => 'textarea'],
            ['kunci' => 'facebook', 'nilai' => 'https://facebook.com/sewaalatberat', 'tipe' => 'url'],
            ['kunci' => 'instagram', 'nilai' => 'https://instagram.com/sewaalatberat', 'tipe' => 'url'],
            ['kunci' => 'area_layanan', 'nilai' => 'Jakarta, Bogor, Depok, Tangerang, Bekasi', 'tipe' => 'text'],
            
            // Info Pembayaran
            ['kunci' => 'nama_bank', 'nilai' => 'Bank BCA', 'tipe' => 'text'],
            ['kunci' => 'nomor_rekening', 'nilai' => '1234567890', 'tipe' => 'text'],
            ['kunci' => 'nama_rekening', 'nilai' => 'CV Sewa Alat Berat', 'tipe' => 'text']
        ];

        foreach ($pengaturan as $setting) {
            DB::table('pengaturan')->insert([
                'kunci' => $setting['kunci'],
                'nilai' => $setting['nilai'],
                'tipe' => $setting['tipe'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}