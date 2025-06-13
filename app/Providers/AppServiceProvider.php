<?php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        // Share pengaturan data to all public views
        View::composer('public.*', function ($view) {
            try {
                // Ambil langsung dari database table pengaturan
                $pengaturanData = DB::table('pengaturan')->pluck('nilai', 'kunci')->toArray();
                
                // Hanya gunakan data dari database jika ada
                $pengaturan = $pengaturanData;
                
            } catch (\Exception $e) {
                // Jika terjadi error, gunakan array kosong
                $pengaturan = [];
            }
            
            // Debug
            \Log::info('View Composer called for: ' . $view->getName());
            \Log::info('Pengaturan from DB:', $pengaturan);
            
            $view->with('pengaturan', $pengaturan);
        });
    }
}