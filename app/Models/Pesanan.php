<?php
// app/Models/Pesanan.php
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'kode_pesanan',
        'kode_tracking',
        'nama_pelanggan',
        'email_pelanggan',
        'telepon_pelanggan',
        'alamat_pelanggan',
        'peralatan_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_hari',
        'harga_per_hari',
        'total_harga',
        'bukti_bayar',
        'waktu_upload_bayar',
        'waktu_verifikasi',
        'diverifikasi_oleh',
        'status',
        'catatan',
        'catatan_admin'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'harga_per_hari' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'waktu_upload_bayar' => 'datetime',
        'waktu_verifikasi' => 'datetime',
    ];

    // Constants untuk status
    const STATUS_MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';
    const STATUS_BUKTI_BAYAR_DIUPLOAD = 'bukti_bayar_diupload';
    const STATUS_TERVERIFIKASI = 'terverifikasi';
    const STATUS_SEDANG_DISEWA = 'sedang_disewa';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

    // Boot method untuk generate kode
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode_pesanan)) {
                $model->kode_pesanan = self::generateKodePesanan();
            }
        });
    }

    // Relationships
    public function peralatan()
    {
        return $this->belongsTo(Peralatan::class, 'peralatan_id');
    }

    public function diverifikasiOleh()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    // Accessors
    public function getTotalHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getHargaPerHariFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga_per_hari, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            self::STATUS_MENUNGGU_PEMBAYARAN => '<span class="badge bg-warning">Menunggu Pembayaran</span>',
            self::STATUS_BUKTI_BAYAR_DIUPLOAD => '<span class="badge bg-info">Bukti Bayar Diupload</span>',
            self::STATUS_TERVERIFIKASI => '<span class="badge bg-success">Terverifikasi</span>',
            self::STATUS_SEDANG_DISEWA => '<span class="badge bg-primary">Sedang Disewa</span>',
            self::STATUS_SELESAI => '<span class="badge bg-secondary">Selesai</span>',
            self::STATUS_DIBATALKAN => '<span class="badge bg-danger">Dibatalkan</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge bg-light">Tidak Diketahui</span>';
    }

    public function getUrlBuktiBayarAttribute()
    {
        if ($this->bukti_bayar) {
            return asset('storage/' . $this->bukti_bayar);
        }
        return null;
    }

    public function getNamaStatusAttribute()
    {
        $namaStatus = [
            self::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            self::STATUS_BUKTI_BAYAR_DIUPLOAD => 'Bukti Bayar Diupload',
            self::STATUS_TERVERIFIKASI => 'Terverifikasi',
            self::STATUS_SEDANG_DISEWA => 'Sedang Disewa',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
        ];

        return $namaStatus[$this->status] ?? 'Tidak Diketahui';
    }

    // Scopes
    public function scopeMenungguPembayaran($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU_PEMBAYARAN);
    }

    public function scopeBuktiBayarDiupload($query)
    {
        return $query->where('status', self::STATUS_BUKTI_BAYAR_DIUPLOAD);
    }

    public function scopeTerverifikasi($query)
    {
        return $query->where('status', self::STATUS_TERVERIFIKASI);
    }

    public function scopeSedangDisewa($query)
    {
        return $query->where('status', self::STATUS_SEDANG_DISEWA);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', self::STATUS_SELESAI);
    }

    public function scopeDibatalkan($query)
    {
        return $query->where('status', self::STATUS_DIBATALKAN);
    }

    // Methods
    public static function generateKodePesanan()
    {
        $prefix = 'PSN';
        $tanggal = date('ymd');
        
        // Dapatkan jumlah pesanan hari ini
        $jumlah = self::whereDate('created_at', today())->count() + 1;
        
        return $prefix . '-' . $tanggal . '-' . str_pad($jumlah, 3, '0', STR_PAD_LEFT);
    }

    public function generateKodeTracking()
    {
        $this->kode_tracking = 'TRK-' . strtoupper(Str::random(6));
        $this->save();
        return $this->kode_tracking;
    }

    public function hitungJumlahHari()
    {
        $mulai = Carbon::parse($this->tanggal_mulai);
        $selesai = Carbon::parse($this->tanggal_selesai);
        return $mulai->diffInDays($selesai) + 1; // Termasuk hari mulai
    }

    public function hitungTotalHarga()
    {
        return $this->jumlah_hari * $this->harga_per_hari;
    }

    public function tandaiTerverifikasi($adminId)
    {
        $this->update([
            'status' => self::STATUS_TERVERIFIKASI,
            'waktu_verifikasi' => now(),
            'diverifikasi_oleh' => $adminId,
            'kode_tracking' => $this->kode_tracking ?: $this->generateKodeTracking()
        ]);
    }

    public function bisaDibatalkan()
    {
        return in_array($this->status, [
            self::STATUS_MENUNGGU_PEMBAYARAN,
            self::STATUS_BUKTI_BAYAR_DIUPLOAD,
            self::STATUS_TERVERIFIKASI
        ]);
    }

    public function sedangAktif()
    {
        return in_array($this->status, [
            self::STATUS_TERVERIFIKASI,
            self::STATUS_SEDANG_DISEWA
        ]);
    }

    public function sudahSelesai()
    {
        return $this->status === self::STATUS_SELESAI;
    }

    public function sudahDibatalkan()
    {
        return $this->status === self::STATUS_DIBATALKAN;
    }

    public function perluVerifikasi()
    {
        return $this->status === self::STATUS_BUKTI_BAYAR_DIUPLOAD;
    }
}

