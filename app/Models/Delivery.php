<?php

namespace App\Models;

use App\Enums\DeliveryStatusEnum;
use App\Exceptions\InvalidDeliveryStatusException;
use App\Services\Delivery\DeliveredState;
use App\Services\Delivery\IDeliveryState;
use App\Services\Delivery\PlannedState;
use App\Services\Delivery\ShippedState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RonasIT\Support\Traits\ModelTrait;

/**
 * Модель доставки
 *
 * @property int $id
 * @property string $status
 */
class Delivery extends Model
{
    use HasFactory;
    use ModelTrait;
    protected $fillable = [
      'status',
    ];

    private IDeliveryState $state;

    /**
     * Инициализирует состояние доставки на основе текущего статуса.
     *
     * @return void
     */
    public function initializeState(): void
    {
        $this->state = match($this->status) {
            DeliveryStatusEnum::PLANNED->value => new PlannedState(),
            DeliveryStatusEnum::SHIPPED->value => new ShippedState(),
            DeliveryStatusEnum::DELIVERED->value => new DeliveredState(),
        };
    }

    /**
     * Устанавливает новое состояние
     *
     * @param IDeliveryState $state
     * @return void
     */
    public function setState(IDeliveryState $state): void
    {
        $this->state = $state;
    }

    /**
     * Возвращает состояние
     *
     * @return IDeliveryState
     */
    public function getState(): IDeliveryState
    {
        return $this->state;
    }

    /**
     * Обновляет статус доставки
     *
     * @param $status
     * @return void
     */
    public function updateStatus($status): void
    {
        $this->state->updateStatus($this, $status);
    }
}
