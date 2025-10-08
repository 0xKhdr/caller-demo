<?php

namespace App\Receivers\Posts;

use App\Dtos\PostDto;
use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ReceiverAbstract;

readonly class GetPostsReceiver extends ReceiverAbstract
{
    public function __construct(
        protected int $status,
        protected array $posts
    ) {}

    public static function fromResponse(Response $response): static
    {
        $data = $response->json();

        return new static(
            status: $response->status(),
            posts: array_map(
                fn (array $item) => PostDto::fromArray($item),
                $data
            )
        );
    }

    public function toSuccessResponse(): array
    {
        return [
            'message' => __('Posts fetched successfully'),
            'data' => array_map(
                fn (PostDto $post) => $post->toArray(),
                $this->posts
            ),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => __('Failed to fetch posts'),
        ];
    }
}
