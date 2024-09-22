<?php

namespace App\Tests\Delivery;

use App\Enums\DeliveryStatusEnum;
use App\Exceptions\InvalidDeliveryStatusException;
use App\Models\Delivery;
use App\Services\Delivery\DeliveredState;
use App\Services\Delivery\ShippedState;
use App\Tests\TestCase;
use Illuminate\Support\Facades\Event;

class ShippedStateTest extends TestCase
{
    public ?Delivery $delivery = null;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();
    }

    /**
     * Обновляем статус на "delivered"
     *
     * @return void
     * @throws InvalidDeliveryStatusException
   */
    public function testCorrect()
    {
        $this->delivery = Delivery::factory()->create(['status' => DeliveryStatusEnum::SHIPPED->value]);
        $this->delivery->initializeState();
        $state = new ShippedState();
        $state->updateStatus($this->delivery, DeliveryStatusEnum::DELIVERED->value);
        $this->assertEquals(new DeliveredState(), $this->delivery->getState());
        $this->assertEquals(DeliveryStatusEnum::DELIVERED->value, $this->delivery->status);
    }

    public function testNonCorrect()
    {
        // Создаем доставку со статусом "SHIPPED"
        $this->delivery = Delivery::factory()->create(['status' => DeliveryStatusEnum::SHIPPED->value]);
        $this->delivery->initializeState();
        // Обновляем статус на "delivered"
        $state = new ShippedState();
        $this->expectException(InvalidDeliveryStatusException::class);
        $state->updateStatus($this->delivery, DeliveryStatusEnum::PLANNED->value);
        $this->assertEquals(DeliveryStatusEnum::SHIPPED->value, $this->delivery->status);
    }
}
