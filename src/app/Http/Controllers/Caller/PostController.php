<?php

namespace App\Http\Controllers\Caller;

use App\Callers\Posts\DeletePostCaller;
use App\Callers\Posts\FindPostCaller;
use App\Callers\Posts\GetPostsCaller;
use App\Callers\Posts\PatchPostCaller;
use App\Callers\Posts\StorePostCaller;
use App\Callers\Posts\UpdatePostCaller;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $receiver = GetPostsCaller::make(
            page: $request->query('page'),
            userId: $request->query('userId')
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function find(Request $request): JsonResponse
    {
        $receiver = FindPostCaller::make(
            id: $request->query('id', 1)
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function store(Request $request): JsonResponse
    {
        $receiver = StorePostCaller::make(
            userId: $request->query('userId', 1),
            title: $request->query('title', 'Default title'),
            body: $request->query('body', 'Default body')
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function update(Request $request): JsonResponse
    {
        $receiver = UpdatePostCaller::make(
            id: $request->query('id', 1),
            userId: $request->query('userId', 1),
            title: $request->query('title', 'Updated title'),
            body: $request->query('body', 'Updated body')
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function patch(Request $request): JsonResponse
    {
        $receiver = PatchPostCaller::make(
            id: $request->query('id', 1),
            userId: $request->query('userId'),
            title: $request->query('title'),
            body: $request->query('body')
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function delete(Request $request): JsonResponse
    {
        $receiver = DeletePostCaller::make(
            id: $request->query('id', 1)
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }
}
