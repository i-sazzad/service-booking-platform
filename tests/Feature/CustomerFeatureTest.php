<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Service;
use App\Models\Booking;

class CustomerFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_services()
    {
        Service::factory()->count(5)->create();

        $response = $this->getJson('/api/services');

        $response->assertStatus(200)
                 ->assertJsonStructure(['data', 'links', 'meta']);
    }

    /** @test */
    public function it_books_a_service()
    {
        $service = Service::factory()->create();

        $payload = [
            'customer_name' => 'John Doe',
            'phone' => '01700000000',
            'service_id' => $service->id,
            'scheduled_at' => now()->addDay()->toDateTimeString()
        ];

        $response = $this->postJson('/api/book', $payload);

        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'booking_id', 'status']);
                 
        $this->assertDatabaseHas('bookings', [
            'customer_name' => 'John Doe',
            'service_id' => $service->id,
        ]);
    }

    /** @test */
    public function it_returns_booking_status()
    {
        $service = Service::factory()->create();

        $booking = Booking::create([
            'customer_name' => 'Alice',
            'phone' => '01800000000',
            'service_id' => $service->id,
            'scheduled_at' => now()->addDay(),
        ]);

        $response = $this->getJson('/api/booking/' . $booking->id);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                    'booking_id' => $booking->id,
                    'customer_name' => 'Alice',
                    'status' => 'pending',
                    'service' => $service->name
                 ]);
    }
}
