<?php
// database/seeders/PengaturanSeeder.php
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
            ['kunci' => 'nama_rekening', 'nilai' => 'CV Sewa Alat Berat', 'tipe' => 'text'],
            
            // Ketentuan Sewa
            ['kunci' => 'minimum_hari_sewa', 'nilai' => '1', 'tipe' => 'number'],
            ['kunci' => 'persentase_dp', 'nilai' => '20', 'tipe' => 'number'],
            ['kunci' => 'biaya_antar', 'nilai' => '100000', 'tipe' => 'number'],
            ['kunci' => 'biaya_jemput', 'nilai' => '100000', 'tipe' => 'number'],
            
            // Jam Operasional
            ['kunci' => 'jam_operasional', 'nilai' => 'Senin - Jumat: 08:00 - 17:00\nSabtu: 08:00 - 12:00', 'tipe' => 'textarea'],
            ['kunci' => 'kontak_darurat', 'nilai' => '08123456789', 'tipe' => 'text'],
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