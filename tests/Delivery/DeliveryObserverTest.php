<?php

namespace App\Tests\Delivery;

use App\Enums\DeliveryStatusEnum;
use App\Events\DeliveryDelivered;
use App\Models\Delivery;
use App\Observers\DeliveryObserver;
use App\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

class DeliveryObserverTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    public function testDeliveryDelivered()
    {
        // Создаем доставку со статусом "shipped"
        $delivery = Delivery::factory()->create(['status' => DeliveryStatusEnum::SHIPPED->value]);
        $delivery->initializeState();
        $delivery->updateStatus(DeliveryStatusEnum::DELIVERED->value);
        $observer = new DeliveryObserver();
        $observer->updated($delivery);
        // Проверяем, что событие DeliveryDelivered было вызвано
        Event::assertDispatched(DeliveryDelivered::class, function ($event) use ($delivery) {
            return $event->delivery->id === $delivery->id;
        });
    }

    public function testDeliveryNotDelivered()
    {
        $delivery = Delivery::factory()->create(['status' => DeliveryStatusEnum::PLANNED->value]);
        $delivery->initializeState();
        $delivery->updateStatus(DeliveryStatusEnum::SHIPPED->value);
        $observer = new DeliveryObserver();
        $observer->updated($delivery);
        Event::assertNotDispatched(DeliveryDelivered::class);
    }

    public function testDeliveryNotChangeStatus()
    {
        $delivery = Delivery::factory()->create(['status' => DeliveryStatusEnum::DELIVERED->value]);
        $delivery->initializeState();
        $observer = new DeliveryObserver();
        $observer->updated($delivery);
        Event::assertNotDispatched(DeliveryDelivered::class);
    }
}
