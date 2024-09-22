<?php

namespace App\Services\Delivery;

use App\Enums\DeliveryStatusEnum;
use App\Exceptions\InvalidDeliveryStatusException;
use App\Models\Delivery;

class PlannedState implements IDeliveryState
{
    public function updateStatus(Delivery $delivery, $status): void
    {
        if ($status != DeliveryStatusEnum::SHIPPED->value) {
            throw new InvalidDeliveryStatusException("Невозможно изменить статус с {$delivery->status} на {$status}.");
        }
        // Переход к состоянию "Shipped"
        $delivery->status = $status;
        $delivery->save();
        $delivery->setState(new ShippedState());
    }
}
