<?php

namespace App\Receivers\Posts;

use App\Dtos\PostDto;
use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ReceiverAbstract;

readonly class UpdatePostReceiver extends ReceiverAbstract
{
    public function __construct(
        protected int $status,
        protected PostDto $post
    ) {}

    public static function fromResponse(Response $response): static
    {
        return new static(
            status: $response->status(),
            post: PostDto::fromResponse($response)
        );
    }

    public function toSuccessResponse(): array
    {
        return [
            'message' => 'Post updated successfully',
            'data' => $this->post->toArray(),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => 'Failed to update post',
        ];
    }
}
