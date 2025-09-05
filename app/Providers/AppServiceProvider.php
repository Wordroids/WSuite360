<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\Traits\HasEmployeeProfile;
use Illuminate\Support\Facades\Log;

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
        Schema::defaultStringLength(191);

        $traitsUsed = class_uses_recursive(User::class);

        if (true && !in_array(HasEmployeeProfile::class, $traitsUsed)) {

            Log::warning('HasEmployeeProfile trait is not used in User model');
        }
    }
}
