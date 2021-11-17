<?php

namespace App\Services\Chatting\Providers;

use Lang;
use View;
use Illuminate\Support\ServiceProvider;
use App\Services\Chatting\Providers\RouteServiceProvider;
use App\Services\Chatting\Providers\BroadcastServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;

class ChattingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap migrations and factories for:
     * - `php artisan migrate` command.
     * - factory() helper.
     *
     * Previous usage:
     * php artisan migrate --path=src/Services/Chatting/database/migrations
     * Now:
     * php artisan migrate
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom([
            realpath(__DIR__ . '/../database/migrations')
        ]);
    }

    /**
    * Register the Chatting service provider.
    *
    * @return void
    */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BroadcastServiceProvider::class);

        $this->registerResources();
    }

    /**
     * Register the Chatting service resource namespaces.
     *
     * @return void
     */
    protected function registerResources()
    {
        // Translation must be registered ahead of adding lang namespaces
        $this->app->register(TranslationServiceProvider::class);

        Lang::addNamespace('chatting', realpath(__DIR__.'/../resources/lang'));

        View::addNamespace('chatting', base_path('resources/views/vendor/chatting'));
        View::addNamespace('chatting', realpath(__DIR__.'/../resources/views'));
    }
}
