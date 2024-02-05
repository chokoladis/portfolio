<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\MenuNavController;
use App\Http\Controllers\HelperController;
use App\Models\MenuNav;

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
        $menuNav = new MenuNav();
        // $helper = new HelperController();

        View::share('G_menuNav', $menuNav->getActive());
        // View::share('G_theme', $helper->getCookie('theme'));

        Paginator::defaultView('vendor.pagination.bootstrap-5');
    }
}
