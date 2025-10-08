<?php

namespace App\Receivers\Posts;

use App\Dtos\PostDto;
use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ResponseReceiver;

readonly class StorePostReceiver extends ResponseReceiver
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
            'message' => __('Post stored successfully'),
            'data' => $this->post->toArray(),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => __('Failed to store post'),
        ];
    }

    public function isSuccessResponse(): bool
    {
        return parent::isSuccessResponse()
            && $this->post->has('id')
            && $this->post->has('userId')
            && $this->post->has('title');
    }
}
