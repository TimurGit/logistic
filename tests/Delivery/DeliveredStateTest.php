<?php

namespace App\Tests\Delivery;

use App\Enums\DeliveryStatusEnum;
use App\Exceptions\InvalidDeliveryStatusException;
use App\Models\Delivery;
use App\Services\Delivery\DeliveredState;
use App\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class DeliveredStateTest extends TestCase
{
    public ?Delivery $delivery = null;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    public function testNonCorrect()
    {
        $this->delivery = Delivery::factory()->create(['status' => DeliveryStatusEnum::DELIVERED->value]);
        $this->delivery->initializeState();
        $state = new DeliveredState();
        $this->expectException(InvalidDeliveryStatusException::class);
        $state->updateStatus($this->delivery, DeliveryStatusEnum::PLANNED->value);
        $this->assertEquals(DeliveryStatusEnum::DELIVERED->value, $this->delivery->status);
    }
}
