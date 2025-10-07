<?php

namespace Tests\Feature;

use App\Events\BookingCreated;
use App\Jobs\SendBookingWebhook;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Service::create(['name' => 'Tẩy trắng', 'price' => 0]);
        Doctor::unguarded(fn () => Doctor::create(['id' => 1, 'name' => 'BS. Demo']));
    }

    public function test_prevents_double_booking_within_same_slot(): void
    {
        $slot = Carbon::now()->addDay()->setHour(10)->setMinute(0);

        $patient = Patient::create(['name' => 'Nguyễn A', 'phone' => '0900000001']);
        Appointment::create([
            'patient_id' => $patient->id,
            'service_id' => Service::first()->id,
            'doctor_id' => 1,
            'appointment_at' => $slot,
            'status' => 'pending',
        ]);

        $response = $this->post(route('booking.store'), [
            'name' => 'Trần B',
            'phone' => '0900000002',
            'service_id' => Service::first()->id,
            'appointment_at' => $slot->copy()->addMinutes(15)->toDateTimeString(),
        ]);

        $response->assertSessionHasErrors('appointment_at');
        $this->assertSame(1, Appointment::count());
    }

    public function test_dispatches_webhook_job_when_booking_is_created(): void
    {
        Queue::fake();
        Event::fakeExcept([BookingCreated::class]);

        $slot = Carbon::now()->addDays(2)->setHour(14)->setMinute(30);

        $response = $this->post(route('booking.store'), [
            'name' => 'Phạm C',
            'phone' => '0900000003',
            'service_id' => Service::first()->id,
            'appointment_at' => $slot->toDateTimeString(),
            'note' => 'Khám lần đầu',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success');
        $this->assertSame(1, Appointment::count());

        Event::assertDispatched(BookingCreated::class);
        Queue::assertPushed(SendBookingWebhook::class);
    }
}
