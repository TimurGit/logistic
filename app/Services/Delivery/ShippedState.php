<?php

namespace App\Services\Delivery;

use App\Enums\DeliveryStatusEnum;
use App\Exceptions\InvalidDeliveryStatusException;
use App\Models\Delivery;

class ShippedState implements IDeliveryState
{
    public function updateStatus(Delivery $delivery, $status): void
    {
        // Переход к состоянию "Delivered"
        if ($status != DeliveryStatusEnum::DELIVERED->value) {
            throw new InvalidDeliveryStatusException("Невозможно изменить статус с {$delivery->status} на {$status}.");
        }
        $delivery->status = $status;
        $delivery->save();
        $delivery->setState(new DeliveredState());
    }
}
