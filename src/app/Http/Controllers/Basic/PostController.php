<?php

namespace App\Http\Controllers\Basic;

use App\Http\Controllers\Controller;
use App\Services\AppUtility;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $response = Http::get(
            url: AppUtility::getJsonPlaceholderUrl('/posts'),
            query: array_filter([
                '_page' => $request->query('page'),
                'userId' => $request->query('userId'),
            ])
        );

        return $response->successful()
            ? response()->json(
                data: $response->json(),
                status: $response->status()
            )
            : response()->json(
                data: ['error' => 'Failed to fetch posts'],
                status: $response->status()
            );
    }

    public function find(Request $request): JsonResponse
    {
        $response = Http::get(
            url: AppUtility::getJsonPlaceholderUrl('/posts/'.$request->query('id', 1)),
        );

        return $response->successful()
            ? response()->json(
                data: $response->json(),
                status: $response->status()
            )
            : response()->json(
                data: ['error' => 'Post not found'],
                status: $response->status()
            );
    }

    public function store(Request $request): JsonResponse
    {
        $response = Http::post(
            url: AppUtility::getJsonPlaceholderUrl('/posts'),
            data: [
                'userId' => $request->query('userId', 1),
                'title' => $request->query('title', 'Default title'),
                'body' => $request->query('body', 'Default body'),
            ],
        );

        return $response->successful()
            ? response()->json(
                data: $response->json(),
                status: $response->status()
            )
            : response()->json(
                data: ['error' => 'Failed to create post'],
                status: $response->status()
            );
    }

    public function update(Request $request): JsonResponse
    {
        $response = Http::put(
            url: AppUtility::getJsonPlaceholderUrl('/posts/'.$request->query('id', 1)),
            data: [
                'userId' => $request->query('userId', 1),
                'title' => $request->query('title', 'Updated title'),
                'body' => $request->query('body', 'Updated body'),
            ]
        );

        return $response->successful()
            ? response()->json(
                data: $response->json(),
                status: $response->status()
            )
            : response()->json(
                data: ['error' => 'Failed to update post'],
                status: $response->status()
            );
    }

    public function patch(Request $request): JsonResponse
    {
        $response = Http::patch(
            url: AppUtility::getJsonPlaceholderUrl('/posts/'.$request->query('id', 1)),
            data: array_filter([
                'userId' => $request->query('userId'),
                'title' => $request->query('title'),
                'body' => $request->query('body'),
            ])
        );

        return $response->successful()
            ? response()->json(
                data: $response->json(),
                status: $response->status()
            )
            : response()->json(
                data: ['error' => 'Failed to patch post'],
                status: $response->status()
            );
    }

    public function delete(Request $request): JsonResponse
    {
        $response = Http::delete(
            url: AppUtility::getJsonPlaceholderUrl('/posts/'.$request->query('id', 1)),
        );

        return $response->successful()
            ? response()->json(
                data: ['message' => 'Post deleted successfully'],
                status: $response->status()
            )
            : response()->json(
                data: ['error' => 'Failed to delete post'],
                status: $response->status()
            );
    }
}
