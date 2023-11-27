<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\MenuNavController;
use App\Http\Controllers\HelperController;

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
        $menuNav = new MenuNavController();
        $helper = new HelperController();

        // $authUser = auth()->user();
        // $authUserName = $authUser !== null ? $authUser->name : 'noname';

        // View::share('G_authUser', $authUser);
        // View::share('G_authUserName', $authUserName);

        View::share('G_menuNav', $menuNav->getActive());
        // View::share('G_theme', $helper->getCookie('theme'));

        Paginator::defaultView('vendor.pagination.bootstrap-5');
    }
}
