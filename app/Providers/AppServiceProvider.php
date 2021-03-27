<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\Place;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravelista\Comments\Comment;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
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
        Relation::morphMap([
            'comments' => Comment::class,
            'events' => Event::class,
            'places' => Place::class,
            'trips' => Trip::class
        ]);
    }
}
