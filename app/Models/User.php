<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    // Relationships
    public function pesananDiverifikasi()
    {
        return $this->hasMany(Pesanan::class, 'diverifikasi_oleh');
    }

    // Scopes
    public function scopeAdmin($query)
    {
        return $query->where('is_admin', true);
    }

    // Methods
    public function adalahAdmin()
    {
        return $this->is_admin;
    }

    public function jumlahPesananDiverifikasi()
    {
        return $this->pesananDiverifikasi()->count();
    }

    public function pesananDiverifikasiHariIni()
    {
        return $this->pesananDiverifikasi()
                    ->whereDate('waktu_verifikasi', today())
                    ->count();
    }
}