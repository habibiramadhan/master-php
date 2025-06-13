<?php
// database/migrations/2025_06_13_004925_create_peralatan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('peralatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->enum('kategori', [
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
            ]);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_per_hari', 12, 2);
            $table->string('gambar', 255)->nullable();
            $table->enum('status', ['tersedia', 'perawatan', 'disewa'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peralatan');
    }
};
