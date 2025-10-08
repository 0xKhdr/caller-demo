<?php

namespace App\Receivers;

use App\Dtos\UserDto;
use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ReceiverAbstract;

readonly class FetchUserReceiver extends ReceiverAbstract
{
    public function __construct(
        protected int $status,
        protected UserDto $user
    ) {}

    public static function fromResponse(Response $response): static
    {
        return new static(
            status: $response->status(),
            user: UserDto::fromResponse($response)
        );
    }

    public function toSuccessResponse(): array
    {
        return [
            'message' => 'User fetched successfully',
            'data' => $this->user->toArray(),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => 'Failed to fetch user',
        ];
    }

    public function isSuccessResponse(): bool
    {
        return parent::isSuccessResponse()
            && $this->user->has('id')
            && $this->user->has('username')
            && $this->user->has('companyName');
    }
}
