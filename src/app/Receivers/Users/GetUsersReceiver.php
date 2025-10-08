<?php

namespace App\Receivers\Users;

use App\Dtos\UserDto;
use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ResponseReceiver;

readonly class GetUsersReceiver extends ResponseReceiver
{
    public function __construct(
        protected int $status,
        protected array $users
    ) {}

    public static function fromResponse(Response $response): static
    {
        return new static(
            status: $response->status(),
            users: array_map(
                fn (array $user) => UserDto::fromArray($user),
                $response->json()
            )
        );
    }

    public function toSuccessResponse(): array
    {
        return [
            'message' => __('Users fetched successfully'),
            'data' => array_map(
                fn (UserDto $user) => $user->toArray(),
                $this->users
            ),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => __('Failed to fetch users'),
        ];
    }
}
