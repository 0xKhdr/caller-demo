<?php

namespace App\Receivers\Posts;

use App\Dtos\PostDto;
use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ReceiverAbstract;

readonly class PatchPostReceiver extends ReceiverAbstract
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
            'message' => 'Post patched successfully',
            'data' => $this->post->toArray(),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => 'Failed to patch post',
        ];
    }
}
