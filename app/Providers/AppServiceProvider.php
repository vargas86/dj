<?php

namespace App\Providers;

use App\Models\Notification;
use Doctrine\DBAL\Schema\Schema;
use Exception;
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
        // Get Master topics
        $masterTopics = [];
        try {
            
            $masterTopics = \App\Models\Topic::where('topic_id', null)->where('disabled', false)->get();
        } catch (Exception $e) {
        }
        //
        view()->composer('*', function ($view) use ($masterTopics) {
            $view->with([
                'masterTopics' => $masterTopics
            ]);
        });
    }
}
