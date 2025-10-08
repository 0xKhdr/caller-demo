<?php

namespace App\Receivers\Posts;

use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ResponseReceiver;

readonly class DeletePostReceiver extends ResponseReceiver
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
            'message' => __('Post deleted successfully'),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => __('Failed to delete post'),
        ];
    }
}
