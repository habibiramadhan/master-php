<?php
// app/Models/Pengaturan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';

    protected $fillable = [
        'kunci',
        'nilai',
        'tipe'
    ];

    // Cache pengaturan untuk performa yang lebih baik
    public static function ambil($kunci, $default = null)
    {
        return Cache::remember("pengaturan.$kunci", 3600, function () use ($kunci, $default) {
            $pengaturan = self::where('kunci', $kunci)->first();
            return $pengaturan ? $pengaturan->nilai : $default;
        });
    }

    public static function atur($kunci, $nilai, $tipe = 'text')
    {
        $pengaturan = self::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => $nilai, 'tipe' => $tipe]
        );

        // Hapus cache
        Cache::forget("pengaturan.$kunci");
        
        return $pengaturan;
    }

    public static function ambilSemua()
    {
        return Cache::remember('pengaturan.semua', 3600, function () {
            return self::pluck('nilai', 'kunci')->toArray();
        });
    }

    // Kelompokkan pengaturan berdasarkan prefix
    public static function ambilKelompok($prefix)
    {
        return Cache::remember("pengaturan.kelompok.$prefix", 3600, function () use ($prefix) {
            return self::where('kunci', 'like', $prefix . '%')
                      ->pluck('nilai', 'kunci')
                      ->toArray();
        });
    }

    // Hapus semua cache pengaturan
    public static function hapusCache()
    {
        $kunci = self::pluck('kunci');
        foreach ($kunci as $key) {
            Cache::forget("pengaturan.$key");
        }
        Cache::forget('pengaturan.semua');
    }

    // Helper methods untuk pengaturan khusus
    public static function namaPerusahaan()
    {
        return self::ambil('nama_perusahaan', 'CV Sewa Alat Berat');
    }

    public static function emailPerusahaan()
    {
        return self::ambil('email_perusahaan', 'info@example.com');
    }

    public static function teleponPerusahaan()
    {
        return self::ambil('telepon_perusahaan', '08123456789');
    }

    public static function alamatPerusahaan()
    {
        return self::ambil('alamat_perusahaan', 'Alamat belum diatur');
    }

    public static function infoPembayaran()
    {
        return [
            'nama_bank' => self::ambil('nama_bank', 'Bank BCA'),
            'nomor_rekening' => self::ambil('nomor_rekening', '1234567890'),
            'nama_rekening' => self::ambil('nama_rekening', 'CV Sewa Alat Berat'),
        ];
    }

    public static function ketentuanSewa()
    {
        return [
            'minimum_hari_sewa' => (int) self::ambil('minimum_hari_sewa', 1),
            'persentase_dp' => (int) self::ambil('persentase_dp', 20),
            'biaya_antar' => (int) self::ambil('biaya_antar', 100000),
            'biaya_jemput' => (int) self::ambil('biaya_jemput', 100000),
        ];
    }

    // Boot method untuk hapus cache saat model events
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget("pengaturan.{$model->kunci}");
            Cache::forget('pengaturan.semua');
        });

        static::deleted(function ($model) {
            Cache::forget("pengaturan.{$model->kunci}");
            Cache::forget('pengaturan.semua');
        });
    }
}