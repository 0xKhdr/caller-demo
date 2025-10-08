<?php

namespace App\Http\Controllers;

use App\Callers\FetchUserCaller;
use App\Receivers\FetchUserReceiver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Raid\Caller\Receivers\Contracts\Receiver;

class CallerController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        /** @var FetchUserReceiver $receiver */
        $receiver = FetchUserCaller::make(id: 1)->call();

        return $receiver->isSuccessResponse()
            ? $this->successResponse($receiver)
            : $this->errorResponse();
    }

    public function successResponse(Receiver $receiver): JsonResponse
    {
        return response()->json([
            'message' => 'Caller works!',
            'data' => [
                'user' => $receiver->getUser()->toArray(),
            ],
        ]);
    }

    public function errorResponse(): JsonResponse
    {
        return response()->json([
            'message' => 'Error calling caller!',
        ], 500);
    }
}
