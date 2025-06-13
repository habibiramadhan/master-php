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

        User::create([
            'name' => 'Manager Operasional',
            'email' => 'manager@sewaalatberat.com',
            'password' => Hash::make('manager123'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Staff Admin',
            'email' => 'staff@sewaalatberat.com',
            'password' => Hash::make('staff123'),
            'email_verified_at' => now(),
            'is_admin' => false,
        ]);
    }
}