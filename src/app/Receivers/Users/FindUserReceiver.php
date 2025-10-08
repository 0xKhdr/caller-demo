<?php

namespace App\Receivers\Users;

use App\Dtos\UserDto;
use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ReceiverAbstract;

readonly class FindUserReceiver extends ReceiverAbstract
{
    public function __construct(
        protected int $status,
        protected UserDto $user
    ) {}

    public static function fromResponse(Response $response): static
    {
        return new static(
            status: $response->status(),
            user: UserDto::fromArray($response->json())
        );
    }

    public function toSuccessResponse(): array
    {
        return [
            'message' => __('User found successfully'),
            'data' => $this->user->toArray(),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => __('Failed to find user'),
        ];
    }
}
