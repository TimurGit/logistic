<?php

namespace App\Services\Delivery;

use App\Exceptions\InvalidDeliveryStatusException;
use App\Models\Delivery;

class DeliveredState implements IDeliveryState
{
    public function updateStatus(Delivery $delivery, $status): void
    {
        // Нельзя больше изменять статус после доставки
        throw new InvalidDeliveryStatusException('Доставка уже завершена. Изменение статуса невозможно.');
    }
}
