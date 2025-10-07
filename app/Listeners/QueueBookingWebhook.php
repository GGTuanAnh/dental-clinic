<?php
namespace App\Listeners;

use App\Events\BookingCreated;
use App\Jobs\SendBookingWebhook;

class QueueBookingWebhook
{
    public function handle(BookingCreated $event): void
    {
        SendBookingWebhook::dispatch($event->appointment);
    }
}
