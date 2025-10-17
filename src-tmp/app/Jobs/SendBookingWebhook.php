<?php
namespace App\Jobs;

use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBookingWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Appointment $appointment) {}

    public $backoff = [30, 60, 120];

    public function handle(): void
    {
        $url = config('services.booking_webhook.url');
        if(!$url) return; // no-op if not configured

        // Ensure relations exist (job may run later)
        $this->appointment->loadMissing(['patient','service']);

        $payload = [
            'id' => $this->appointment->id,
            'status' => $this->appointment->status,
            'service' => optional($this->appointment->service)->name,
            'appointment_at' => $this->appointment->appointment_at?->toIso8601String(),
            'note' => $this->appointment->note,
            'patient' => [
                'id' => $this->appointment->patient->id,
                'name' => $this->appointment->patient->name,
                'phone' => $this->appointment->patient->phone,
            ],
        ];

        try{
            Http::timeout(5)
                ->withHeaders(['X-Booking-Source' => 'public-site'])
                ->post($url, $payload)
                ->throw();
        }catch(\Throwable $e){
            $this->fail($e);
        }
    }
}
