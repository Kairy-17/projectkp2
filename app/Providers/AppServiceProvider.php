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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $deadline_notifications = \App\Models\Project::where('target_selesai', '<=', now()->addDays(3))
                                        ->where('status_project', '!=', 'Done')
                                        ->whereNotNull('target_selesai')
                                        ->orderBy('target_selesai', 'asc')
                                        ->get();
            $view->with('deadline_notifications', $deadline_notifications);
        });
    }
}
