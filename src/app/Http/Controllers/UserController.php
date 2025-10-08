<?php

namespace App\Http\Controllers;

use App\Callers\FetchUserCaller;
use App\Callers\FetchUsersCaller;
use App\Receivers\FetchUserReceiver;
use App\Receivers\FetchUsersReceiver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Raid\Caller\Receivers\Contracts\Receiver;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $receiver = FetchUsersCaller::make(
            page: $request->query('page', 1)
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function find(string $id): JsonResponse
    {
        $receiver = FetchUserCaller::make(
            id: $id
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }
}
