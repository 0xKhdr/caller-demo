<?php

namespace App\Http\Controllers;

use App\Callers\Posts\DeletePostCaller;
use App\Callers\Posts\FindPostCaller;
use App\Callers\Posts\GetPostsCaller;
use App\Callers\Posts\PatchPostCaller;
use App\Callers\Posts\StorePostCaller;
use App\Callers\Posts\UpdatePostCaller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $caller = StorePostCaller::make(
            userId: $request->query('userId', 1),
            title: $request->query('title', 'Default title'),
            body: $request->query('body', 'Default body')
        );

        $receiver = $caller->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function index(Request $request): JsonResponse
    {
        $caller = GetPostsCaller::make(
            page: $request->query('page'),
            userId: $request->query('userId')
        );

        $receiver = $caller->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function find(Request $request): JsonResponse
    {
        $caller = FindPostCaller::make(
            id: $request->query('id', 1)
        );

        $receiver = $caller->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function update(Request $request): JsonResponse
    {
        $caller = UpdatePostCaller::make(
            id: $request->query('id', 1),
            userId: $request->query('userId', 1),
            title: $request->query('title', 'Updated title'),
            body: $request->query('body', 'Updated body')
        );

        $receiver = $caller->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function patch(Request $request): JsonResponse
    {
        $caller = PatchPostCaller::make(
            id: $request->query('id', 1),
            userId: $request->query('userId'),
            title: $request->query('title'),
            body: $request->query('body')
        );

        $receiver = $caller->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function delete(Request $request): JsonResponse
    {
        $caller = DeletePostCaller::make(
            id: $request->query('id', 1)
        );

        $receiver = $caller->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }
}
