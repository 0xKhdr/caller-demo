<?php

namespace App\Http\Controllers;

use App\Callers\StorePostCaller;
use App\Receivers\StorePostReceiver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        /** @var StorePostReceiver $receiver */
        $receiver = StorePostCaller::make(
            userId: $request->input('userId'),
            title: $request->input('title'),
            body: $request->input('body')
        )->call();

        return response()->json(
            data: $receiver->toResponse(),
            status: $receiver->getStatus()
        );
    }
}
