<?php

namespace App\Services\Delivery;

use App\Models\Delivery;

interface IDeliveryState
{
    public function updateStatus(Delivery $delivery, $status): void;
}
