<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'articles' => 'App\Article',
            'news' => 'App\News',
            'events' => 'App\Event',
            'courses' => 'App\Course',
        ]);

        // $obj = class or object
        Blade::directive('editable', function ($obj) {
            return "data-editable='true' data-namespace='{{relatedNamespaceOf($obj)}}' data-id='{{{$obj}->id}}'";
        });
    }


    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        //
    }
}
