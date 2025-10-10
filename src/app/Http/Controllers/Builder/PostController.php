<?php

namespace App\Http\Controllers\Builder;

use App\Dtos\PostDto;
use App\Http\Controllers\Controller;
use App\Services\AppUtility;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Http;
use Raid\Caller\Builders\Implementations\RequestBuilder;
use Raid\Caller\Middleware\RetryMiddleware;

class PostController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request): JsonResponse
    {
        $response = RequestBuilder::to(
            url: AppUtility::getJsonPlaceholderUrl('/posts'),
        )
            ->get()
            ->withMiddleware([
                RetryMiddleware::class,
            ])
            ->withQuery([
                '_page' => $request->query('page'),
            ])
            ->call()
            ->toDtoCollection(PostDto::class);

        dd($response);
    }

    public function find(Request $request): JsonResponse
    {
        $response = Http::get(
            url: AppUtility::getJsonPlaceholderUrl('/posts/'.$request->query('id', 1)),
        );

        $data = $response->successful()
            ? ['message' => 'Post fetched successfully', 'data' => $response->json()]
            : ['error' => 'Post not found'];

        return response()->json(
            data: $data,
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

        $data = $response->successful()
            ? ['message' => 'Post created successfully', 'data' => $response->json()]
            : ['error' => 'Failed to create post', 'data' => []];

        return response()->json(
            data: $data,
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

        $data = $response->successful()
            ? ['message' => 'Post updated successfully', 'data' => $response->json()]
            : ['error' => 'Failed to update post', 'data' => []];

        return response()->json(
            data: $data,
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

        $data = $response->successful()
            ? ['message' => 'Post patched successfully', 'data' => $response->json()]
            : ['error' => 'Failed to patch post', 'data' => []];

        return response()->json(
            data: $data,
            status: $response->status()
        );
    }

    public function delete(Request $request): JsonResponse
    {
        $response = Http::delete(
            url: AppUtility::getJsonPlaceholderUrl('/posts/'.$request->query('id', 1)),
        );

        $data = $response->successful()
            ? ['message' => 'Post deleted successfully']
            : ['error' => 'Failed to delete post'];

        return response()->json(
            data: $data,
            status: $response->status()
        );
    }

    public function benchmark(Request $request): JsonResponse
    {
        $benchmark = Benchmark::value(function () use ($request) {
            $response = Http::get(
                url: AppUtility::getJsonPlaceholderUrl('/posts'),
                query: array_filter([
                    '_page' => $request->query('page'),
                    'userId' => $request->query('userId'),
                ])
            );

            return $response->successful()
                ? ['message' => 'Posts fetched successfully', 'data' => $response->json()]
                : ['error' => 'Failed to fetch posts',  'data' => []];
        });

        return response()->json(
            data: ['time_ms' => number_format(last($benchmark), 4)]
        );
    }
}
