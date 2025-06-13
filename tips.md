TIPS

php artisan breeze:install
composer require laravel/breeze --dev
php artisan storage:link
composer require barryvdh/laravel-dompdf

# Buat migration file
php artisan make:migration create_peralatan_table
php artisan make:migration create_pesanan_table
php artisan make:migration create_pengaturan_table
php artisan make:migration add_admin_role_to_users_table

# Jalankan migration
php artisan migrate

# Rollback migration (jika perlu)
php artisan migrate:rollback

# Reset semua migration
php artisan migrate:reset

# Fresh migration (drop semua table lalu migrate ulang)
php artisan migrate:fresh

# Buat model saja
php artisan make:model Peralatan
php artisan make:model Pesanan
php artisan make:model Pengaturan

# Buat seeder
php artisan make:seeder PengaturanSeeder
php artisan make:seeder PeralatanSeeder

https://github.com/habibiramadhan/master-php/archive/refs/heads/main.zip