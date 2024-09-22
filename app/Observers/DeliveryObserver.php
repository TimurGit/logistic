<?php

namespace App\Observers;

use App\Enums\DeliveryStatusEnum;
use App\Events\DeliveryDelivered;
use App\Models\Delivery;

class DeliveryObserver
{
    /**
     * Handle the Delivery "created" event.
     */
    public function created(Delivery $delivery): void
    {
        //
    }

    /**
     * Handle the Delivery "updated" event.
     */
    public function updated(Delivery $delivery): void
    {
        if ($delivery->wasChanged('status') && $delivery->status === DeliveryStatusEnum::DELIVERED->value) {
            event(new DeliveryDelivered($delivery));
        }
    }

    /**
     * Handle the Delivery "deleted" event.
     */
    public function deleted(Delivery $delivery): void
    {
        //
    }

    /**
     * Handle the Delivery "restored" event.
     */
    public function restored(Delivery $delivery): void
    {
        //
    }

    /**
     * Handle the Delivery "force deleted" event.
     */
    public function forceDeleted(Delivery $delivery): void
    {
        //
    }
}
