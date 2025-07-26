<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // 1. Tambahkan use Gate
use App\Models\User; // 2. Tambahkan use User
use Illuminate\Pagination\Paginator; // 3. Tambahkan use Paginator

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
        // 3. Tambahkan Gate di sini
        Gate::define('admin', function (User $user) {
            return $user->role === 'Admin';
        });

        // pagination
        Paginator::useBootstrapFive();
    }
}
