<?php

namespace App\Http\Controllers;

use App\Events\DeliveryDelivered;
use App\Http\Requests\Request;
use App\Http\Resources\User\UserResource;
use App\Models\Delivery;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends Controller
{
    public function statusChange(Request $request, Delivery $delivery): ResponseFactory|Application|\Illuminate\Http\Response
    {
        // Плохой код, просто для первичного прохождения теста
        $delivery->status = $request->input('status');
        $delivery->save();

        return response('', Response::HTTP_OK);
    }
}
