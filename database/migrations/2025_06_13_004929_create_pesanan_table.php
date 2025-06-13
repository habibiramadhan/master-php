<?php
// database/migrations/2025_06_13_004929_create_pesanan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pesanan', 20)->unique();
            $table->string('kode_tracking', 20)->nullable()->unique();
            
            // Info Pelanggan
            $table->string('nama_pelanggan', 100);
            $table->string('email_pelanggan', 100);
            $table->string('telepon_pelanggan', 20);
            $table->text('alamat_pelanggan');
            
            // Info Alat & Sewa
            $table->foreignId('peralatan_id')->constrained('peralatan')->onDelete('cascade');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('jumlah_hari');
            $table->decimal('harga_per_hari', 12, 2);
            $table->decimal('total_harga', 15, 2);
            
            // Info Pembayaran
            $table->string('bukti_bayar', 255)->nullable();
            $table->timestamp('waktu_upload_bayar')->nullable();
            $table->timestamp('waktu_verifikasi')->nullable();
            $table->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->onDelete('set null');
            
            // Status & Catatan
            $table->enum('status', [
                'menunggu_pembayaran', 
                'bukti_bayar_diupload', 
                'terverifikasi', 
                'sedang_disewa', 
                'selesai',
                'dibatalkan'
            ])->default('menunggu_pembayaran');
            $table->text('catatan')->nullable();
            $table->text('catatan_admin')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'created_at']);
            $table->index('kode_tracking');
            $table->index('kode_pesanan');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
};