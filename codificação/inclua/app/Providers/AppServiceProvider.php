<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('ambiente')==="remoto") {
            URL::forceScheme('https');
        }

        Blade::directive('money', function ($amount) {
            return "<?php echo 'R$ ' . number_format($amount, 2,',', '.'); ?>";
        });

        Blade::directive('dataformatada', function ($timestamp) {
            return "<?php echo   date('d/m/Y H:i:s', strtotime($timestamp)); ?>";
        });

        /*if (app()->environment('remote')) {

        }*/
    }
}
