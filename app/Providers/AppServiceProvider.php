<?php

namespace App\Providers;

use App\Domain\Consumer\PlayerDetailsView;
use App\Infrastructure\Repository\LaravelDBMessageRepository;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use EventSauce\EventSourcing\SynchronousMessageDispatcher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(MessageSerializer::class, ConstructingMessageSerializer::class);
        $this->app->bind(MessageRepository::class, LaravelDBMessageRepository::class);
        $this->app->bind(MessageDispatcher::class, function () {
            return new SynchronousMessageDispatcher();
//            return new SynchronousMessageDispatcher(new PlayerDetailsView());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
