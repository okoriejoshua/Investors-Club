<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Blade;

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
         
        Blade::directive('monify', function ($amount) {
            return "<?php echo str_replace('.00', '', number_format($amount, 2, '.', ',')); ?>";
        });
    }
}
