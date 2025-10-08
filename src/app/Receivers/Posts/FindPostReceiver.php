<?php

namespace App\Receivers\Posts;

use App\Dtos\PostDto;
use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ResponseReceiver;

readonly class FindPostReceiver extends ResponseReceiver
{
    public function __construct(
        protected int $status,
        protected PostDto $post
    ) {}

    public static function fromResponse(Response $response): static
    {
        return new static(
            status: $response->status(),
            post: PostDto::fromArray($response->json())
        );
    }

    public function toSuccessResponse(): array
    {
        return [
            'message' => 'Post found successfully',
            'data' => $this->post->toArray(),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => 'Failed to find post',
        ];
    }
}
