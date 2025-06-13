<?php
// app/Models/Peralatan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Peralatan extends Model
{
    use HasFactory;

    protected $table = 'peralatan';

    protected $fillable = [
        'nama',
        'kategori',
        'deskripsi',
        'harga_per_hari',
        'gambar',
        'status'
    ];

    protected $casts = [
        'harga_per_hari' => 'decimal:2',
    ];

    // Constants untuk kategori
    const KATEGORI = [
        'Excavator',
        'Bulldozer',
        'Crane',
        'Forklift',
        'Molen',
        'Compactor',
        'Generator',
        'Dump Truck',
        'Wheel Loader',
        'Motor Grader'
    ];

    // Constants untuk status
    const STATUS_TERSEDIA = 'tersedia';
    const STATUS_PERAWATAN = 'perawatan';
    const STATUS_DISEWA = 'disewa';

    // Relationships
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'peralatan_id');
    }

    public function pesananAktif()
    {
        return $this->hasMany(Pesanan::class, 'peralatan_id')
                    ->whereIn('status', ['terverifikasi', 'sedang_disewa']);
    }

    // Accessors
    public function getUrlGambarAttribute()
    {
        if ($this->gambar) {
            return Storage::url($this->gambar);
        }
        return asset('images/no-image.png'); // Default image
    }

    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga_per_hari, 0, ',', '.');
    }

    // Scopes
    public function scopeTersedia($query)
    {
        return $query->where('status', self::STATUS_TERSEDIA);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Methods
    public function apakahTersedia($tanggalMulai, $tanggalSelesai)
    {
        if ($this->status !== self::STATUS_TERSEDIA) {
            return false;
        }

        // Cek apakah ada pesanan yang bentrok
        $pesananBentrok = $this->pesanan()
            ->whereIn('status', ['terverifikasi', 'sedang_disewa'])
            ->where(function ($query) use ($tanggalMulai, $tanggalSelesai) {
                $query->whereBetween('tanggal_mulai', [$tanggalMulai, $tanggalSelesai])
                      ->orWhereBetween('tanggal_selesai', [$tanggalMulai, $tanggalSelesai])
                      ->orWhere(function ($q) use ($tanggalMulai, $tanggalSelesai) {
                          $q->where('tanggal_mulai', '<=', $tanggalMulai)
                            ->where('tanggal_selesai', '>=', $tanggalSelesai);
                      });
            })
            ->exists();

        return !$pesananBentrok;
    }

    public function sedangDisewa()
    {
        return $this->status === self::STATUS_DISEWA;
    }

    public function butuhPerawatan()
    {
        return $this->status === self::STATUS_PERAWATAN;
    }
}