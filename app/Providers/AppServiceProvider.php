<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\MenuNavController;

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
        // $helper = new HelperController();

        // View::share('G_theme', $helper->getCookie('theme'));

        Paginator::defaultView('vendor.pagination.bootstrap-5-perpage');
    }
}
