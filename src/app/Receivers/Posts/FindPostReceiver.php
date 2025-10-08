<?php

namespace App\Receivers\Posts;

use App\Dtos\UserDto;
use Illuminate\Http\Client\Response;
use Raid\Caller\Receivers\ReceiverAbstract;

readonly class FindPostReceiver extends ReceiverAbstract
{
    public function __construct(
        protected int $status,
        protected array $users
    ) {}

    public static function fromResponse(Response $response): static
    {
        $data = $response->json();

        return new static(
            status: $response->status(),
            users: array_map(
                fn (array $item) => UserDto::fromArray($item),
                $data
            )
        );
    }

    public function toSuccessResponse(): array
    {
        return [
            'message' => 'Users fetched successfully',
            'data' => array_map(fn (UserDto $user) => $user->toArray(), $this->users),
        ];
    }

    public function toErrorResponse(): array
    {
        return [
            'message' => 'Failed to fetch users',
        ];
    }
}
