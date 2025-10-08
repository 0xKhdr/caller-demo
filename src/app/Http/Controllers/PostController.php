<?php

namespace App\Http\Controllers;

use App\Callers\Posts\DeletePostCaller;
use App\Callers\Posts\FindPostCaller;
use App\Callers\Posts\GetPostsCaller;
use App\Callers\Posts\PatchPostCaller;
use App\Callers\Posts\StorePostCaller;
use App\Callers\Posts\UpdatePostCaller;
use App\Receivers\Posts\DeletePostReceiver;
use App\Receivers\Posts\FindPostReceiver;
use App\Receivers\Posts\GetPostsReceiver;
use App\Receivers\Posts\PatchPostReceiver;
use App\Receivers\Posts\StorePostReceiver;
use App\Receivers\Posts\UpdatePostReceiver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        /** @var StorePostReceiver $receiver */
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

    public function index(Request $request): JsonResponse
    {
        /** @var GetPostsReceiver $receiver */
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
        /** @var FindPostReceiver $receiver */
        $receiver = FindPostCaller::make(
            id: $request->query('id', 1)
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }

    public function update(Request $request): JsonResponse
    {
        /** @var UpdatePostReceiver $receiver */
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
        /** @var PatchPostReceiver $receiver */
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
        /** @var DeletePostReceiver $receiver */
        $receiver = DeletePostCaller::make(
            id: $request->query('id', 1)
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }
}
