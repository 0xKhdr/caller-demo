<?php

namespace App\Receivers\Posts;

use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ReceiverAbstract;

readonly class DeletePostReceiver extends ReceiverAbstract
{
    public function __construct(
        protected int $status
    ) {}

    public static function fromResponse(Response $response): static
    {
        return new static(
            status: $response->status()
        );
    }

    public function toSuccessResponse(): array
    {
        return [
            'message' => 'Post deleted successfully',
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => 'Failed to delete post',
        ];
    }
}
