<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum DeliveryStatusEnum: string
{
    use EnumTrait;

    case PLANNED = 'planned';
    case SHIPPED = 'shipped';
    case DELIVERED = 'delivered';

    // Метод для проверки следующего допустимого статуса
    public function next(): ?self
    {
        return match($this) {
            self::PLANNED => self::SHIPPED,
            self::SHIPPED => self::DELIVERED,
            default => null,
        };
    }
}
