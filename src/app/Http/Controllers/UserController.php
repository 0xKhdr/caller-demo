<?php

namespace App\Http\Controllers;

use App\Callers\Users\FindUserCaller;
use App\Callers\Users\GetUsersCaller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $caller = GetUsersCaller::make(
            page: $request->query('page')
        );

        $receiver = $caller->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function find(Request $request): JsonResponse
    {
        $caller = FindUserCaller::make(
            id: $request->query('id', 1)
        );

        $receiver = $caller->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }
}
