<?php

namespace App\Providers;

use App\Content;
use App\Event;
use App\News;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot ()
    {
        Relation::morphMap([
            'articles' => 'App\Article',
            'news'     => 'App\News',
            'events'   => 'App\Event',
            'courses'  => 'App\Course',
        ]);
    }


    /**
     * Register any application services.
     * @return void
     */
    public function register ()
    {
        //
    }
}
