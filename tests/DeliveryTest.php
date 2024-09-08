<?php

namespace App\Tests;

use App\Events\DeliveryDelivered;
use App\Models\Delivery;
use DB;
use Illuminate\Support\Facades\Event;

class DeliveryTest extends TestCase
{
    public ?Delivery $delivery = null;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();

        $this->delivery = Delivery::factory()->create();
    }

    public function testCorrectFlow()
    {
        // Отгрузка
        $response = $this->post('deliveries/' . $this->delivery->id . '/status-change', ['status' => 'shipped']);
        $response->assertOk();
        $this->assertDatabaseHas('deliveries', ['id' => $this->delivery->id, 'status' => 'shipped']);

        // Доставлен
        $response = $this->post('deliveries/' . $this->delivery->id . '/status-change', ['status' => 'delivered']);
        $response->assertOk();
        $this->assertDatabaseHas('deliveries', ['id' => $this->delivery->id, 'status' => 'delivered']);
    }
}
