<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tambahin default string length biar aman sama MySQL lama
        Schema::defaultStringLength(191);

        // Cek dulu apakah tabel pengaturans sudah ada
        if (Schema::hasTable('pengaturans')) {
            try {
                $pengaturan = DB::table('pengaturans')->first();

                // Bagikan ke semua view biar bisa dipakai di blade
                view()->share('pengaturan', $pengaturan);
            } catch (\Exception $e) {
                // Kalau ada error query, jangan bikin aplikasi crash
            }
        }
    }
}
