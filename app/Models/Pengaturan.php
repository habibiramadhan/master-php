<?php
// app/Models/Pengaturan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $fillable = ['kunci', 'nilai', 'tipe'];

    public static function get($kunci, $default = null)
    {
        return Cache::remember("pengaturan_{$kunci}", 3600, function () use ($kunci, $default) {
            return static::where('kunci', $kunci)->value('nilai') ?? $default;
        });
    }

    public static function set($kunci, $nilai, $tipe = 'text')
    {
        static::updateOrCreate(
            ['kunci' => $kunci],
            ['nilai' => $nilai, 'tipe' => $tipe]
        );
        
        Cache::forget("pengaturan_{$kunci}");
        return true;
    }

    public static function getAll()
    {
        return Cache::remember('pengaturan_all', 3600, function () {
            return static::pluck('nilai', 'kunci');
        });
    }

    public static function forget($kunci = null)
    {
        if ($kunci) {
            Cache::forget("pengaturan_{$kunci}");
        } else {
            Cache::forget('pengaturan_all');
        }
    }

    public static function getNamaPerusahaan()
    {
        return static::get('nama_perusahaan', 'CV Sewa Alat Berat');
    }

    public static function getInfoPembayaran()
    {
        return [
            'nama_bank' => static::get('nama_bank', 'Bank BCA'),
            'nomor_rekening' => static::get('nomor_rekening', '1234567890'),
            'nama_rekening' => static::get('nama_rekening', 'CV Sewa Alat Berat'),
        ];
    }

    public static function getInfoKontak()
    {
        return [
            'telepon' => static::get('telepon_perusahaan', '08123456789'),
            'whatsapp' => static::get('whatsapp_perusahaan', '628123456789'),
            'email' => static::get('email_perusahaan', 'info@sewaalatberat.com'),
            'alamat' => static::get('alamat_perusahaan', 'Jakarta'),
        ];
    }

    public static function getSosialMedia()
    {
        return [
            'facebook' => static::get('facebook'),
            'instagram' => static::get('instagram'),
        ];
    }

    public static function getLogo()
    {
        $logo = static::get('logo_perusahaan');
        return $logo ? asset('storage/' . $logo) : null;
    }
}