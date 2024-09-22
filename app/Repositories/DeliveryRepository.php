<?php

namespace App\Repositories;

use App\Models\Delivery;
use RonasIT\Support\Repositories\BaseRepository;

/**
 * @property Delivery $model
*/
class DeliveryRepository extends BaseRepository
{
    public function __construct()
    {
        $this->setModel(Delivery::class);
    }
}
