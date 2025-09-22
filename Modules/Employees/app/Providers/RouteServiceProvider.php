<?php

namespace Modules\Employees\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Employees';

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapTenantRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapTenantRoutes(): void
    {
        Route::middleware([
            'web',
            InitializeTenancyByDomain::class,
            PreventAccessFromCentralDomains::class
        ])->group(module_path(
            $this->name,
            '/routes/tenant.php'
        ));
    }
}
