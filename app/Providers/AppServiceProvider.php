<?php

namespace App\Providers;

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
        // Custom Blade directive to safely output old input values
        \Blade::directive('safeOld', function ($expression) {
            return "<?php echo e(is_array(old($expression)) ? '' : old($expression)); ?>";
        });
    }
}
