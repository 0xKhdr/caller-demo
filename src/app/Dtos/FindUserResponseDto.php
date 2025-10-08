<?php

namespace App\Dtos;

use Illuminate\Http\Client\Response;
use Raid\Caller\Dtos\ResponseDtoAbstract;

class FindUserResponseDto extends ResponseDtoAbstract
{
    public function __construct(
        protected readonly int $status,
        protected UserDto $user,
    ) {}

    public static function fromResponse(Response $response): static
    {
        return new static(
            status: $response->status(),
            user: UserDto::fromResponse($response),
        );
    }

    public function isSuccessResponse(): bool
    {
        return ($this->status >= 200 && $this->status < 300)
            && $this->getUser()->has('externalId')
            && $this->getUser()->has('username')
            && $this->getUser()->has('companyName');
    }

    public function getUser(): UserDto
    {
        return $this->user;
    }
}
