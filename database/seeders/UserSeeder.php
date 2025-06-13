<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sewa Alat Berat',
            'email' => 'admin@sewaalatberat.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);
    }
}