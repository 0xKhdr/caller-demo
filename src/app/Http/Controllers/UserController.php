<?php

namespace App\Http\Controllers;

use App\Callers\Users\FindUserCaller;
use App\Callers\Users\GetUsersCaller;
use App\Receivers\Users\FindUserReceiver;
use App\Receivers\Users\GetUsersReceiver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var GetUsersReceiver $receiver */
        $receiver = GetUsersCaller::make(
            page: $request->query('page')
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function find(Request $request): JsonResponse
    {
        /** @var FindUserReceiver $receiver */
        $receiver = FindUserCaller::make(
            id: $request->query('id', 1)
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }
}
