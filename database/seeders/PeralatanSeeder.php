<?php
// database/seeders/PeralatanSeeder.php
namespace Database\Seeders;

use App\Models\Peralatan;
use Illuminate\Database\Seeder;

class PeralatanSeeder extends Seeder
{
    public function run(): void
    {
        $peralatan = [
            [
                'nama' => 'Excavator Komatsu PC200',
                'kategori' => 'Excavator',
                'deskripsi' => 'Excavator berkapasitas 20 ton, cocok untuk penggalian dan konstruksi berat. Dilengkapi dengan bucket standar dan breaker.',
                'harga_per_hari' => 2500000,
                'status' => 'tersedia'
            ],
            [
                'nama' => 'Bulldozer Caterpillar D6T',
                'kategori' => 'Bulldozer',
                'deskripsi' => 'Bulldozer untuk perataan tanah dan pembersihan lahan. Engine 250 HP dengan blade capacity tinggi.',
                'harga_per_hari' => 3000000,
                'status' => 'tersedia'
            ]
        ];

        foreach ($peralatan as $item) {
            Peralatan::create($item);
        }
    }
}