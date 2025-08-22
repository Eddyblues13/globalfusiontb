<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\SettingsCont;
use App\Models\TermsPrivacy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

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


        Paginator::useBootstrap();

        // Sharing settings with all view
        $settings = Setting::where('id', '1')->first();
        $terms =  TermsPrivacy::find(1);
        $moreset =  SettingsCont::find(1);

        View::share('settings', $settings);
        View::share('terms', $terms);
        View::share('moresettings', $moreset);
        View::share('mod', $settings->modules);
    }
}
