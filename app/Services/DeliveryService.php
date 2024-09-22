<?php

namespace App\Services;

use App\Repositories\DeliveryRepository;
use RonasIT\Support\Services\EntityService;

/**
 * @property DeliveryRepository $repository
 * @mixin DeliveryRepository
 */
class DeliveryService extends EntityService
{
    public function __construct()
    {
        $this->setRepository(DeliveryRepository::class);
    }

    public function changeStatus($id, $status)
    {
        $delivery = $this->repository->findBy('id', $id);
        $delivery->initializeState();
        $delivery->updateStatus($status);

        return $delivery;
    }

}
