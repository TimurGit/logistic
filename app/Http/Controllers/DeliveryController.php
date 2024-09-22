<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidDeliveryStatusException;
use App\Http\Requests\Deliveries\ChangeStatusRequest;
use App\Services\DeliveryService;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends Controller
{
    public function statusChange(ChangeStatusRequest $request, DeliveryService $service, int $id): Response {
        try {
            $data = $request->onlyValidated(['status']);
            $service->changeStatus($id, $data['status'] ?? '');

        } catch (InvalidDeliveryStatusException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Произошла ошибка при обновлении статуса доставки.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'message' => 'Статус доставки был изменен',
        ], Response::HTTP_OK);
    }
}
