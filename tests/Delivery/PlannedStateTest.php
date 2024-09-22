<?php

namespace App\Tests\Delivery;

use App\Enums\DeliveryStatusEnum;
use App\Exceptions\InvalidDeliveryStatusException;
use App\Models\Delivery;
use App\Services\Delivery\DeliveredState;
use App\Services\Delivery\PlannedState;
use App\Services\Delivery\ShippedState;
use App\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class PlannedStateTest extends TestCase
{
    public ?Delivery $delivery = null;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    public function testDeliveryCorrect()
    {
        $this->delivery = Delivery::factory()->create(['status' => DeliveryStatusEnum::SHIPPED->value]);
        $this->delivery->initializeState();
        $state = new PlannedState();
        $state->updateStatus($this->delivery, DeliveryStatusEnum::SHIPPED->value);
        $this->assertEquals(new ShippedState(), $this->delivery->getState());
        $this->assertEquals(DeliveryStatusEnum::SHIPPED->value, $this->delivery->status);
    }

    public function testNonCorrect()
    {
        $this->delivery = Delivery::factory()->create(['status' => DeliveryStatusEnum::DELIVERED->value]);
        $this->delivery->initializeState();
        $state = new PlannedState();
        $this->expectException(InvalidDeliveryStatusException::class);
        $state->updateStatus($this->delivery, DeliveryStatusEnum::DELIVERED->value);
        $this->assertEquals(DeliveryStatusEnum::DELIVERED->value, $this->delivery->status);
    }

}
