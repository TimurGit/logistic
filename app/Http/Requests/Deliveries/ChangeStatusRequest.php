<?php

namespace App\Http\Requests\Deliveries;

use App\Enums\DeliveryStatusEnum;
use App\Http\Requests\Request;
use App\Services\DeliveryService;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChangeStatusRequest extends Request
{
    public function rules(): array
    {
        return [
            'status' => [Rule::enum(DeliveryStatusEnum::class)],
            'id' => 'integer|exists:id',
        ];
    }

    public function validateResolved(): void
    {
        parent::validateResolved();

        $service = app(DeliveryService::class);

        if (!$service->exists($this->route('id'))) {
            throw new NotFoundHttpException(__('validation.exceptions.not_found', ['entity' => 'Delivery']));
        }
    }
}
