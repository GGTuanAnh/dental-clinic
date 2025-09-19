<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\BookingCreated;
use App\Listeners\QueueBookingWebhook;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BookingCreated::class => [
            QueueBookingWebhook::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
