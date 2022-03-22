<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Events\OrderItemCreated;
use App\Events\OrderItemDeleted;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Listeners\CountOrderItemsAfterCreate;
use App\Listeners\CountOrderItemsAfterDelete;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderItemDeleted::class => [
            CountOrderItemsAfterDelete::class
        ],
        OrderItemCreated::class => [
            CountOrderItemsAfterCreate::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
